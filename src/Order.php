<?php

namespace Avitotask;

class Order extends Model {

    public $id;
    public $name;
    public $destination;
    public $departure;
    public $price;
    public $destination_date;

    public function __construct(string $name = "", string $departure = "", string $destination = "",
                                float $price = 0.0, string $destination_date = "", int $id = 0) {
        parent::__construct();
        $this->name = $name;
        $this->destination = $destination;
        $this->departure = $departure;
        $this->price = $price;
        $this->destination_date = $destination_date;
        $this->id = $id;
    }

    public function create(): bool {
        if (empty($this->name) || empty($this->departure))
            return false;

        $result = $this->db->prepare("INSERT INTO `avito_orders`(`name`, `departure`) VALUES (?, ?)");
        return $result->execute(array($this->name, $this->departure));
    }

    public function update(int $id): bool {
        $result = $this->db->prepare("UPDATE `avito_orders` SET `name`=?,`destination`=?,`departure`=?,
                                                    `price`=?,`destination_date`=? WHERE id=?");
        return $result->execute(array(
            $this->name,
            $this->destination,
            $this->departure,
            $this->price,
            $this->destination_date,
            $id
        ));
    }

    public function delete(int $id): bool {
        $result = $this->db->prepare("DELETE FROM `avito_orders` WHERE `id` = ?");
        return $result->execute(array($id));
    }

    public function get(int $id): ?Order {
        $result = $this->db->prepare("SELECT * FROM `avito_orders` WHERE id = ?");
        $result->execute(array($id));
        $result = $result->fetch();
        if (empty($result))
            return null;

        return self::factory($result);
    }

    public function getAll(): array {
        $result = $this->db->query("SELECT * FROM `avito_orders`");
        $result = $result->fetchAll();
        if (empty($result))
            return null;

        $orders = [];
        foreach ($result as $order) {
            array_push($orders, self::factory($order));
        }
        return $orders;
    }

    private static function factory(array $data) : Order {
        return new Order(
            is_null($data["name"]) ? "" : $data["name"],
            is_null($data["departure"]) ? "" : $data["departure"],
            is_null($data["destination"]) ? "" : $data["destination"],
            is_null($data["price"]) ? 0.0 : $data["price"],
            is_null($data["destination_date"]) ? "" : $data["destination_date"],
            $data['id']
        );
    }

    public function __toString() : string {
        return "* name: {$this->name}, dept: {$this->departure}, dest: {$this->destination}, price: {$this->price}, dest.date: {$this->destination_date} * \n\r";
    }


}