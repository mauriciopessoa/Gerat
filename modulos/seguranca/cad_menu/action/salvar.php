<?php
$vo = new MenuVO();
$frm->setVo($vo);
//d($vo);
//die();
MenuDAO::insert($vo);
?>