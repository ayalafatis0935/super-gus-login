<?php
require __DIR__.'/config.php';
try {
  $count = (int)db()->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
  if ($count === 0) {
    $st = db()->prepare('INSERT INTO usuarios(usuario,password_hash) VALUES(?,?)');
    $st->execute(['admin', password_hash('Cambiar123!', PASSWORD_DEFAULT)]);
    echo 'Administrador creado. Usuario: admin. Contraseña temporal: Cambiar123!. Cámbiala y elimina setup.php.';
  } else { echo 'Ya existe un usuario. Elimina setup.php por seguridad.'; }
} catch (Throwable $e) { http_response_code(500); echo 'Error de configuración: '.h($e->getMessage()); }
