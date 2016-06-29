<?php
$dados = PaisDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
