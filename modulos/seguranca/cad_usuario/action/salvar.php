<?php
$vo = new UsuarioVO();
$frm->setVo($vo);
$vo->setSenha($frm->get('senha1'));


if( !$frm->get('id') )
{    

if( Tb_usuarioDAO::selectAll(null, "nome='".$frm->get('nome')."'")) 
{ 
    $frm->setMessage('Usu�rio com o nome: '.$frm->get('nome').' j� existe!');     
}
else
    
if( Tb_usuarioDAO::selectAll(null, "login='".$frm->get('login')."'")) 
{ 
    $frm->setMessage('Usu�rio com o login: '.$frm->get('login').' j� existe!');     
}
else
{
    UsuarioDAO::insert($vo);
}

}
else
{
  UsuarioDAO::insert($vo);  
}



?>
