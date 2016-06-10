<?php

$vo = new BancoVO();
$frm->setVo($vo);

BancoDAO::insert($vo);

?>
