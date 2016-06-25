<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Conta', 530, 1000);



Banco_contaDAO::executeSql("set names utf8"); // configurando acentuação no mysql



$frm->addTextField('codigo', 'Código:', 10, false, 10, null, null, null, null, true)->addEvent('onblur', 'buscaConta(this)')->addEvent('onFocus', 'novo()')->setCss('font-size','14px');

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
        , 50, null, null, 'numero', 'codigo', null, null, null
        , false // caseSensitive
);

$mixOptions = TPDOConnection::executeSql( 'SELECT a.codigo,CONCAT(a.numero," - ",b.nome) as numero FROM sql5120145.banco_agencia a, sql5120145.banco b where b.codigo = a.banco order by a.numero,b.nome');


$frm->addSelectField('agencia', 'Agência:', false, $mixOptions,20,true,20,null,true,null,null,true)->setCss('font-size', '14px');
$frm->addTextField('numero', 'Conta:', 50, true, 20, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur', 'upperCase(this)');
//$frm->addNumberField('saldo', 'Saldo em R$:', 10, true, 2, null, true, null, null, true,null,null,null,true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onSubmit', 'moeda2float(saldo.value)');
$frm->addTextField('saldo', 'Saldo em R$:', 15, true, 15, null, true, null, null, true)->setCss('font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onkeyup', 'moeda(this)')->addEvent('onblur','moeda2float(this)');

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
      
        if(document.getElementById("saldo").value == "0")
        {
        
            document.getElementById("saldo").value ='0';
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