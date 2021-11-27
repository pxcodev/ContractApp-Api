<?php

/** @var \Laravel\Lumen\Routing\Router $router */



$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'contracts'], function () use ($router) {
    $router->get('/', 'ContractCtrl@index');
    $router->get('/trash', 'ContractCtrl@trash');
    $router->get('/trash/{id}', 'ContractCtrl@recover');
    $router->get('/contract/{id}', 'ContractCtrl@search');
    $router->post('/', 'ContractCtrl@save');
    $router->delete('/{id}', 'ContractCtrl@delete');
    $router->post('/contract/{id}', 'ContractCtrl@update');
});

$router->group(['prefix' => 'payments'], function () use ($router) {
    $router->get('/', 'PaymentCtrl@index');
    $router->get('/trash', 'PaymentCtrl@trash');
    $router->get('/trash/{id}', 'PaymentCtrl@recover');
    $router->get('/{id}', 'PaymentCtrl@search');
    $router->post('/', 'PaymentCtrl@saveBase64');
    $router->delete('/{id}', 'PaymentCtrl@delete');
    $router->post('/{id}', 'PaymentCtrl@update');
});

$router->group(['prefix' => 'contracts/status'], function () use ($router) {
    $router->get('/', 'ContractStatusCtrl@index');
    $router->get('/{id}', 'ContractStatusCtrl@search');
    $router->post('/', 'ContractStatusCtrl@save');
    $router->delete('/{id}', 'ContractStatusCtrl@delete');
    $router->post('/{id}', 'ContractStatusCtrl@update');
});

$router->group(['prefix' => 'contracts/types'], function () use ($router) {
    $router->get('/', 'ContractTypeCtrl@index');
    $router->get('/{id}', 'ContractTypeCtrl@search');
    $router->post('/', 'ContractTypeCtrl@save');
    $router->delete('/{id}', 'ContractTypeCtrl@delete');
    $router->post('/{id}', 'ContractTypeCtrl@update');
});

$router->group(['prefix' => 'assistances'], function () use ($router) {
    $router->get('/', 'AssistanceCtrl@index');
    $router->post('/', 'AssistanceCtrl@save');
    $router->get('/contracts', 'AssistanceCtrl@contractsAssistances');
    $router->get('/workers', 'AssistanceCtrl@workersAssistances');
    $router->post('/indexDateFilter', 'AssistanceCtrl@indexDateFilter');
    $router->get('/searchAssistancesWorker/{id}', 'AssistanceCtrl@searchAssistancesWorker');
    $router->get('/searchAssistancesContract/{id}', 'AssistanceCtrl@searchAssistancesContract');

    $router->get('/{id}/{assistance}', 'AssistanceCtrl@update');
});

$router->group(['prefix' => 'workers'], function () use ($router) {
    $router->get('/', 'WorkerCtrl@index');
    $router->get('/trash', 'WorkerCtrl@trash');
    $router->get('/trash/{id}', 'WorkerCtrl@recover');
    $router->get('/worker/{id}', 'WorkerCtrl@search');
    $router->post('/', 'WorkerCtrl@save');
    $router->delete('/{id}', 'WorkerCtrl@delete');
    $router->post('/worker/{id}', 'WorkerCtrl@update');
});

$router->group(['prefix' => 'workers/types'], function () use ($router) {
    $router->get('/', 'WorkerTypeCtrl@index');
    $router->get('/{id}', 'WorkerTypeCtrl@search');
    $router->post('/', 'WorkerTypeCtrl@save');
    $router->delete('/{id}', 'WorkerTypeCtrl@delete');
    $router->post('/{id}', 'WorkerTypeCtrl@update');
});

$router->group(['prefix' => 'assignment'], function () use ($router) {
    $router->get('/', 'AssignmentCtrl@index');
    $router->get('/workers', 'AssignmentCtrl@workersAssignments');
    $router->get('/contracts', 'AssignmentCtrl@contractsAssignments');
    $router->get('/searchAvailableWorkers/{id}', 'AssignmentCtrl@searchAvailableWorkers');
    $router->get('/searchAvailableContracts/{id}', 'AssignmentCtrl@searchAvailableContracts');
    $router->get('/searchAssignmentsWorker/{id}', 'AssignmentCtrl@searchAssignmentsWorker');
    $router->get('/searchAssignmentsContract/{id}', 'AssignmentCtrl@searchAssignmentsContract');
    $router->get('/{id}', 'AssignmentCtrl@search');
    $router->post('/', 'AssignmentCtrl@save');
});
