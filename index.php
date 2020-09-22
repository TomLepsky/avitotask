<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Avitotask\Order;
use Avitotask\OrderAPI;
use Avitotask\Limiter;
use Avitotask\ApiController;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addErrorMiddleware(false, false, false);

$app->get('/', ApiController::class . ':index');

/*
 * Request:
 * GET avitotask/getorders HTTP/1.0
 * Host: avitotask/
 *
 *  ********
 *
 * Response:
 * {
 *      result:[
 *          {
 *              "id":1,
 *              ...
 *          },
 *          {
 *              "id":2,
 *              ...
 *          }
 *      ]
 * }
 */
$app->get('/getorders', ApiController::class . ':getOrders');

/*
 * Request:
 * GET avitotask/getorder/1 HTTP/1.0
 * Host: avitotask/
 *
 * ********
 *
 * Response:
 * {
 *      result:
 *          {
 *              "id":1,
 *              ...
 *          }
 * }
 */
$app->get('/getorder/{id}', ApiController::class . ':getOrder');

/*
 * Request:
 * POST avitotask/price HTTP/1.0
 * Host: avitotask/
 * Body:
 * id=7&destination=point+of+destination
 *
 *  ********
 *
 * Response:
 * {
 *      result: 327
 * }
 */
$app->post('/price', ApiController::class . ':price');

/*
 * Request:
 * POST avitotask/create HTTP/1.0
 * Host: avitotask/
 * Body:
 * id=7&destination=point+of+destination&price=123&destinationDate=1601809305
 *
 *  ********
 *
 * Response:
 * {
 *      result: true
 * }
 */
$app->post('/create', ApiController::class . ':create');

/*
 * Request:
 * POST avitotask/add HTTP/1.0
 * Host: avitotask/
 * Body:
 * name=order+name&departure=point+of+departure
 *
 *  ********
 *
 * Response:
 * {
 *      result: true
 * }
 */
$app->post('/add', ApiController::class . ':add');

/*
 * Request:
 * POST avitotask/delete HTTP/1.0
 * Host: avitotask/
 * Body:
 * id=1
 *
 *  ********
 *
 * Response:
 * {
 *      result: true
 * }
 */
$app->post('/delete', ApiController::class . ':delete');

$app->run();