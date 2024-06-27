<?php

require_once __DIR__ . '/vendor/autoload.php';

use RetailCrm\Api\Interfaces\ClientExceptionInterface;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Model\Entity\Tasks\Task;
use RetailCrm\Api\Model\Request\Tasks\TasksCreateRequest;

$client = SimpleClientFactory::createClient('https://dimm.retailcrm.ru', '');

$taskText = "Проверить тестовое задание\nФамилия Имя исполнителя\nСсылка на код";

$tasksRequest = new TasksCreateRequest();
$tasksRequest->task = new Task();
$tasksRequest->task->performerId = 6;
$tasksRequest->task->text = $taskText;
$tasksRequest->site = 'test';

try {
    $tasksResponse = $client->tasks->create($tasksRequest);
} catch (ApiExceptionInterface | ClientExceptionInterface $exception) {
    echo $exception;
    exit(-1);
}

echo 'Created task with ID: ' . $tasksResponse->id;
