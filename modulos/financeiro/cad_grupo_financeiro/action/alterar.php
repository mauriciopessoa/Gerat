<?php
$dados = Grupo_financeiroDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
