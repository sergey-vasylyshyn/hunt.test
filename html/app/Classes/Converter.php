<?php

namespace Classes;

require __DIR__.'/../../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Converter
{
    public static function convert(string $base, $amount) 
    {
        $currencies = self::getCourses();
        if ($base == 'RUB') {
            foreach ($currencies as $currency) {
                if ($currency->ccy == 'RUR') {
                    return $amount * $currency->buy;
                }
            }
        }
        else {
            return $amount;
        }
    }

    private static function getCourses() 
    {
        $config = include __DIR__.'/../../app/config/app.php';
        $client = new Client(
            ['headers' => [
            'headers' => [
              'Authorization' => 'Bearer ' . $config['token'],
            ]
            ]]
        );
        $request = new Request('GET', 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5');
        try {
            $response = $client->send($request, ['timeout' => 2]);
            return json_decode($response->getBody());
        }
        catch (\Exception $e) {
            return [];
        }
    }
}