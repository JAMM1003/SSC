<div class="card">
  <h2>Asistencia - <?= htmlspecialchars($evento['titulo']) ?> (<?= htmlspecialchars($evento['fecha']) ?> <?= htmlspecialchars($evento['hora']) ?>)</h2>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <table>
      <thead><tr><th>#</th><th>Nombre</th><th>Teléfono</th><th>Presente</th></tr></thead>
      <tbody>
        <?php foreach ($asistentes as $a): ?>
          <tr>
            <td><?= (int)$a['id'] ?></td>
            <td><?= htmlspecialchars($a['nombre'] . ' ' . $a['apellido']) ?></td>
            <td><?= htmlspecialchars((string)($a['telefono'] ?? '')) ?></td>
            <td>
              <input type="hidden" name="presente[<?= (int)$a['id'] ?>]" value="0">
              <input type="checkbox" name="presente[<?= (int)$a['id'] ?>]" value="1" <?= !empty($a['presente']) ? 'checked' : '' ?>>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button class="btn" type="submit">Guardar asistencia</button>
    <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/eventos">Volver</a>
    <a class="btn" href="<?= htmlspecialchars($baseUrl) ?>/eventos/exportar/<?= (int)$evento['id'] ?>">Exportar CSV</a>
  </form>
</div>

