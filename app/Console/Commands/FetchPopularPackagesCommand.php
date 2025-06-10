<?php

namespace App\Console\Commands;

use App\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchPopularPackagesCommand extends Command
{
    protected $signature = 'fetch-popular-packages';

    protected $description = 'Fetch top 1000 packages from packagist.org';

    public function handle(): int
    {
        foreach (range(1, 10) as $page) {
            $packages = Http::acceptJson()
                ->get('https://packagist.org/explore/popular.json', [
                    'per_page' => 100,
                    'page' => $page,
                ])
                ->collect('packages')
                ->map(fn($package) => [
                    'name' => $package['name'],
                    'downloads' => $package['downloads'],
                    'favers' => $package['favers'],
                ]);

            Package::query()
                ->upsert($packages->toArray(), ['name'], ['name', 'downloads', 'favers']);
        }

        return self::SUCCESS;
    }
}
