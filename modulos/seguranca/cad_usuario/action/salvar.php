<?php
$vo = new UsuarioVO();
$frm->setVo($vo);
$vo->setSenha($frm->get('senha1'));


if( !$frm->get('id') )
{    

if( Tb_usuarioDAO::selectAll(null, "nome='".$frm->get('nome')."'")) 
{ 
    $frm->setMessage('Usuário com o nome: '.$frm->get('nome').' já existe!');     
}
else
    
if( Tb_usuarioDAO::selectAll(null, "login='".$frm->get('login')."'")) 
{ 
    $frm->setMessage('Usuário com o login: '.$frm->get('login').' já existe!');     
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
