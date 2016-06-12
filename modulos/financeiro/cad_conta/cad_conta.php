<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Conta', 530, 1000);



Banco_contaDAO::executeSql("set names utf8"); // configurando acentuação no mysql



$frm->addTextField('codigo', 'Código:', 10, false, 10, null, null, null, null, true)->addEvent('onblur', 'buscaConta(this)')->addEvent('onFocus', 'novo()');

$frm->setOnlineSearch('codigo', 'banco_conta'
        , 'numero|Pesquisa por n° da conta:||||||true|true'
        , false
        , true
        , true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
        , 'codigo|Código,agencia|Agência,numero|Conta'
        , 'codigo,agencia,numero,saldo'
        , null
        , null, null, null, null, null, null
        , 'funcaoRetorno()'
        , 10, null, null, 'numero', 'codigo', null, null, null
        , false // caseSensitive
);



$frm->addSelectField('agencia', 'Agência:', false, 'SELECT codigo,numero FROM sql5120145.banco_agencia order by numero')->setCss('font-size', '14px');
$frm->addTextField('numero', 'Conta:', 50, true, 20, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur', 'upperCase(this)');
$frm->addTextField('saldo', 'Saldo em R$:', 20, true, 20, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur', 'upperCase(this)');


$frm->addButtonAjax('Incluir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'fwSave.png','fwSave.png','fwSave.png')->setCss('font-size','24px');
$frm->addButtonAjax('Alterar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','editar.gif')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'lixeira.gif');



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




    function buscaConta(campoChave, valorChave)
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
        if (fwConfirm('Deseja excluir a conta selecionada ?',
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
</script>