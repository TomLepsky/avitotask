<?php


namespace Avitotask;

class OrderAPI {

    public function calculatePrice(int $orderId, string $destination) : string {
        $result = false;
        if (Validator::isValidDestination($destination)) {
            $order = (new Order())->get($orderId);
            if (!is_null($order)) {
                $result = Logistic::calculatePrice($order->departure, $destination);
            }
        }
        return json_encode(["result" => $result]);
    }

    public function createOrder(int $orderId, string $destination, float $price, int $destinationDate) : string {
        $result = false;
        if (Validator::isValidDestination($destination) &&
            Validator::isValidPrice($price) &&
            Validator::isValidDate($destinationDate)) {
            $order = (new Order())->get($orderId);
            if (!is_null($order)) {
                $order->destination = $destination;
                $order->price = $price;
                $order->destination_date = date("Y-m-d H:i:s", $destinationDate);
                $result = $order->update($orderId);
            }
        }
        return json_encode(["result" => $result]);
    }

    public function getOrderInformation(int $orderId) : string {
        $order = (new Order())->get($orderId);
        return json_encode(["result" => is_null($order) ? false : $order]);
    }

    public function getAllOrders() : string {
        $order = (new Order())->getAll();
        return json_encode(["result" => is_null($order) ? false : $order]);
    }
}