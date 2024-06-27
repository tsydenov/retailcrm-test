<?php

use RetailCrm\Api\Factory\SimpleClientFactory;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils.php';

$client = SimpleClientFactory::createClient('https://dimm.retailcrm.ru', '');

$response = getOrdersFromPage($client);
$totalPageCount = $response->pagination->totalPageCount;

$itemsData = [];
for ($i = 1; $i <= $totalPageCount; $i++) {
    $response = getOrdersFromPage($client, $i);

    foreach ($response->orders as $order) {
        foreach ($order->items as $item) {

            if (array_key_exists($item->offer->id, $itemsData)) {
                $itemsData[$item->offer->id]["quantity"] += $item->quantity;
                $itemsData[$item->offer->id]["totalSum"] += $item->initialPrice * $item->quantity;
            } else {
                $itemsData[$item->offer->id] = [
                    "quantity" => $item->quantity,
                    "totalSum" => $item->initialPrice * $item->quantity,
                    "name" => $item->offer->displayName,
                ];
            }
        }
    }
}

$maxTotalSum = 0;
$maxQuantity = 0;

foreach ($itemsData as $item) {
    if ($item["quantity"] > $maxQuantity) {
        $maxQuantity = $item["quantity"];
        $topItemByQuantity = $item["name"];
    }
    if ($item["totalSum"] > $maxTotalSum) {
        $maxTotalSum = $item["totalSum"];
        $topItemByTotalSum = $item["name"];
    }
}

echo "Топ товар по количеству в заказах: $topItemByQuantity -  $maxQuantity\n";
echo "Топ товар по сумме в заказах: $topItemByTotalSum - $maxTotalSum\n";
