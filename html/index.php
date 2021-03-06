<?php

// TODO: Make all requests through one endpoint to not autoload each time.
require __DIR__.'/vendor/autoload.php';
spl_autoload_register(
    function ($class_name) {
        include __DIR__ . '/app/' . str_replace('\\', '/', $class_name) . '.php';
    }
);

use JasonGrimes\Paginator;
use Classes\Db;

$db = new Db();
$config = include __DIR__.'/app/config/app.php';

$currentPage = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) { $currentPage = $_GET['page']; 
}

$projects = $db->getFromTo(
    $currentPage === 1 ? 0 : $config['table_items_count'] * $currentPage,
    $config['table_items_count']
);

// TODO: make htaccess clean urls
$urlPattern = '/index.php?page=(:num)';

$paginator = new Paginator(
    count($db->getAll()) - $config['table_items_count'],
    $config['table_items_count'],
    $currentPage,
    $urlPattern);

require_once 'templates/table.php';
?>