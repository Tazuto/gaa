<?php $productos = $productos ?? []; ?>
<!DOCTYPE html>
<html lang="es"><head><title>Vista</title></head>
<body>
    <h3>Agregar Producto</h3>
    <form action="index.php?accion=insertar" method="POST">
        Nombre: <input name="nombre" required> Precio: <input name="precio" required> <button>Guardar</button>
    </form>
    
    <h3>Lista</h3>
    <table border="1">
        <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Acciones</th></tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <form action="index.php?accion=editar" method="POST">
                <td><?= $p['id'] ?> <input type="hidden" name="id" value="<?= $p['id'] ?>"></td>
                <td><input name="nombre" value="<?= $p['nombre'] ?>" required></td>
                <td><input name="precio" value="<?= $p['precio'] ?>" required></td>
                <td><button>Editar</button> <a href="index.php?accion=eliminar&id=<?= $p['id'] ?>">Eliminar</a></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
</body></html>