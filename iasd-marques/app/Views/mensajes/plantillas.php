<div class="card">
  <h2>Plantillas WhatsApp</h2>
  <?php if (!empty($msg)): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="grid cols-2">
      <div class="field"><label>Nombre</label><input name="nombre" required></div>
      <div class="field" style="grid-column:1 / -1">
        <label>Cuerpo (soporta {{nombre}}, {{evento}}, {{fecha}})</label>
        <textarea name="cuerpo" rows="3" required></textarea>
      </div>
    </div>
    <button class="btn" type="submit">Guardar</button>
  </form>
  <h3>Listado</h3>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Vista previa</th></tr></thead>
    <tbody>
    <?php foreach ($items as $it): ?>
      <tr>
        <td><?= (int)$it['id'] ?></td>
        <td><?= htmlspecialchars($it['nombre']) ?></td>
        <td><?= htmlspecialchars(mb_strimwidth($it['cuerpo_texto'],0,60,'…')) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

