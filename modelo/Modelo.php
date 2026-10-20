<?php
class Modelo {
    private $db;
    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "examen_mvc");
    }
    public function insertar($n, $p) {
        $this->db->query("INSERT INTO productos (nombre, precio) VALUES ('$n', $p)");
    }
    public function mostrar() {
        return $this->db->query("SELECT * FROM productos")->fetch_all(MYSQLI_ASSOC);
    }
    public function eliminar($id) {
        $this->db->query("DELETE FROM productos WHERE id = $id");
    }
    public function editar($id, $n, $p) {
        $this->db->query("UPDATE productos SET nombre='$n', precio=$p WHERE id=$id");
    }
}
?>