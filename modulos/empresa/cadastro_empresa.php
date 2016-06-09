
<?php
define('REQUIRED_FIELD_MARK', '*'); // alterar a identifica��o dos campos obrigat�rios para * vermelho

$frm = new TForm('Cadastro de Empresa', 530, 1000);



EmpresaDAO::executeSql("set names utf8"); // configurando acentua��o no mysql

$frm->addTextField('codigo_empresa','C�digo:',10,false,10,null,null,null,null,true)->addEvent('onblur','buscaEmpresa(this)')->addEvent('onFocus','novo()');

$frm->setOnlineSearch('codigo_empresa','empresa'
	,'razao_social|Raz�o Social:||||||true|true'
	,false
	,true
	,true // se for encontrada apenas 1 opção fazer a sele��o automaticamente
	,'codigo_empresa|C�digo,razao_social|Raz�o Social'
	,'codigo_empresa,razao_social,fantasia,endereco,bairro,cidade,cep,uf,email,telefone1,telefone2,fax,cnpj,ie,situacao'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,2,null,null,'razao_social','codigo_empresa',null,null,null
	,false // caseSensitive
	);

$frm->addTextField('razao_social', 'Raz�o Social:', 50,true,50,null,false,null,null,true)->setCss( 'font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur','upperCase(this)');
$frm->addTextField('fantasia', 'Nome Fantasia:', 50,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addTextField('endereco', 'Endere�o:', 50,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addTextField('bairro', 'Bairro:', 50,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addTextField('cidade', 'Cidade:', 50,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addCepField('cep','CEP:',9,true);
$frm->addSelectField('uf','UF:',false,'SELECT codigo,descricao FROM sql5120145.uf')->setCss('font-size','14px');
$frm->addEmailField(email,'Email:',50,true);

$frm->addFoneField('telefone1','Telefone principal:',20,true);
$frm->addFoneField('telefone2','Telefone alternativo:',20,true);
$frm->addFoneField('fax','Fax:',11,true);



$frm->addCpfCnpjField('cnpj','CNPJ:',true,null,true)->setCss('font-size','14px');
$frm->addTextField('ie','Inscri��o Estadual:',18,true)->setCss('font-size','14px')->addEvent('onkeyup', 'maskIe(this)');
$frm->addSelectField('situacao', 'Situa��o:', false, 'A=Ativa,I=Inativa', false, null, null, null, null, null, null, 'A')->setCss('font-size','14px');



$frm->closeGroup(); // fim das abas

$frm->processAction();


$frm->addButtonAjax('Incluir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'fwSave.png','fwSave.png','fwSave.png')->setCss('font-size','24px');
$frm->addButtonAjax('Alterar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','editar.gif')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'lixeira.gif');

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
       
       if (res.indexOf('IND_empresa_cnpj') >= 0)   
        {
            
            fwAlert('CNPJ duplicado na base.');
        }
        else if(res.indexOf('IND_empresa_razao_social') >= 0)   
            
               {
            
                  fwAlert('J� existe uma empresa com a mesma raz�o social.');
                }
                else if(res.indexOf('IND_empresa_fantasia') >= 0)   
            
               {
            
                  fwAlert('J� existe uma empresa com o mesmo nome fantasia.');
                }
        else
    
        {
            fwAlert('Dados gravados com SUCESSO!');
          //  novo();
        }
    }
    
        function depoisCancelar(res)
    {
        if (res)
        {
            fwAlert(res);
            novo();
        }
        else
        {
            fwAlert('Empresa exclu�da com sucesso!');
            novo();
        }
    }
    

    function novo()
    {
        fwClearChildFields();
       // fwSetFocus('codigo_empresa');
    }

    
    function buscaEmpresa(campoChave, valorChave)
    {
        
        fwAjaxRequest({
            "action": "alterar",
            "dataType": "json",
            
            "data": {"codigo_empresa": valorChave},
            "callback": function(dados)
            {
                fwClearChildFields();
                if (dados.message)
                {
                    fwAlert(dados.message);
                    return;
                }
        
                fwUpdateFieldsJson(dados);
              //  fwSelecionarAba('abaCadastro');
                
            }
        });
    }
    
    function grideAlterar(campoChave, valorChave)
    {
        fwAjaxRequest({
            "action": "alterar",
            "dataType": "json",
            //"data": {"id": valorChave},
            "data": {"codigo_empresa": valorChave},
            "callback": function(dados)
            {
                if (dados.message)
                {
                    fwAlert(dados.message);
                    return;
                }
                fwUpdateFieldsJson(dados);
             //   fwSelecionarAba('abaCadastro');
            }
        });
    }
    function grideCancelar(campoChave, valorChave)
    {
        if (fwConfirm('Deseja excluir empresa ?',
                function(r) {
                    if (r == true)
                    {
                        fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"codigo_empresa": valorChave},
                            "callback": function(res)
                            {
                                if (res)
                                {
                                    fwAlert(res);
                                }
                                atualizarGride();
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


 //envento onkeyup
 function maskIe(ie) {
 	var evt = window.event;
 	kcode=evt.keyCode;
 	if (kcode == 8) return;
 	if (ie.value.length == 2) { ie.value = ie.value + '.'; }
 	if (ie.value.length == 6) { ie.value = ie.value + '.'; }
 	if (ie.value.length == 10) { ie.value = ie.value + '/'; }
        if (ie.value.length == 15) { ie.value = ie.value + '-'; }
 }
//11.111.111/111-11

 function retiraFormatacao(CPF)
 {
 	with (CPF)
 	{
 		value = value.replace (".","");
 		value = value.replace (".","");
 		value = value.replace ("-","");
 		value = value.replace ("/","");
 	}
 }

</script>

