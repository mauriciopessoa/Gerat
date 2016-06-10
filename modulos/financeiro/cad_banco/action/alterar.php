<?php
$dados = BancoDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
