<?php

use RetailCrm\Api\Client;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Model\Request\Orders\OrdersRequest;
use RetailCrm\Api\Model\Response\Orders\OrdersResponse;

function getOrdersFromPage(Client $client, int $page = 1): OrdersResponse
{
    $request = new OrdersRequest();
    $request->page = $page;

    try {
        $response = $client->orders->list($request);
    } catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
        echo $exception;
        exit(-1);
    }

    return $response;
}
