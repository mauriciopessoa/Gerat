<?php
$dados = PerfilDAO::selectAll('PERFIL');
$g = new MeuGride('gd','Perfil',$dados,null,null,'ID_PERFIL','PERFIL,CANCELADO');
$g->addColumn( 'perfil','Perfil',5000,'left' );
$g->addColumn( 'cancelado','Cancelado ?',220,'center' );
$g->addButton( 'Alterar', null, 'gdAlterar', 'alterar()', null,null);
$g->show();
?>