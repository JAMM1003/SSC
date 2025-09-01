<div class="card">
  <h2>Cola de WhatsApp (simulada)</h2>
  <?php if (!empty($msg)): ?><div class="alert success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (!empty($error)): ?><div class="alert error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="grid cols-3">
      <div class="field"><label>Asistente</label>
        <select name="asistente_id" required>
          <option value="">Seleccione</option>
          <?php foreach ($asistentes as $a): ?>
            <option value="<?= (int)$a['id'] ?>"><?= htmlspecialchars($a['nombre'].' '.$a['apellido']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Plantilla</label>
        <select name="plantilla_id" required>
          <option value="">Seleccione</option>
          <?php foreach ($plantillas as $p): ?>
            <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Fecha programada</label>
        <input type="datetime-local" name="fecha_programada" required>
      </div>
    </div>
    <button class="btn" type="submit">Programar</button>
    <a class="btn secondary" href="<?= htmlspecialchars($baseUrl) ?>/mensajes/cola/procesar">Procesar ahora</a>
  </form>

  <h3>Pendientes</h3>
  <table>
    <thead><tr><th>ID</th><th>Destinatario</th><th>Teléfono</th><th>Fecha</th><th>Acción</th></tr></thead>
    <tbody>
    <?php foreach ($pendientes as $p): ?>
      <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= htmlspecialchars($p['nombre'].' '.$p['apellido']) ?></td>
        <td><?= htmlspecialchars($p['telefono']) ?></td>
        <td><?= htmlspecialchars($p['fecha_programada']) ?></td>
        <td>
          <?php
            $texto = str_replace(['{{nombre}}','{{evento}}','{{fecha}}'], [
              $p['nombre'], '', date('d/m/Y')
            ], $p['plantilla_texto']);
            $waUrl = 'https://wa.me/' . rawurlencode($p['telefono']) . '?text=' . rawurlencode($texto);
          ?>
          <a class="btn" target="_blank" href="<?= htmlspecialchars($waUrl) ?>">Abrir enlace</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

