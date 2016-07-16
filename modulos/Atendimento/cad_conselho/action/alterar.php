<?php
$dados = EspecialidadeDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
