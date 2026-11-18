<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Facultades</title></head>
<body>
    <h1>Facultades activas</h1>
    <p><a href="<?= BASE_URL ?>/facultades/registrar">Registrar facultad</a> | <a href="<?= BASE_URL ?>/docentes">Docentes</a></p>
    <table border="1">
        <thead><tr><th>ID</th><th>Nombre</th><th>Abreviatura</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach ($data["facultades"] as $facultad): ?>
            <tr>
                <td><?= (int) $facultad["id"] ?></td>
                <td><?= htmlspecialchars($facultad["nombre"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($facultad["abreviatura"], ENT_QUOTES, "UTF-8") ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/facultades/editar/<?= (int) $facultad["id"] ?>">Editar</a>
                    <form method="post" action="<?= BASE_URL ?>/facultades/eliminar/<?= (int) $facultad["id"] ?>" style="display:inline">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
