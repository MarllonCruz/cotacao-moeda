<?php
require_once "config.php";
require_once "vendor/autoload.php";

use app\models\MoedasApi;

$moedas = new MoedasApi();
$allMoedas = $moedas->getAllMoedas();
$moedaInicial = $moedas->getMoeda('USD-BRL');

$label = [];
$data  = [];
foreach($moedaInicial->lastDays as $item) {
    $label[] = "'".$item['date']."'";
    $data[]  = number_format($item['price'], 2);
}

include_once "includes/header.php";
include_once "includes/listagem.php";

//script das listagem e grafico
require_once "listagem-script.php";

include_once "includes/footer.php";
