<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
//    'doctrine' => [
//        'connection' => [
//            'orm_default' => [
//                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
//                'params' => [
//                   'path'    => __DIR__ . '/../../data/terminals_allowed.db',                   
//                ]
//            ],            
//        ],        
//    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params'        => [
                    'host'     => 'us-cdbr-east-04.cleardb.com',
                    'port'     => '3306',
                    'user'     => 'b378b095c5772d',
                    'password' => 'f206e1cd',
                    'dbname'   => 'heroku_b5236aa35d6f1f8',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8',
                    ],
                ],
            ],
        ]
    ]
];
