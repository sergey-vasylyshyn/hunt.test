<?php

require __DIR__.'/vendor/autoload.php';

$db_config = include __DIR__.'/app/config/db.php';
$db = new MysqliDb($db_config['host'], $db_config['user'], $db_config['password'], $db_config['db']);
$config = include __DIR__.'/app/config/app.php';

$budgets = $db->rawQuery(
    '
SELECT COUNT(id) AS budget_count FROM `projects` WHERE budget < 500
UNION
SELECT COUNT(id) AS budget_count FROM `projects` WHERE budget > 500 AND budget < 1000
UNION
SELECT COUNT(id) AS budget_count FROM `projects` WHERE budget > 1000 AND budget < 5000
UNION
SELECT COUNT(id) AS budget_count FROM `projects` WHERE budget > 5000'
);
$total = 0;
foreach ($budgets as $budget) {
    $total += $budget['budget_count'];
}
require_once 'templates/pie_chart.php';
