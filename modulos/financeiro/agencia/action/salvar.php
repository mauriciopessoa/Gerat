<?php

$vo = new Banco_agenciaVO();
$frm->setVo($vo);

Banco_agenciaDAO::insert($vo);

?>
