<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Laravel\Facades\Image;
use Spatie\ResponseCache\Facades\ResponseCache;

class MakeFilmsLive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'films:make-live
        {--skip-images : Do not attach a placeholder image (much faster)}
        {--force : Overwrite existing descriptions and images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo/testing helper: publish all films, give them placeholder descriptions and a placeholder image so they appear in the schedule.';

    private const SHORT_DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

    private const LONG_PARAGRAPHS = [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (app()->environment('production')) {
            $this->error('Refusing to run in production — this overwrites content with placeholders.');

            return self::FAILURE;
        }

        $force = (bool) $this->option('force');

        // 1. Publish everything so it passes the shownInProgramme / published gates.
        $published = Event::withoutGlobalScope('published')->update([
            'published' => true,
            'show_in_programme' => true,
        ]);
        $this->info("Marked {$published} films as published + shown in programme.");

        // 2. Prepare a single placeholder image, reused for every film.
        $placeholderPath = null;
        if (! $this->option('skip-images')) {
            $placeholderPath = $this->makePlaceholder();
        }

        // 3. Backfill descriptions and image per film.
        $events = Event::withoutGlobalScope('published')->get();
        $bar = $this->output->createProgressBar($events->count());
        $bar->start();

        foreach ($events as $event) {
            $dirty = false;

            if ($force || blank($event->description)) {
                $event->description = self::SHORT_DESCRIPTION;
                $dirty = true;
            }

            if ($force || blank($event->getRawOriginal('long_description'))) {
                $event->long_description = [
                    'time' => now()->valueOf(),
                    'blocks' => array_map(fn ($text) => [
                        'type' => 'paragraph',
                        'data' => ['text' => $text],
                    ], self::LONG_PARAGRAPHS),
                    'version' => '2.28.2',
                ];
                $dirty = true;
            }

            if ($dirty) {
                $event->save();
            }

            if ($placeholderPath && ($force || ! $event->featuredImage)) {
                if ($force) {
                    $event->clearMediaCollection('main');
                }
                $event->addMedia($placeholderPath)
                    ->preservingOriginal()
                    ->usingFileName('placeholder-film.jpg')
                    ->toMediaCollection('main');
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($placeholderPath) {
            @unlink($placeholderPath);
        }

        // 4. Bust caches so the changes show immediately.
        Cache::flush();
        ResponseCache::clear();
        $this->info('Caches cleared.');

        return self::SUCCESS;
    }

    /**
     * Generate a plain placeholder JPEG and return its temp path.
     */
    private function makePlaceholder(): string
    {
        $path = storage_path('app/placeholder-film.jpg');

        Image::create(1200, 800)
            ->fill('cfcfcf')
            ->save($path, quality: 80);

        return $path;
    }
}
