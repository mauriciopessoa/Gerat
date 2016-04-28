<?php
$dados = Cid_10DAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
