<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Registrar facultad</title></head>
<body>
    <h1>Registrar facultad</h1>
    <?php foreach ($data["errors"] as $error): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
    <?php endforeach; ?>
    <form method="post" action="<?= BASE_URL ?>/facultades/guardar">
        <label>Nombre <input name="nombre" required value="<?= htmlspecialchars((string) ($data["values"]["nombre"] ?? ""), ENT_QUOTES, "UTF-8") ?>"></label><br>
        <label>Abreviatura <input name="abreviatura" required value="<?= htmlspecialchars((string) ($data["values"]["abreviatura"] ?? ""), ENT_QUOTES, "UTF-8") ?>"></label><br>
        <button type="submit">Guardar</button>
    </form>
    <p><a href="<?= BASE_URL ?>/facultades">Volver</a></p>
</body>
</html>
