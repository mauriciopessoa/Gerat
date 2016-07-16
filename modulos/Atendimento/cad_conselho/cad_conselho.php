<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Conselho', 530, 1000);



EspecialidadeDAO::executeSql("set names utf8"); // configurando acentuação no mysql


$frm->addTextField('codigo','Código:',10,false,10,null,null,null,null,true)->addEvent('onblur','buscaEspecialidade(this)')->setCss('font-size','14px');

$frm->setOnlineSearch('codigo','conselho as a
inner join conselho_uf b on b.conselho= a.codigo
inner join uf c on c.codigo= b.uf'
	,'descricao_conselho|Pesquisa por nome:||||||true|true'
	,false
	,true
	,true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
	,'a.codigo|Código,descricao_conselho|Conselho,sigla|UF'
	,'codigo,descricao_conselho,descricao'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,null,null,null,'descricao_conselho','codigo',null,null,null
	,false // caseSensitive
	);

$frm->addTextField('sigla', 'Sigla Conselho:', 20,true,20,null,true,null,null,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)')->setCss('text-transform', 'uppercase');
$frm->addTextField('descricao_conselho', 'Descrição:', 30,true,30,null,true,null,null,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)')->setCss('text-transform', 'uppercase');
$frm->addSelectField('uf','UF Conselho:',false,'SELECT codigo,descricao FROM sql5120145.uf',null,true)->setCss('font-size','14px');

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
        
        if (res.indexOf('nome_especialidade') >= 0)   
        {
            
            fwAlert('Especialiadade já cadastrada.');
        }
           else
        {
            fwAlert('Dados gravados com SUCESSO!');
            fwClearChildFields();
          //  novo();
        }
    }

    function novo()
    {
        fwClearChildFields();
        fwSetFocus('codigo');
    }

    
    function buscaEspecialidade(campoChave, valorChave)
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
        if (fwConfirm('Deseja excluir esta especialidade ?',
                function(r) {
                    if (r == true)
                    {
                             fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"codigo": valorChave},
                            "callback": function(res)
                            {
                                 novo();
                                if (res)
                                {
                                    fwAlert(res);
                                }
                               
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
