<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de classe de laudo', 530, 1000);



Classe_laudoDAO::executeSql("set names utf8"); // configurando acentuação no mysql


$frm->addTextField('codigo','Código:',10,false,10,null,null,null,null,true)->addEvent('onblur','buscaEspecialidade(this)')->setCss('font-size','14px');
//$frm->addLinkField('pesquisa', null, '<img id="codigo_search" style="width:12px;height:13px;cursor:pointer;" title="Pesquisa" onclick="fwModalBox("Pesquisa","?subform=1&amp;modulo=modulos/atendimento/cad_conselho/pesquisa.php&amp;subform=1&amp;sessionField=atendimento/cad_conselho.php_formdin_codigo",550,650)" src="base/imagens/search.gif">',  'fwModalBox("Pesquisa","?subform=1&amp;modulo=modulos/atendimento/cad_conselho/pesquisa.php&amp;subform=1&amp;sessionField=atendimento/cad_conselho.php_formdin_codigo",550,650)', $strUrl, null, false, null, null);
$frm->addLinkField('pesquisa', null, '<img id="codigo_search" style="width:12px;height:13px;cursor:pointer;" title="Pesquisa" onclick="",380,820,callbackModaBox,{"codigo":""});" src="base/imagens/search.gif">',  'fwModalBox("Pesquisa","?subform=1&amp;modulo=modulos/atendimento/cad_classe_laudo/pesquisa.php&amp;subform=1&amp;sessionField=atendimento/cad_classe_laudo.php_formdin_codigo",550,650,callbackModaBox,{"codigo":""});', $strUrl, null, false, null, null);


/*
$frm->setOnlineSearch('codigo','conselho as a
inner join conselho_uf b on b.conselho= a.codigo
inner join uf c on c.codigo= b.uf'
	,'descricao_conselho|Pesquisa por nome:||||||true|true'
	,false
	,true
	,true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
	,'a.codigo as codigo_conselho|Código,descricao_conselho|Conselho,sigla|UF'
	,'codigo,descricao_conselho,descricao'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,null,null,null,'descricao_conselho','codigo',null,null,null
	,false // caseSensitive
	);
*/

$frm->addTextField('descricao', 'Descrição:', 30,true,30,null,true,null,null,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)')->setCss('text-transform', 'uppercase');
$frm->addSelectField('situacao', 'Situação:', false, 'A=Ativa,I=Inativa', false, null, null, null, null, null, null, 'A')->setCss('font-size','14px');

$frm->addButtonAjax('Salvar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','imagens/btn_salvar.jpg')->setCss('font-size','24px');
$frm->addButtonAjax('Imprimir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg','imagens/btn_imprimir.jpg')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'imagens/btn_excluir.jpg');



$frm->processAction();


$frm->show();






?>


<script>

    function subcadastro()
{
	// Passsando o campo nome como json. Se não for informado o valor, será lido do formulário
	//fwModalBox('Este é um Subcadastro','../teste.php');
	//fwModalBox('Este é um Subcadastro','www.globo.com.br');
	fwModalBox('Este é um Subcadastro',app_index_file+'?modulo=pesquisa.php',380,820,callbackModaBox,{'codigo':''});
}

function callbackModaBox(data, doc )
{
	var msg;
    // exemplo de tratamento do retorno do subcadastro
	jQuery("#codigo").val(data.codigo);
        jQuery("#descricao").val(data.descricao);
        jQuery("#situacao").val(data.situacao);
	
}

	
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
        
        if (res.indexOf('conselho_sigla') >= 0)   
        {
            
            fwAlert('Conselho já cadastrado.');
        }
           else
        {
            fwAlert(res);
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
        if (fwConfirm('Deseja excluir a classe de laudo ?',
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
