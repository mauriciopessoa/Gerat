<?php

$vo = new PaisVO();
$frm->setVo($vo);

PaisDAO::insert($vo);

?>
