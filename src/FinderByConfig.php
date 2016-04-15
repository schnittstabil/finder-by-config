<?php

namespace Schnittstabil\FinderByConfig;

use function Schnittstabil\Get\getValue;
use Symfony\Component\Finder\Finder;

class FinderByConfig
{
    protected function createFromArray(array $paths)
    {
        $finder = new Finder();
        $files = [];
        $dirs = [];

        foreach ($paths as $path) {
            if (is_file($path)) {
                $files[] = $path;
                continue;
            }

            $dirs[] = $path;
        }

        return $finder->append($files)->in($dirs);
    }

    protected function setWithoutValueOptions(Finder $finder, $config)
    {
        foreach ([
            'directories',
            'files',
            'sortByName',
            'sortByType',
            'sortByAccessedTime',
            'sortByChangedTime',
            'sortByModifiedTime',
            'followLinks',
        ] as $setter) {
            if (filter_var(getValue($setter, $config), FILTER_VALIDATE_BOOLEAN)) {
                $finder->$setter();
            }
        }
    }

    protected function setArrayOptions(Finder $finder, $config)
    {
        foreach ([
            'depth',
            'date',
            'name',
            'notName',
            'contains',
            'notContains',
            'path',
            'notPath',
            'size',
            'exclude',
            'addVCSPattern',
        ] as $setter) {
            foreach ((array) getValue($setter, $config, []) as $value) {
                $finder->$setter($value);
            }
        }
    }

    protected function setStrictBoolOptions(Finder $finder, $config)
    {
        foreach ([
            'ignoreDotFiles',
            'ignoreVCS',
            'ignoreUnreadableDirs',
        ] as $setter) {
            $value = getValue($setter, $config);
            if ($value !== null) {
                $finder->$setter(filter_var($value, FILTER_VALIDATE_BOOLEAN));
            }
        }
    }

    protected function createFromConfig($config)
    {
        $finder = $this->createFromArray((array) getValue('in', $config));
        $this->setWithoutValueOptions($finder, $config);
        $this->setArrayOptions($finder, $config);
        $this->setStrictBoolOptions($finder, $config);

        return $finder;
    }

    public function __invoke($config)
    {
        if (getValue('in', $config) === null) {
            return $this->createFromArray((array) $config);
        }

        return $this->createFromConfig($config);
    }

    public static function createFinder($config)
    {
        $finderByConfig = new static();

        return $finderByConfig($config);
    }
}
