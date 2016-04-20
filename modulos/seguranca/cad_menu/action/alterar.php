<?php
$dados = MenuDAO::select($frm->get('id_menu'));
prepareReturnAjax(1,$dados);
?>