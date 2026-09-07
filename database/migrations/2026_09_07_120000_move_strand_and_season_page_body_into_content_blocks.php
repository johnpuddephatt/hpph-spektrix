<?php

use App\Cache\ContentCache;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Strand and season pages used to render their introduction, flex pass and
 * what's on slider from the Blade template, above whatever blocks an editor
 * had added. Those three are blocks now.
 *
 * A page keeps rendering as it did if it either has no blocks at all — in
 * which case it falls back to the same three at render time, see
 * App\Models\Concerns\HasProgrammePageContent — or has them written in at the
 * front, which is what this does.
 *
 * The introduction block also takes over the additional description and
 * funders logo, so a page carrying either has to be written out even when it
 * has no blocks of its own, or the values would no longer be reachable. The
 * columns are left in place; nothing reads them any more.
 */
return new class extends Migration
{
    protected array $defaults = [
        'programme-introduction',
        'ticket-subscription-group',
        'programme-slider',
    ];

    public function up(): void
    {
        foreach (['strands', 'seasons'] as $table) {
            foreach (DB::table($table)->get() as $row) {
                $blocks = $this->blocksOf($row);
                $intro = array_filter([
                    'additional_description' => $row->additional_description,
                    'funders_logo' => $row->funders_logo,
                ], fn ($value) => filled($value));

                // A page with neither blocks nor introduction content of its
                // own is left empty on purpose: the render-time fallback
                // already gives it the standard arrangement, and every strand
                // and season the Spektrix import creates from here arrives
                // that way too.
                if ($blocks === null && $intro === []) {
                    continue;
                }

                $this->write($table, $row->id, array_merge(
                    $this->defaultBlocks($intro),
                    $blocks ?? []
                ));
            }
        }

        ContentCache::clear();
    }

    public function down(): void
    {
        foreach (['strands', 'seasons'] as $table) {
            foreach (DB::table($table)->get() as $row) {
                if (($blocks = $this->blocksOf($row)) === null) {
                    continue;
                }

                $this->write($table, $row->id, $this->withoutLeadingDefaults($blocks));
            }
        }

        ContentCache::clear();
    }

    /**
     * Drop only the run of default blocks this migration put at the front.
     * Matching on layout name alone would also take a block an editor added
     * by hand further down — Hyde & Seek, for one, has its own hand-picked
     * ticket subscriptions block after the defaults.
     */
    protected function withoutLeadingDefaults(array $blocks): array
    {
        foreach ($this->defaults as $layout) {
            if (($blocks[0]['layout'] ?? null) !== $layout) {
                break;
            }

            array_shift($blocks);
        }

        return array_values($blocks);
    }

    protected function defaultBlocks(array $introAttributes): array
    {
        return array_map(fn ($layout) => [
            'layout' => $layout,
            'key' => Str::random(16),
            'attributes' => $layout === 'programme-introduction' && $introAttributes !== []
                ? $introAttributes
                : new stdClass(),
        ], $this->defaults);
    }

    /**
     * A row's blocks, or null when it has none. Content that is not a list is
     * the pre-flexible object shape, which flexible content already discards
     * as empty, so it counts as none.
     */
    protected function blocksOf($row): ?array
    {
        $blocks = json_decode($row->content ?? '', true);

        return is_array($blocks) && $blocks !== [] && array_is_list($blocks)
            ? $blocks
            : null;
    }

    protected function write(string $table, $id, array $blocks): void
    {
        DB::table($table)->where('id', $id)->update(['content' => json_encode($blocks)]);
    }
};
