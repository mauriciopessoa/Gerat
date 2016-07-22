<?php
$dados = ConselhoDAO::select($frm->get('codigo'));
$dados1 = Conselho_ufDAO::selectEspecifico('select conselho,uf from conselho_uf where conselho='.$frm->get('codigo'));

//print_r($dados);
if (empty($dados1)){
    
    echo "Código não cadastrado.";
}
 else{
     $array_resultado = array_merge($dados, $dados1);
     prepareReturnAjax(1,$array_resultado);
     
 }
?>
