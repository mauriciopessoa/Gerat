<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de agência bancária', 530, 1000);



Banco_agenciaDAO::executeSql("set names utf8"); // configurando acentuação no mysql



$frm->addTextField('codigo','Código:',10,false,10,null,null,null,null,true)->addEvent('onblur','buscaAgencia(this)')->addEvent('onFocus','novo()')->setCss('font-size','14px');

$frm->setOnlineSearch('codigo','banco_agencia'
	,'numero|Pesquisa por nome:||||||true|true'
	,false
	,true
	,true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
	,'codigo|Código,numero|Agência'
	,'codigo,banco,numero,endereco,cidade,uf,situacao'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,10,null,null,'numero','codigo',null,null,null
	,false // caseSensitive
	);


$frm->addTextField('numero', 'Agência:', 20,true,20,null,true,null,null,true)->setCss( 'font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur','upperCase(this)');
$frm->addSelectField('banco','Banco:',false,'SELECT codigo,nome FROM sql5120145.banco order by nome',20,true,20,null,true,null,null,true)->setCss('font-size','14px');

$frm->addTextField('endereco', 'Endereço:', 50,true,50,null,true,null,null,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addTextField('cidade', 'Cidade:', 30,true,30,null,true,null,null,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addSelectField('uf','UF:',false,'SELECT codigo,descricao FROM sql5120145.uf',20,true,20,null,true,null,null,true)->setCss('font-size','14px');
$frm->addSelectField('situacao', 'Situação:', false, 'A=Ativa,I=Inativa', false, null, null, null, null, null, null, 'A')->setCss('font-size','14px');

$frm->closeGroup(); 

$frm->processAction();


$frm->addButtonAjax('Salvar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','imagens/btn_salvar.jpg')->setCss('font-size','24px');
$frm->addButtonAjax('Imprimir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'imagens/btn_excluir.jpg');





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
        }
        else
        {
            fwAlert('Dados gravados com SUCESSO!');
            fwClearChildFields();
          
        }
    }

    function novo()
    {
        fwClearChildFields();
     
        //fwSetFocus('numero');

    }
    

 
    
    function buscaAgencia(campoChave, valorChave)
    {
     
         if(document.getElementById("codigo").value == ""){
            return;
        } else {
       
        fwAjaxRequest({
            "action": "alterar",
            "dataType": "json",
            
            "data": {"codigo": valorChave},
            "callback": function(dados)
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
            "callback": function(dados)
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
        if (fwConfirm('Deseja excluir a agência selecionada ?',
                function(r) {
                    if (r == true)
                    {
                        fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"codigo": valorChave},
                            "callback": function(res)
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
	 return false;
    }
</script>
