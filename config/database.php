<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    //'default' => env('DB_CONNECTION', 'sqlsvr'),
    //AC 'default' => 'sqlsvr',
    'default' => 'pgsql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

 'virgo_ming' => [
            //'driver'   => 'dblib',
            'driver'   => 'pgsql',
            'odbc'     => false,
        //    'host'     => 'virgo.lib.uci.edu',
            'host'     => 'cygnus.lib.uci.edu',
            'port'     => 5432,
            'database' => 'mingTitles_production',
            'username' => 'mingtitles',
        //    'password' => 'PfQBuRVyaQOFgUcSj2cp',
            'password' => 'PfQBuRVyaQOFgUcSj2cp',
            'prefix'   => ''
        ], // virgo_mingTitles_production


    ], // connections


]; // return
