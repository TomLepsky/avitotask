<?php

namespace Avitotask;

abstract class Model {

    protected $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    abstract function create() : bool;
    abstract function update(int $id) : bool;
    abstract function delete(int $id) : bool;
    abstract function get(int $id);
    abstract function getAll() : array;
}
