<?php
$vo = new PerfilVO();
$frm->setVo($vo);
PerfilDAO::insert($vo);
?>