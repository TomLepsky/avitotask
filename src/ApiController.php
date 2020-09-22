<?php


namespace Avitotask;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiController {

    private $maxConnections = 10;
    private $interval = 60;

    public function index(Request $request, Response $response, $args) {
        return $response;
    }

    public function getOrder(Request $request, Response $response, $args) {
        if ((new Limiter($this->interval, $this->maxConnections))->isLimit())
            return $response->withStatus(429);

        $response->getBody()->write((new OrderAPI())->getOrderInformation((int) $args['id']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getOrders(Request $request, Response $response, $args) {
        if ((new Limiter($this->interval, $this->maxConnections))->isLimit())
            return $response->withStatus(429);

        $response->getBody()->write((new OrderAPI())->getAllOrders());
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function price(Request $request, Response $response, $args) {
        if ((new Limiter($this->interval, $this->maxConnections))->isLimit())
            return $response->withStatus(429);

        $data = $request->getParsedBody();
        if (!is_null($data['id']) && !is_null($data['destination'])) {
            $response->getBody()->write((new OrderAPI())->calculatePrice((int) $data['id'], (string) $data['destination']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
        return $response->withStatus(400);
    }

    public function create(Request $request, Response $response) {
        if ((new Limiter($this->interval, $this->maxConnections))->isLimit())
            return $response->withStatus(429);

        $data = $request->getParsedBody();
        if (!is_null($data['id']) &&
            !is_null($data['destination']) &&
            !is_null($data['price']) &&
            !is_null($data['destinationDate'])) {
            $response->getBody()->write((new OrderAPI())->createOrder((int) $data['id'], (string) $data['destination'],
                (float) $data['price'], (int) $data['destinationDate']));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(400);
    }

    public function add(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        if (isset($data['name']) && isset($data['departure'])) {
            $result = (new Order($data['name'], $data['departure']))->create();
            $response->getBody()->write(json_encode(["result" => $result]));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(400);
    }

    public function delete(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        if (isset($data['id']) && !empty($data['id'])) {
            $result = (new Order())->delete((int) $data['id']);
            $response->getBody()->write(json_encode(["result" => $result]));
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(400);
    }
}