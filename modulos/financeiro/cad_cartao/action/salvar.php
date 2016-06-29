<?php

$vo = new CartaoVO();
$frm->setVo($vo);

CartaoDAO::insert($vo);

?>
