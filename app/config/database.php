<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * Database configuration
 */

$database['main'] = array(
    // Database driver
    'driver' => getenv('DB_DRIVER') ?: 'mysql',

    // Aiven MySQL hostname
    'hostname' => getenv('DB_HOST') ?: '',

    // Aiven MySQL port
    'port' => getenv('DB_PORT') ?: '3306',

    // Support both DB_USER and DB_USERNAME
    'username' => getenv('DB_USER') ?: (getenv('DB_USERNAME') ?: ''),

    // Database password
    'password' => getenv('DB_PASSWORD') ?: '',

    // Database name
    'database' => getenv('DB_NAME') ?: '',

    // Character set
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',

    // Table prefix
    'dbprefix' => getenv('DB_PREFIX') ?: '',

    // Optional for SQLite
    'path' => ''
);

?>