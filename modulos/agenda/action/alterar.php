<?php
//$dados = EmpresaDAO::select($frm->get('id'));

$dados = EmpresaDAO::select($frm->get('codigo_empresa'));

prepareReturnAjax(1,$dados);
?>
