<?php
$dados = Banco_contaDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
