<div class="card">
  <h2>Iniciar sesión</h2>
  <?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="field">
      <label>Correo</label>
      <input type="email" name="email" required>
    </div>
    <div class="field">
      <label>Contraseña</label>
      <input type="password" name="password" required>
    </div>
    <button class="btn" type="submit">Ingresar</button>
    <a class="btn link" href="<?= htmlspecialchars($baseUrl) ?>/forgot">¿Olvidó su contraseña?</a>
  </form>
</div>

