<?php
$dados = UfDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
