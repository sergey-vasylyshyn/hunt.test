<?php

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(
    function ($class_name) {
        include __DIR__ . '/app/' . str_replace('\\', '/', $class_name) . '.php';
    }
);

use GuzzleHttp\Client;
use Classes\Converter;
use Classes\Db;

// TODO: move to class Parser.
$client = new Client(
    [
    // Base URI is used with relative requests
    'base_uri' => 'https://api.freelancehunt.com/v2/',
    // You can set any number of default request options.
    'timeout'  => 5.0,
    ]
);

$config = include __DIR__.'/app/config/app.php';

set_time_limit(0);
if ($config['parse_pages'] === 0) {
    echo 'No pages amount specified or zero. Check config file.';
}

$projects = [];
// TODO: make guzzle run with pool.
for ($i = 0; $i < $config['parse_pages']; $i++) {
    $response = $client->request(
        'GET', 'projects', [
        'headers' => [
            'Authorization' => 'Bearer ' . $config['token'],
        ],
        'query' => [
            // Needed skills: PHP, Web programming, Databases
            'filter[skill_id]' => '1,99,86',
            'page[number]' => $i,
        ],
        ]
    );

    // TODO: catch timeout error

    $rows = json_decode($response->getBody());
    if (!empty($rows->data)) {
        foreach ($rows->data as $row) {
            $item = [
                'p_id' => $row->id,
                'name' => $row->attributes->name,
                'link' => $row->links->self->web,
                'employer_name' => $row->attributes->employer->first_name,
                'employer_login' => $row->attributes->employer->login,
                'budget' => 0,
            ];

            if (!empty($row->attributes->budget)) {
                $budget = $row->attributes->budget;
                $item['budget'] = Converter::convert($budget->currency, $budget->amount);
            }
            $projects[] = $item;
        }
    }
}

if (!empty($projects)) {
    $db = new Db();
    $ids = $db->refreshData($projects);
    if(!$ids) {
        echo 'insert failed: ' . $db->getLastError();
    }
    echo 'New projects were added.';
    return;
}

echo 'No projects were added.';
