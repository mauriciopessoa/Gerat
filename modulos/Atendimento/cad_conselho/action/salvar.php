<?php

echo "teste";

$vo = new ConselhoVO();
$vo1 = new Conselho_ufVO();
$frm->setVo($vo);
ConselhoDAO::insert($vo);

$dados = ConselhoDAO::selectEspecifico('select max(codigo)as codigo from conselho');  

$vo1->setConselho($dados[CODIGO][0]);
$vo1->setUf($frm->get('uf'));
Conselho_ufDAO::insert($vo1);
echo "Dados gravados com sucesso";


?>
