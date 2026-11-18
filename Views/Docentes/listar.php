<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Docentes</title></head>
<body>
    <h1>Docentes activos</h1>
    <p><a href="<?= BASE_URL ?>/docentes/registrar">Registrar docente</a> | <a href="<?= BASE_URL ?>/facultades">Facultades</a></p>
    <table border="1">
        <thead><tr><th>Facultad</th><th>DNI</th><th>Apellidos y nombres</th><th>Correo</th><th>Categoría</th><th>Dedicación</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach ($data["docentes"] as $docente): ?>
            <tr>
                <td><?= htmlspecialchars($docente["facultad_nombre"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($docente["dni"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($docente["apellidos"] . ", " . $docente["nombres"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($docente["correo"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($docente["categoria"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($docente["dedicacion"], ENT_QUOTES, "UTF-8") ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/docentes/editar/<?= (int) $docente["id"] ?>">Editar</a>
                    <form method="post" action="<?= BASE_URL ?>/docentes/eliminar/<?= (int) $docente["id"] ?>" style="display:inline">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
