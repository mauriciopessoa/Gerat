<?php
$g = new MeuGride('gd','M�dulos',ModuloDAO::selectAll('nome_modulo'),null,null,'ID_MODULO','NOME_MODULO,NOME_MENU,CANCELADO');
$g->addColumn('nome_menu','Nome Menu',500,'left');
$g->addColumn('nome_modulo'	,'Nome F�sico',500,'left');
$g->addColumn('cancelado'	,'Cancelado?',100,'center');
$g->addButton('Alterar',null,'btnAlterar','alterar()');
$g->show();
?>