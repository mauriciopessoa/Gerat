<?php
$dados = Banco_agenciaDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
