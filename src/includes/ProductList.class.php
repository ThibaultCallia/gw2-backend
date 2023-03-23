<?php

class ProductList
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Only id and name are required for the list. 
    public function getAll()
    {
        $sql = "SELECT id,name FROM list";
        return $this->db->executeQuery($sql);
    }
    // getById is foreseen but not implemented atm.
    public function getById($id)
    {
        $sql = "SELECT * FROM list WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
    // add will execute query. Validation done in api/list.inc.php
    public function add($data)
    {

        $keys = join(", ", array_keys($data));
        $values =  '"' . join('", "', array_values($data)) . '"';
        $sql = "INSERT INTO list ($keys) VALUES ($values)";
        $this->db->executeQuery($sql);
    }
    public function delete($id)
    {
        $sql = 'DELETE FROM list WHERE id = ' . $id;
        $this->db->executeQuery($sql);
    }
}
