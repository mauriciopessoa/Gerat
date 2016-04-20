<?php

$vo = new Tb_agendamentoVO();
$frm->setVo($vo);

Tb_agendamentoDAO::insert($vo);

?>
