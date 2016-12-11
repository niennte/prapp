<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Doctrine\DBAL\Driver\PDOSqlite\Driver as PDOSqliteDriver;
// \PDOSqlite\Driver as PDOSqliteDriver;

/*return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => sprintf('sqlite:%s/data/db.db', realpath(getcwd())),
    ],
];*/

return [
    'doctrine' => [
        // migrations configuration
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOSqliteDriver::class,
                'params' => ['path' =>  __DIR__.'/../../data/db.db'],
            ],
        ],
    ],
];



/*
 'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    'path/to/my/entities',
                    'another/path',
                ],
            ],
 */

/*return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOSqliteDriver::class,
                'params' => ['path' =>  __DIR__.'/../../data/db.db'],
            ],
        ],
    ],
];*/
