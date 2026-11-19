<?php
require __DIR__.'/config.php';
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $st=db()->prepare('SELECT id,password_hash FROM usuarios WHERE usuario=?');
  $st->execute([trim($_POST['usuario'] ?? '')]); $u=$st->fetch();
  if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
    session_regenerate_id(true); $_SESSION['user_id']=$u['id']; header('Location: panel.php'); exit;
  }
  $error='Usuario o contraseña incorrectos.';
}
?><!doctype html><html lang="es"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - Super Gus</title>
<link rel="stylesheet" href="style.css"><main class="login"><h1>Super Gus</h1><p>Iniciar sesión</p><?php if($error):?><p class="error"><?=h($error)?></p><?php endif;?>
<form method="post"><label>Usuario<input name="usuario" required></label><label>Contraseña<input type="password" name="password" required></label><button>Entrar</button></form></main></html>
