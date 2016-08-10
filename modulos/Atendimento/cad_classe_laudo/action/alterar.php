<?php
$dados = Classe_laudoDAO::select($frm->get('codigo'));
prepareReturnAjax(1,$dados);
?>
