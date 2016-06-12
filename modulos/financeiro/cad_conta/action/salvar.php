<?php

$vo = new Banco_contaVO();
$frm->setVo($vo);

Banco_contaDAO::insert($vo);

?>
