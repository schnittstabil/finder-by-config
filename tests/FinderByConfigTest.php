<?php

namespace Schnittstabil\FinderByConfig;

class FinderByConfigTest extends \PHPUnit\Framework\TestCase
{
    protected static $config;

    public static function setUpBeforeClass()
    {
        static::$config = json_decode(file_get_contents('composer.json'))->extra->{'you/your-package'};
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testSimpleUsageShouldWork()
    {
        $finder = \Schnittstabil\FinderByConfig\FinderByConfig::createFinder(static::$config->simple);

        $files = array_map(function ($file) {
            return $file->getPathname();
        }, array_values(iterator_to_array($finder)));

        sort($files);

        $this->assertSame([
            'composer.json',
            'src/FinderByConfig.php',
        ], $files);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testExtendedUsageShouldWork()
    {
        $finder = \Schnittstabil\FinderByConfig\FinderByConfig::createFinder(static::$config->extended);

        $files = array_map(function ($file) {
            return $file->getPathname();
        }, array_values(iterator_to_array($finder)));

        $this->assertSame([
            './composer.json',
            './src/FinderByConfig.php',
        ], $files);
    }

    public function testInStringShouldWork()
    {
        $fbc = new FinderByConfig();
        $finder = $fbc(static::$config->{'in-string'});

        $files = array_map(function ($file) {
            return $file->getPathname();
        }, array_values(iterator_to_array($finder)));

        $this->assertSame([
            'tests/fixtures/file.json',
        ], $files);
    }
}
