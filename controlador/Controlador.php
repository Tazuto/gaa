<?php
require_once 'modelo/Modelo.php';
class Controlador {
    public function procesarSolicitud() {
        $m = new Modelo();
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'insertar') $m->insertar($_POST['nombre'], $_POST['precio']);
        if ($accion === 'eliminar') $m->eliminar($_GET['id']);
        if ($accion === 'editar') $m->editar($_POST['id'], $_POST['nombre'], $_POST['precio']);

        if ($accion) { header("Location: index.php"); exit; }

        $productos = $m->mostrar();
        require_once 'vista/index.php';
    }
}
?>