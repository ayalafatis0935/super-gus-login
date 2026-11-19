<?php
require __DIR__.'/config.php'; require_login();
$allowed=[
 'productos'=>['nombre','categoria','stock','precio_compra','precio_venta'],
 'clientes_credito'=>['nombre','telefono','direccion','limite_credito','activo','fecha_registro'],
 'ventas'=>['venta_id','fecha','hora','producto_id','producto','cantidad','precio_unitario','total','tipo_pago','cliente_id'],
 'movimientos_credito'=>['cliente_id','tipo','descripcion','monto','fecha','venta_id']
];
$table=$_GET['tabla'] ?? 'productos';
if(!isset($allowed[$table])) { http_response_code(400); exit('Tabla no permitida'); }
$cols=$allowed[$table]; $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $action=$_POST['action'] ?? '';
 try {
  if($action==='delete'){ $st=db()->prepare("DELETE FROM `$table` WHERE id=?"); $st->execute([(int)$_POST['id']]); $msg='Registro eliminado.'; }
  elseif($action==='save'){
   $id=(int)($_POST['id'] ?? 0); $vals=[];
   foreach($cols as $c){ $v=$_POST[$c] ?? null; if($v==='') $v=null; $vals[$c]=$v; }
   if($id){ $set=implode(',',array_map(fn($c)=>"`$c`=?",$cols)); db()->prepare("UPDATE `$table` SET $set WHERE id=?")->execute([...array_values($vals),$id]); $msg='Registro actualizado.'; }
   else { $names=implode(',',array_map(fn($c)=>"`$c`",$cols)); $marks=implode(',',array_fill(0,count($cols),'?')); db()->prepare("INSERT INTO `$table` ($names) VALUES ($marks)")->execute(array_values($vals)); $msg='Registro creado.'; }
  }
 } catch(Throwable $e){ $msg='No se pudo completar la operación. Revisa los campos y las relaciones entre tablas.'; }
}
$edit=null;
if(isset($_GET['edit'])){ $st=db()->prepare("SELECT * FROM `$table` WHERE id=?");$st->execute([(int)$_GET['edit']]);$edit=$st->fetch(); }
$rows=db()->query("SELECT * FROM `$table` ORDER BY id DESC LIMIT 200")->fetchAll();
?><!doctype html><html lang="es"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CRUD - <?=h($table)?></title><link rel="stylesheet" href="style.css"><header><b>Super Gus</b><a href="panel.php">Volver al panel</a></header><main><h1><?=h($table)?></h1><?php if($msg):?><p class="notice"><?=h($msg)?></p><?php endif;?>
<h2><?= $edit?'Editar registro':'Agregar registro' ?></h2><form method="post" class="editor"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=h($edit['id']??'')?>">
<?php foreach($cols as $c):?><label><?=h($c)?><?php if(in_array($c,['activo','stock','cantidad','producto_id','cliente_id'])):?><input type="number" name="<?=h($c)?>" value="<?=h($edit[$c]??'')?>" <?=in_array($c,['activo','stock','cantidad'])?'min="0"':''?>><?php elseif(in_array($c,['precio_compra','precio_venta','limite_credito','monto','precio_unitario','total'])):?><input type="number" step="0.01" name="<?=h($c)?>" value="<?=h($edit[$c]??'')?>"><?php else:?><input name="<?=h($c)?>" value="<?=h($edit[$c]??'')?>" <?=in_array($c,['nombre','venta_id','producto','tipo','descripcion','fecha','hora','fecha_registro'])?'required':''?>><?php endif;?></label><?php endforeach;?><button>Guardar</button></form>
<h2>Registros (máximo 200)</h2><div class="tablewrap"><table><thead><tr><th>ID</th><?php foreach($cols as $c):?><th><?=h($c)?></th><?php endforeach;?><th>Acciones</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><td><?=h($r['id'])?></td><?php foreach($cols as $c):?><td><?=h($r[$c])?></td><?php endforeach;?><td><a href="?tabla=<?=h($table)?>&edit=<?=h($r['id'])?>">Editar</a><form method="post" class="inline" onsubmit="return confirm('¿Eliminar este registro?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=h($r['id'])?>"><button class="danger">Eliminar</button></form></td></tr><?php endforeach;?></tbody></table></div></main></html>
