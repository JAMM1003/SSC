<h2>Panel de administración</h2>
<div class="grid cols-3">
  <div class="card kpi">
    <div class="value"><?= (int)$stats['total_asistentes'] ?></div>
    <div class="label">Total asistentes</div>
  </div>
  <div class="card kpi">
    <div class="value"><?= (int)$stats['nuevos_interesados_mes'] ?>%</div>
    <div class="label">Nuevos interesados (mes)</div>
  </div>
  <div class="card">
    <h3>Próximos eventos</h3>
    <ul>
      <?php foreach ($eventos as $e): ?>
        <li><?= htmlspecialchars($e['titulo']) ?> - <?= htmlspecialchars($e['fecha']) ?> <?= htmlspecialchars($e['hora']) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<div class="card">
  <h3>Top ministerios por interés</h3>
  <canvas id="chart1" width="800" height="260"></canvas>
  <script type="module">
    import { renderBarChart } from '<?= htmlspecialchars($baseUrl) ?>/js/charts.js';
    const labels = <?= json_encode(array_column($kpis, 'nombre')) ?>;
    const values = <?= json_encode(array_map('intval', array_column($kpis, 'c'))) ?>;
    renderBarChart('chart1', labels, values);
  </script>
</div>

