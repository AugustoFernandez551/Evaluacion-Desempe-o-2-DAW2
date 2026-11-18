<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Editar facultad</title></head>
<body>
    <?php $facultad = $data["facultad"]; ?>
    <h1>Editar facultad</h1>
    <?php foreach ($data["errors"] as $error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
    <?php endforeach; ?>
    <form method="post" action="<?= BASE_URL ?>/facultades/guardar_edit">
        <input type="hidden" name="id" value="<?= (int) $facultad["id"] ?>">
        <label>Nombre <input name="nombre" required value="<?= htmlspecialchars($facultad["nombre"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Abreviatura <input name="abreviatura" required value="<?= htmlspecialchars($facultad["abreviatura"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <button type="submit">Actualizar</button>
    </form>
    <p><a href="<?= BASE_URL ?>/facultades">Volver</a></p>
</body>
</html>
