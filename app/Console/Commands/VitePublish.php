<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VitePublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vite:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes assets to CDN';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Publishing assets to CDN');

        $buildFiles = File::allFiles(public_path('/build'));

        foreach ($buildFiles as $asset) {
            $this->info('Uploading asset to: build/' . $asset->getRelativePathname());
            Storage::disk('digitalocean')->put('build/' . $asset->getRelativePathname(), $asset->getContents());
        }

        $this->info('Vite assets published successfully');
    }
}
