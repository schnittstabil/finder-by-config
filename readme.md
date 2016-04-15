# FinderByConfig [![Build Status](https://travis-ci.org/schnittstabil/finder-by-config.svg?branch=master)](https://travis-ci.org/schnittstabil/finder-by-config) [![Coverage Status](https://coveralls.io/repos/schnittstabil/finder-by-config/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/finder-by-config?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/schnittstabil/finder-by-config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/schnittstabil/finder-by-config/?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/finder-by-config/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/finder-by-config)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/201a1d53-11a6-4b14-9509-8c2f248f09d5/big.png)](https://insight.sensiolabs.com/projects/201a1d53-11a6-4b14-9509-8c2f248f09d5)

> Create Symfony\Component\Finder instances by configuration

## Install

```
$ composer require schnittstabil/finder-by-config
```

## Usage

```json
{
    ...
    "require": {
        "schnittstabil/finder-by-config": ...
    },
    "extra": {
        "you/your-package": {
            "simple": ["src", "tests", "composer.json"],
            "extended": {
                "in": ["."],
                "name": ["*.php", "*.json"],
                "notName": ["*Test.php"],
                "size": ["> 1K"],
                "exclude": ["build", "vendor"],
                "ignoreDotFiles": true,
                "ignoreVCS": true,
                "followLinks": false,
                "ignoreUnreadableDirs": false
            }
        }
    }
}
```

```php
$config = json_decode(file_get_contents('composer.json'))->extra->{'you/your-package'};

$finder = \Schnittstabil\FinderByConfig\FinderByConfig::createFinder($config->simple);
$finder = \Schnittstabil\FinderByConfig\FinderByConfig::createFinder($config->extended);
```

## Supported configuration options

For details see the [Finder Component Documentation](https://symfony.com/doc/current/components/finder.html).

| Option                 | Type              | Description                                                   |
| ---------------------- | ----------------- | ------------------------------------------------------------- |
| `directories`          | `bool`            | directories only                                              |
| `files`                | `bool`            | files only                                                    |
| `depth`                | `string|string[]` | directory depth, e.g. `'> 1'`                                 |
| `date`                 | `string|string[]` | last modified [strtotime](http://php.net/manual/en/function.strtotime.php) parsable date, files must match e.g. `'>= 2005-10-15'` |
| `name`                 | `string|string[]` | regexp patterns, globs or simple strings files must match     |
| `notName`              | `string|string[]` | regexp patterns, globs or simple strings files must not match |
| `contains`             | `string|string[]` | pattern (string or regexp) file contents must match           |
| `notContains`          | `string|string[]` | pattern (string or regexp) file contents must not match       |
| `path`                 | `string|string[]` | regexp patterns, globs or simple strings files must match     |
| `notPath`              | `string|string[]` | regexp patterns, globs or simple strings files must not match |
| `size`                 | `string|string[]` | size files must match, e.g. `'<= 1Ki'`                        |
| `exclude`              | `string|string[]` | directories to exclude                                        |
| `ignoreDotFiles`       | `bool`            | exclude directories and files starting with a dot             |
| `ignoreVCS`            | `bool`            | exclude version control directories                           |
| `addVCSPattern`        | `string|string[]` | additional version control patterns                           |
| `sortByName`           | `bool`            | sorts by name                                                 |
| `sortByType`           | `bool`            | sorts by type                                                 |
| `sortByAccessedTime`   | `bool`            | sorts by the last accessed time                               |
| `sortByChangedTime`    | `bool`            | sorts by the last inode changed time                          |
| `sortByModifiedTime`   | `bool`            | sorts by the last modified time                               |
| `followLinks`          | `bool`            | follow symlinks                                               |
| `ignoreUnreadableDirs` | `bool`            | ignore unreadable directories                                 |
| `in`                   | `string|string[]` | directory and file paths                                      |

## License

MIT © [Michael Mayer](http://schnittstabil.de)
