<?php
$dados = CartaoDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
