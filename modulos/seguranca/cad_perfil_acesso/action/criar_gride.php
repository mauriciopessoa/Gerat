<?php
$dados = MenuDAO::selectAll();
  $g = new TGrid('gd',null,$dados,null,null,'ID_MENU');
  $g->addCheckColumn('chk_modulo','M�dulos','ID_MENU','ROTULO');
  $g->setCreateDefaultEditButton(false);
  $g->setCreateDefaultDeleteButton(false);
  $g->show();
?>