<div class="card">
  <h2>Eventos</h2>
  <div style="margin-bottom:.5rem;">
    <a class="btn" href="<?= htmlspecialchars($baseUrl) ?>/eventos/create">Nuevo evento</a>
  </div>
  <table>
    <thead><tr><th>ID</th><th>Título</th><th>Tipo</th><th>Fecha</th><th>Hora</th><th>Lugar</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($items as $it): ?>
      <tr>
        <td><?= (int)$it['id'] ?></td>
        <td><?= htmlspecialchars($it['titulo']) ?></td>
        <td><?= htmlspecialchars($it['tipo']) ?></td>
        <td><?= htmlspecialchars($it['fecha']) ?></td>
        <td><?= htmlspecialchars($it['hora']) ?></td>
        <td><?= htmlspecialchars($it['lugar']) ?></td>
        <td><a class="btn link" href="<?= htmlspecialchars($baseUrl) ?>/eventos/asistencia/<?= (int)$it['id'] ?>">Asistencia</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

