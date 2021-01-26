<?php
require_once "config.php";
require_once "vendor/autoload.php";

use app\models\MoedasApi;

$moeda = filter_input(INPUT_POST, 'moeda');

$array = [];

if(!empty($moeda)) {

    $moedaApi = new MoedasApi();
    $data = $moedaApi->getMoeda($moeda);

    $array = [
        'error' => '',
        'name' => $data->name,
        'price' => $data->price,
        'date' => $data->date,
        'hour' => $data->hour,
        'lastDays' => $data->lastDays
    ];
} else {
    $array['error'] = 'variavel moeda está vazia!';
}


header("Content-Type: application/json");
echo json_encode($array);
exit;