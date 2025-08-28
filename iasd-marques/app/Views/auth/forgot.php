<div class="card">
  <h2>Recuperar contraseña</h2>
  <?php if (!empty($msg)): ?>
    <div class="alert success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="field">
      <label>Correo</label>
      <input type="email" name="email" required>
    </div>
    <button class="btn" type="submit">Generar token</button>
    <a class="btn link" href="<?= htmlspecialchars($baseUrl) ?>/login">Volver al login</a>
  </form>
</div>

