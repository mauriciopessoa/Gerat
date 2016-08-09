<?php
$dados = Classe_financeiraDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
