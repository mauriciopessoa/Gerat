<?php

$vo = new ConselhoVO();
$frm->setVo($vo);
ConselhoDAO::insert($vo);


$vo1 = new Conselho_ufVO();
$frm->setVo($vo1);
Conselho_ufDAO::insert($vo1);

?>
