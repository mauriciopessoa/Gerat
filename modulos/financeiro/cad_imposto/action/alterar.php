<?php
$dados = ImpostoDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
