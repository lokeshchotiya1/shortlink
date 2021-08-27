<?php

ini_set('memory_limit','1024M');
ini_set('max_input_vars','2000');
ini_set('upload_max_filesize','200M');
ini_set('post_max_size','200M');
ini_set('max_execution_time','0');
ini_set('max_input_time','1000');
ini_set('realpath_cache_size','100M');



/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';