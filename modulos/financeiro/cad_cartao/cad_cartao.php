<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Cartão', 530, 1000);



Banco_contaDAO::executeSql("set names utf8"); // configurando acentuação no mysql



$frm->addTextField('codigo', 'Código:', 10, false, 10, null, null, null, null, true)->addEvent('onblur', 'buscaCartao(this)')->addEvent('onFocus', 'novo()')->setCss('font-size','14px');

$frm->setOnlineSearch('codigo', 'cartao'
        , 'nome|Pesquisa por nome do cartão:||||||true|true'
        , false
        , true
        , true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
        , 'codigo|Código,nome|Cartão,prazo_pgto|Prazo'
        , 'codigo,nome,prazo_pagto,banco_conta,situacao'
        , null
        , null, null, null, null, null, null
        , 'funcaoRetorno()'
        , 50, null, null, 'nome', 'codigo', null, null, null
        , false // caseSensitive
);


$frm->addTextField('nome', 'Nome:', 50, true, 20, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur', 'upperCase(this)');
$mixOptions = TPDOConnection::executeSql( 'SELECT c.codigo,CONCAT("Conta ",c.numero," Ag. ",a.numero," - ",b.nome) as numero 
                                                FROM sql5120145.banco_agencia a, sql5120145.banco b ,sql5120145.banco_conta c 
                                                    where b.codigo = a.banco and a.codigo= c.agencia order by b.nome,c.numero,a.numero');


$frm->addSelectField('banco_conta', 'Conta:', false, $mixOptions,20,true,20,null,true,null,null,true)->setCss('font-size', '14px');
$frm->addTextField('prazo_pagto', 'Prazo:', 50, true, 10, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur', 'upperCase(this)');
$frm->addSelectField('situacao', 'Situação:', false, 'A=Ativa,I=Inativa', false, null, null, null, null, null, null, 'A')->setCss('font-size','14px');

$frm->addButtonAjax('Salvar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','imagens/btn_salvar.jpg')->setCss('font-size','24px');
$frm->addButtonAjax('Imprimir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'imagens/btn_excluir.jpg');




$frm->processAction();


$frm->show();
?>


<script>




    function upperCase(obj)
    {
        obj.value = obj.value.toUpperCase();

    }


    function antesSalvar()
    {

        if (!fwValidateFields())
        {
            return false;
        }
      
 
            return true;

    }

    function depoisSalvar(res)
    {
        if (res)
        {
            fwAlert(res);
        } else
        {
            
            fwAlert('Dados gravados com SUCESSO!');
            fwClearChildFields();
           
        }
    }

    function novo()
    {
        fwClearChildFields();

        //fwSetFocus('codigo');

    }




    function buscaCartao(campoChave, valorChave)
    {
        if (document.getElementById("codigo").value == "") {
            return;
        } else {

            fwAjaxRequest({
                "action": "alterar",
                "dataType": "json",
                "data": {"codigo": valorChave},
                "callback": function (dados)
                {
                    fwClearChildFields();
                    if (dados.message)
                    {
                        fwAlert(dados.message);
                        return;
                    }

                    fwUpdateFieldsJson(dados);


                }
            });
        }
    }

    function grideAlterar(campoChave, valorChave)
    {
        fwAjaxRequest({
            "action": "alterar",
            "dataType": "json",
            //"data": {"id": valorChave},
            "data": {"codigo": valorChave},
            "callback": function (dados)
            {
                if (dados.message)
                {
                    fwAlert(dados.message);
                    return;
                }
                fwUpdateFieldsJson(dados);

            }
        });
    }
    function grideCancelar(campoChave, valorChave)
    {
        if (fwConfirm('Deseja excluir o cartão selecionado ?',
                function (r) {
                    if (r == true)
                    {
                        fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"codigo": valorChave},
                            "callback": function (res)
                            {
                                if (res)
                                {
                                    fwAlert(res);
                                }
                                novo();
                            }
                        });
                    }
                })
                )
            ;
    }


    function funcaoRetorno()
    {
        return;
    }
    
    
    function moeda2float(moeda){
            v = moeda.value;
            v = v.replace(".","");

            v = v.replace(",",".");
           // v=  v.replace(/(\d{1})(\d{1,2})$/,"$1.$2") // coloca virgula antes dos ultimos 2 digitos
            saldo.value = v;
    }
    
    function moeda(z){
        v = z.value;
        v=v.replace(/\D/g,"") // permite digitar apenas numero
        v=v.replace(/(\d{1})(\d{14})$/,"$1.$2") // coloca ponto antes dos ultimos digitos
        v=v.replace(/(\d{1})(\d{11})$/,"$1.$2") // coloca ponto antes dos ultimos 11 digitos
        v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 8 digitos
        v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 5 digitos
        v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 2 digitos
    z.value = v;
}
</script>