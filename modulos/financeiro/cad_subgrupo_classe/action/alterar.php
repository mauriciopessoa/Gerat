<?php
$dados = Subclasse_financeiraDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
