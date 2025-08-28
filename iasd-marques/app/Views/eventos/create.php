<div class="card">
  <h2>Nuevo evento</h2>
  <?php if (!empty($msg)): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="grid cols-2">
      <div class="field">
        <label>Título</label>
        <input required name="titulo">
      </div>
      <div class="field">
        <label>Tipo</label>
        <select name="tipo">
          <option value="regular">Regular</option>
          <option value="deportivo">Deportivo</option>
          <option value="eclesiastico">Eclesiástico</option>
          <option value="jornada_salud">Jornada de salud</option>
          <option value="otro">Otro</option>
        </select>
      </div>
      <div class="field">
        <label>Fecha</label>
        <input type="date" name="fecha" required>
      </div>
      <div class="field">
        <label>Hora</label>
        <input type="time" name="hora" required>
      </div>
      <div class="field" style="grid-column: 1 / -1;">
        <label>Lugar</label>
        <input name="lugar" required>
      </div>
      <div class="field" style="grid-column: 1 / -1;">
        <label>Notas</label>
        <textarea name="notas" rows="3"></textarea>
      </div>
    </div>
    <button class="btn" type="submit">Guardar</button>
    <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/eventos">Volver</a>
  </form>
</div>

