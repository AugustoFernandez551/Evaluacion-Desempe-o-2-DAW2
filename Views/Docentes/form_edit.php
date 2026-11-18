<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Editar docente</title></head>
<body>
    <?php $docente = $data["docente"]; ?>
    <h1>Editar docente</h1>
    <?php foreach ($data["errors"] as $error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
    <?php endforeach; ?>
    <form method="post" action="<?= BASE_URL ?>/docentes/guardar_edit">
        <input type="hidden" name="id" value="<?= (int) $docente["id"] ?>">
        <label>Facultad <select name="id_facultad" required>
            <?php foreach ($data["facultades"] as $facultad): ?>
                <option value="<?= (int) $facultad["id"] ?>" <?= (int) $docente["id_facultad"] === (int) $facultad["id"] ? "selected" : "" ?>><?= htmlspecialchars($facultad["nombre"], ENT_QUOTES, "UTF-8") ?></option>
            <?php endforeach; ?>
        </select></label><br>
        <label>DNI <input name="dni" required value="<?= htmlspecialchars($docente["dni"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Apellidos <input name="apellidos" required value="<?= htmlspecialchars($docente["apellidos"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Nombres <input name="nombres" required value="<?= htmlspecialchars($docente["nombres"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Correo <input type="email" name="correo" required value="<?= htmlspecialchars($docente["correo"], ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Categoría <select name="categoria" required>
            <?php foreach ($data["categorias"] as $categoria): ?>
                <option value="<?= $categoria ?>" <?= $docente["categoria"] === $categoria ? "selected" : "" ?>><?= $categoria ?></option>
            <?php endforeach; ?>
        </select></label><br>
        <label>Dedicación <select name="dedicacion" required>
            <?php foreach ($data["dedicaciones"] as $dedicacion): ?>
                <option value="<?= $dedicacion ?>" <?= $docente["dedicacion"] === $dedicacion ? "selected" : "" ?>><?= $dedicacion ?></option>
            <?php endforeach; ?>
        </select></label><br>
        <button type="submit">Actualizar</button>
    </form>
    <p><a href="<?= BASE_URL ?>/docentes">Volver</a></p>
</body>
</html>
