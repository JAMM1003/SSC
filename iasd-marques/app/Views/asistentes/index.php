<div class="card">
  <h2>Asistentes</h2>
  <form method="get" class="grid cols-3">
    <div class="field">
      <label>Buscar por nombre</label>
      <input type="text" name="q" value="<?= htmlspecialchars($q) ?>">
    </div>
    <div class="field">
      <label>Estatus</label>
      <select name="estatus">
        <option value="">Todos</option>
        <?php foreach (['miembro','visitante','nuevo_interesado'] as $st): ?>
          <option value="<?= $st ?>" <?= $estatus===$st?'selected':'' ?>><?= $st ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field" style="align-self:end">
      <button class="btn" type="submit">Buscar</button>
      <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/asistentes/create">Nuevo</a>
    </div>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Estatus</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?= (int)$it['id'] ?></td>
          <td><?= htmlspecialchars($it['nombre'] . ' ' . $it['apellido']) ?></td>
          <td><?= htmlspecialchars((string)($it['telefono'] ?? '')) ?></td>
          <td><?= htmlspecialchars((string)($it['email'] ?? '')) ?></td>
          <td><?= htmlspecialchars($it['estatus']) ?></td>
          <td>
            <a class="btn link" href="<?= htmlspecialchars($baseUrl) ?>/asistentes/edit/<?= (int)$it['id'] ?>">Editar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php $totalPages = (int)ceil($total / $perPage); if ($totalPages > 1): ?>
  <div style="margin-top: .75rem;">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <?php if ($p === $page): ?>
        <strong><?= $p ?></strong>
      <?php else: ?>
        <a href="?q=<?= urlencode($q) ?>&estatus=<?= urlencode($estatus) ?>&page=<?= $p ?>"><?= $p ?></a>
      <?php endif; ?>
      <?php if ($p < $totalPages): ?> | <?php endif; ?>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</div>

