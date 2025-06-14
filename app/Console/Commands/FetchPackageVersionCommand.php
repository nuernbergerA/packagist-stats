<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Support\GetMinMaxVersion;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class FetchPackageVersionCommand extends Command
{
    protected $signature = 'fetch-package-version';

    protected $description = 'Fetches the version string for a package';

    public function handle(): int
    {
        Package::query()
            ->each($this->processPackage(...), 10);

        return self::SUCCESS;
    }

    protected function processPackage(Package $package): void
    {
        $this->components->info('Fetched version for package: ' . $package->name);

        $result = Http::acceptJson()
            ->withUrlParameters(['package' => $package->name])
            ->get('https://repo.packagist.org/p2/{package}.json')
            ->json('packages')[$package->name][0] ?? [];

        $version = data_get($result, 'require.php') ?? data_get($result, 'require.php-64bit');

        if ($version) {
            [$min, $max] = resolve(GetMinMaxVersion::class)($version);

            $package->fill([
                'version_string' => $version,
                'min_version' => $min,
                'max_version' => $max,
            ]);
        }

        $package->update([
            'type' => data_get($result, 'type'),
            'last_released_at' => Carbon::parse(data_get($result, 'time')),
            'checked_at' => now(),
        ]);
    }
}
