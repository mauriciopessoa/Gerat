<?php

$vo = new EspecialidadeVO();
$frm->setVo($vo);

EspecialidadeDAO::insert($vo);

?>
