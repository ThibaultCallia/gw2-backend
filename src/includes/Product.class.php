<?php

class Product
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllByList($id)
    {
        $sql = "SELECT * FROM product WHERE list_id=:list_id";
        return $this->db->executeQuery($sql, ['list_id' => $id]);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM product WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
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
        //  TODO: even more validation!!!
        // $sql = "UPDATE product SET isChecked = 1 WHERE id = $id";
        $sql = "DELETE FROM product WHERE id = " . $id;

        $this->db->executeQuery($sql);
    }
}
