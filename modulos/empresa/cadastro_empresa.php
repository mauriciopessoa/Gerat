
<?php
define('REQUIRED_FIELD_MARK', '*'); // alterar a identifica��o dos campos obrigat�rios para * vermelho

$frm = new TForm('Cadastro de Empresa', 530, 1000);



EmpresaDAO::executeSql("set names utf8"); // configurando acentua��o no mysql

//$frm->addHiddenField('id');


//$frm->setColumns(100); // define a primeira coluna do formul�rio para 100 px
// define a largura das colunas verticais do formulario para alinhamento dos campos 
//$frm->setColumns(array(100,100,100)); 
//$frm->setColumns(array(100,100)); 



//$pc = $frm->addPageControl('pc', null, null, null, 'abaClick()');
//$page = $pc->addPage('Cadastro', true, true, 'abaCadastro');
//$page->setColorHighlightBackground('#FDFCD7'); // cor de fundo do campo que possuir dica ( hint )
//$frm->addDateField('data_cadastro', 'Data Cadastro:', true, false, date("d/m/Y")); //->addEvent('onblur','sai(this)');




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

//$frm->addButtonAjax('Salvar', null, 'antesSalvar', 'depoisSalvar', 'salvar', 'text', false, null, 'btnSalvar',false);
// $frm->addButton('Novo', null, 'btnNovo', 'novo()');

          


//$page = $pc->addPage('Pesquisar Empresa', false, true, 'abaEmpresa');
//$page->setColumns(100); // define a primeira coluna do formul�rio da aba para 80 px
// o atributo noclear evita que a fun��o fwClearFields limpe o campo


//$frm->addTextField('psq_razao_empresa', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no bot�o Pesquisar!')->addEvent('onblur','fwClearChildFields()');
//$frm->addButton('Pesquisar', null, 'btnPesquisar', 'atualizarGride()', null, true, false);
//$frm->addHtmlField('html_gride');

$frm->closeGroup(); // fim das abas

$frm->processAction();

//$frm->addButton('Alterar', null, 'btnNovo', 'salvar()', null, null, null, 'editar.gif');
//$frm->addButtonAjax('Incluir', null, null,'novo', null, null,'text', true, false,'btnnovo')->setCss('font-size','24px');
$frm->addButtonAjax('Incluir',null,null,'novo','novo','Novo...','text',false,null,'btnNovo',null,'fwSave.png','fwSave.png','fwSave.png')->setCss('font-size','24px');
$frm->addButtonAjax('Alterar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,'fwSave.png','fwSave.png','editar.gif')->setCss('font-size','24px');
$frm->addButton('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'lixeira.gif');
//$frm->addButtonAjax('Excluir', null, 'btnCancelar', 'grideCancelar()', null, null, null, 'lixeira.gif');


$frm->show();






?>


<script>
    


    //jQuery("#data_cadastro").attr('readonly', 'true');

    //jQuery("#Novo").attr('disabled', 'true');

    function pegaNomeConvenio(e)
    {
        //fwAtualizarCampos('nome_convenio', jQuery("#cod_convenio option:selected").text());
        
    }

    function pegaNomeCirurgia(e)
    {
        //fwAtualizarCampos('desc_cirurgia_principal', jQuery("#cod_cirurgia_principal option:selected").text());
        
    }

    function pegaNomeCirurgiao(e)
    {
        //fwAtualizarCampos('nome_cirurgiao_principal', jQuery("#cod_cirurgiao_principal option:selected").text());
        
    }

    function pegaNomeEspecialidade(e)
    {
        //fwAtualizarCampos('desc_especialidade', jQuery("#cod_especialidade option:selected").text());
        
    }

    function sai(e)
    {
        //alert(jQuery("#data_cadastro").val());
        

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

   /* function abaClick(pc, aba, id)
    {
        if (id == 'abaCadastro')
        {

            if (jQuery("#psq_razao_empresa").val() != '')
            {
                atualizarGride();
            }

        }

        if (id == 'abaEmpresa')
        {
           
            jQuery("#Salvar").attr('disabled', 'disabled');
             $("#Salvar").css("display", "none");
             $("#btnSalvar").hide("slow");
             fwSetFocus('psq_cid');

        }


    }
    */
    function atualizarGride()
    {
        fwGetGrid('empresa/cadastro_empresa.php', 'html_gride', {"action": "criar_gride", "psq_razao_empresa": ""});
        
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

