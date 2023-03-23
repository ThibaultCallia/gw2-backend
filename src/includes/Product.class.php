<?php

class Product
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // getAll will always require a specific list. All products across all lists is not useful.
    public function getAllByList($id)
    {
        $sql = "SELECT * FROM product WHERE list_id=:list_id";
        return $this->db->executeQuery($sql, ['list_id' => $id]);
    }
    // getById is foreseen but not implemented atm.
    public function getById($id)
    {
        $sql = "SELECT * FROM product WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
    // add will execute query. Validation done in api/products.inc.php
    public function add($data)
    {
        //  TODO: even more validation!
        $keys = join(", ", array_keys($data));
        $values =  '"' . join('", "', array_values($data)) . '"';
        $sql = "INSERT INTO product ($keys) VALUES ($values)";
        $this->db->executeQuery($sql);
    }
    public function delete($id)
    {
        $sql = "DELETE FROM product WHERE id = " . $id;
        $this->db->executeQuery($sql);
    }
}
