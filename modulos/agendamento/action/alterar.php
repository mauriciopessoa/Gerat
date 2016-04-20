<?php
$dados = Tb_agendamentoDAO::select($frm->get('id'));
prepareReturnAjax(1,$dados);
?>
