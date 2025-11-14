<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/db.php';

use Ramsey\Uuid\Uuid;

// Crear producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = (float) ($_POST['precio'] ?? 0);

    if ($nombre !== '' && $precio >= 0) {
        $uuid = Uuid::uuid4()->toString();
        $stmt = $pdo->prepare('INSERT INTO productos (uuid, nombre, precio) VALUES (?, ?, ?)');
        $stmt->execute([$uuid, $nombre, $precio]);
        header('Location: /');
        exit;
    }
}

// Borrar producto
if (isset($_GET['del'])) {
    $id = (int) $_GET['del'];
    $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /');
    exit;
}

$productos = $pdo
    ->query('SELECT id, uuid, nombre, precio, creado_en FROM productos ORDER BY id DESC')
    ->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda PHP + Apache + MariaDB</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; margin: 2rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: .5rem; }
        th { background: #f3f3f3; }
        form { display: flex; gap: .5rem; margin-bottom: 1rem; }
        input[type=text], input[type=number] { padding: .4rem; }
        button { padding: .5rem .8rem; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Productos</h1>

    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="number" step="0.01" name="precio" placeholder="Precio" required>
        <button type="submit">Agregar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>UUID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['uuid']) ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= number_format((float)$p['precio'], 2) ?></td>
                    <td><?= htmlspecialchars($p['creado_en']) ?></td>
                    <td><a href="?del=<?= urlencode($p['id']) ?>" onclick="return confirm('¿Eliminar producto?')">🗑️</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>