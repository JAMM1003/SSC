<div class="card">
  <h2>Editar asistente #<?= (int)$asistente['id'] ?></h2>
  <?php if (!empty($msg)): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="grid cols-2">
      <div class="field">
        <label>Nombre</label>
        <input required name="nombre" value="<?= htmlspecialchars($asistente['nombre']) ?>">
      </div>
      <div class="field">
        <label>Apellido</label>
        <input required name="apellido" value="<?= htmlspecialchars($asistente['apellido']) ?>">
      </div>
      <div class="field">
        <label>Teléfono</label>
        <input name="telefono" value="<?= htmlspecialchars((string)($asistente['telefono'] ?? '')) ?>">
      </div>
      <div class="field">
        <label>Correo</label>
        <input type="email" name="email" value="<?= htmlspecialchars((string)($asistente['email'] ?? '')) ?>">
      </div>
      <div class="field">
        <label>Edad</label>
        <input type="number" name="edad" min="0" value="<?= htmlspecialchars((string)($asistente['edad'] ?? '')) ?>">
      </div>
      <div class="field">
        <label>Sexo</label>
        <select name="sexo">
          <?php foreach (['','M','F','O'] as $s): ?>
            <option value="<?= $s ?>" <?= ($asistente['sexo']??'')===$s?'selected':'' ?>><?= $s===''?'-':$s ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field">
        <label>Dirección</label>
        <input name="direccion" value="<?= htmlspecialchars((string)($asistente['direccion'] ?? '')) ?>">
      </div>
      <div class="field">
        <label>Estatus</label>
        <select name="estatus">
          <?php foreach (['miembro','visitante','nuevo_interesado'] as $st): ?>
            <option value="<?= $st ?>" <?= $asistente['estatus']===$st?'selected':'' ?>><?= $st ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field" style="grid-column: 1 / -1;">
        <label>Notas</label>
        <textarea name="notas" rows="3"><?= htmlspecialchars((string)($asistente['notas'] ?? '')) ?></textarea>
      </div>
    </div>
    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/asistentes">Volver</a>
  </form>
</div>

