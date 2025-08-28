<div class="card">
  <h2>Nuevo asistente</h2>
  <?php if (!empty($msg)): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="grid cols-2">
      <div class="field">
        <label>Nombre</label>
        <input required name="nombre">
      </div>
      <div class="field">
        <label>Apellido</label>
        <input required name="apellido">
      </div>
      <div class="field">
        <label>Teléfono</label>
        <input name="telefono">
      </div>
      <div class="field">
        <label>Correo</label>
        <input type="email" name="email">
      </div>
      <div class="field">
        <label>Edad</label>
        <input type="number" name="edad" min="0">
      </div>
      <div class="field">
        <label>Sexo</label>
        <select name="sexo">
          <option value="">-</option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
          <option value="O">Otro</option>
        </select>
      </div>
      <div class="field">
        <label>Dirección</label>
        <input name="direccion">
      </div>
      <div class="field">
        <label>Estatus</label>
        <select name="estatus">
          <option value="miembro">Miembro</option>
          <option value="visitante" selected>Visitante</option>
          <option value="nuevo_interesado">Nuevo interesado</option>
        </select>
      </div>
      <div class="field" style="grid-column: 1 / -1;">
        <label>Notas</label>
        <textarea name="notas" rows="3"></textarea>
      </div>
    </div>
    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/asistentes">Volver</a>
  </form>
</div>

