<?php

namespace Tests\Unit;

use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\VersionParser;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $version = '>=7.2';


// $version = '^8.1 || ^8.2 || ^8.3 || ^8.4';

        $parser = new VersionParser;

        $constraint = $parser->parseConstraints($version);

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
        dump([$supportedVersion->min(), $supportedVersion->max()]);
    }
}
