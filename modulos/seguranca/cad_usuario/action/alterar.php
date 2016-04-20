<?php
$dados = UsuarioDAO::select($frm->get('id'));
prepareReturnAjax(1,$dados);
?>
