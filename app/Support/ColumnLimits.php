<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Schema-aware string truncation for imported data.
 *
 * Spektrix values are written straight into fixed-width columns; anything longer
 * than its column throws "Data too long" and fails the whole import. This caps
 * each string value to its column's character limit so the import can't fail on
 * length, while logging every truncation so the offending source can be spotted.
 */
class ColumnLimits
{
    /**
     * Cached [table => [column => max length|null]] to avoid repeated schema
     * introspection during a single import run.
     *
     * @var array<string, array<string, int|null>>
     */
    private static array $cache = [];

    /**
     * Truncations seen since the last report, as [table.column => [value, ...]].
     *
     * Collected rather than logged inline: the same handful of over-long values
     * arrive on every hourly import, so a line per truncation re-reported the
     * same few facts forever. Locally that was 47 log lines describing one.
     *
     * @var array<string, array<int, string>>
     */
    private static array $truncations = [];

    /**
     * The character limit for a column, or null if it has no length-bound type
     * (e.g. text/integer/boolean) or does not exist.
     */
    public static function length(string $table, string $column): ?int
    {
        if (! isset(self::$cache[$table])) {
            self::$cache[$table] = [];

            foreach (Schema::getColumns($table) as $definition) {
                // $definition["type"] looks like "varchar(50)", "char(2)", "text", "int", ...
                preg_match('/^(?:var)?char\((\d+)\)/i', $definition['type'] ?? '', $matches);
                self::$cache[$table][$definition['name']] = isset($matches[1])
                    ? (int) $matches[1]
                    : null;
            }
        }

        return self::$cache[$table][$column] ?? null;
    }

    /**
     * Truncate a single value to fit its column, or return it unchanged when it
     * already fits / has no character limit / is not a string.
     */
    public static function fitValue(string $table, string $column, mixed $value): mixed
    {
        $length = self::length($table, $column);

        if (! is_string($value) || $length === null || mb_strlen($value) <= $length) {
            return $value;
        }

        // Str::limit appends the ending (1 char) inside the limit, so cap at $length - 1.
        $truncated = Str::limit($value, $length - 1, '…');

        self::$truncations["{$table}.{$column}"][] = $value;

        return $truncated;
    }

    /**
     * Return the attributes array with every string value truncated to fit its
     * column. Non-string values and columns without a character limit are left
     * untouched.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public static function fit(string $table, array $attributes): array
    {
        foreach ($attributes as $column => $value) {
            $attributes[$column] = self::fitValue($table, $column, $value);
        }

        return $attributes;
    }

    /**
     * Log one line per affected column summarising the run's truncations, then
     * reset. Call at the end of an import.
     */
    public static function reportTruncations(): void
    {
        foreach (self::$truncations as $target => $values) {
            $distinct = array_values(array_unique($values));

            Log::channel('spektrix')->warning(
                sprintf(
                    'Truncated %d value(s) in %s (%d distinct)',
                    count($values),
                    $target,
                    count($distinct)
                ),
                ['examples' => array_slice($distinct, 0, 5)]
            );
        }

        self::$truncations = [];
    }
}
