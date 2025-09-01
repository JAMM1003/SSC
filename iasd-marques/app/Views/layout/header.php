<?php
use App\Core\Auth;
$user = Auth::user();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IASD Marqués</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>/css/styles.css">
</head>
<body>
<header class="navbar">
  <div class="container">
    <div class="brand">IASD Marqués</div>
    <nav>
      <?php if ($user): ?>
        <a href="<?= htmlspecialchars($baseUrl) ?>/dashboard">Dashboard</a>
        <a href="<?= htmlspecialchars($baseUrl) ?>/asistentes">Asistentes</a>
        <a href="<?= htmlspecialchars($baseUrl) ?>/eventos">Eventos</a>
        <?php if (in_array($user['rol'], ['admin','editor'], true)): ?>
          <a href="<?= htmlspecialchars($baseUrl) ?>/mensajes/plantillas">Plantillas WA</a>
          <a href="<?= htmlspecialchars($baseUrl) ?>/mensajes/cola">Cola WA</a>
        <?php endif; ?>
        <a href="<?= htmlspecialchars($baseUrl) ?>/logout">Salir (<?= htmlspecialchars($user['nombre']) ?>)</a>
      <?php else: ?>
        <a href="<?= htmlspecialchars($baseUrl) ?>/login">Ingresar</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">

