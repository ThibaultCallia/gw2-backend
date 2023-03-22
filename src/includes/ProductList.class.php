<?php

class ProductList
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM list";
        return $this->db->executeQuery($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM list WHERE id=:id";
        return $this->db->executeQuery($sql, ['id' => $id]);
    }
    public function add($data)
    {

        $keys = join(", ", array_keys($data));
        $values =  '"' . join('", "', array_values($data)) . '"';
        $sql = "INSERT INTO list ($keys) VALUES ($values)";
        $this->db->executeQuery($sql);
        // $keys = array_keys($data);
        // $cols = implode(', ', $keys);
        // $values = array_map(function ($key) {
        //     return ':' . $key;
        // }, $keys);
        // $values = implode(', ', $values);
        // $sql = "INSERT INTO list($cols) VALUES ($values)";
        // return $this->db->executeQuery($sql, $data);
    }
    public function delete($id)
    {
        //  TODO: even more validation!!!
        // $sql = "UPDATE product SET isChecked = 1 WHERE id = $id";

        $sql = 'DELETE FROM list WHERE id = ' . $id;

        $this->db->executeQuery($sql);
    }
    // public function update($id, $data)
    // {
    //     //  TODO: e validation!!
    //     $updateColumns = $data;
    //     array_walk($updateColumns, function (&$value, $key) {
    //         $value = "$key = '$value'";
    //     });
    //     $updateColumns = join(', ', array_values($updateColumns));
    //     $sql = "UPDATE list SET $updateColumns WHERE id = $id";
    //     $this->db->executeQuery($sql);
    // }
}
