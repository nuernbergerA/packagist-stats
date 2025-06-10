<?php

namespace App\Support;

use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\VersionParser;

class GetMinMaxVersion
{
    public function __invoke(string $versionConstraint): array
    {
        $parser = new VersionParser;
        $constraint = $parser->parseConstraints($versionConstraint);

        $supportedVersion = collect([
            '5.3',
            '5.4',
            '5.5',
            '5.6',
            '7.0',
            '7.1',
            '7.2',
            '7.3',
            '7.4',
            '8.0',
            '8.1',
            '8.2',
            '8.3',
            '8.4',
        ])
            ->mapWithKeys(fn(string $version) => [
                $version => $parser->parseConstraints($version)
            ])
            ->filter(fn(ConstraintInterface $version) => $constraint->matches($version))
            ->keys();

        return [$supportedVersion->min(), $supportedVersion->max()];
    }
}
