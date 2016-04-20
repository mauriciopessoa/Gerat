
<?php
define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Empresa', 530, 1000);



EmpresaDAO::executeSql("set names utf8"); // configurando acentuação no mysql

//$frm->addHiddenField('id');


//$frm->setColumns(100); // define a primeira coluna do formulï¿½rio para 100 px
// define a largura das colunas verticais do formulario para alinhamento dos campos 
//$frm->setColumns(array(100,100,100)); 
//$frm->setColumns(array(100,100)); 



$pc = $frm->addPageControl('pc', null, null, null, 'abaClick()');
$page = $pc->addPage('Cadastro', true, true, 'abaCadastro');
$page->setColorHighlightBackground('#FDFCD7'); // cor de fundo do campo que possuir dica ( hint )
//$frm->addDateField('data_cadastro', 'Data Cadastro:', true, false, date("d/m/Y")); //->addEvent('onblur','sai(this)');




$frm->addTextField('codigo_empresa','Código:',10,false,10,null,null,null,null,true)->addEvent('onblur','buscaEmpresa(this)');
$frm->setOnlineSearch('codigo_empresa','empresa'
	,'razao_social|Razão Social:'
	,false
	,false
	,true // se for encontrada apenas 1 opÃ§Ã£o fazer a seleï¿½ï¿½o automaticamente
	,'codigo_empresa|Código,razao_social|Razão Social'
	,'razao_social|Razão Social'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,null,null,null,null,null,null,null,null
	,false // caseSensitive
	);

$frm->addTextField('razao_social', 'Razão Social:', 50,true,50,null,false,null,null,true)->setCss( 'font-size', '14px')->setCss('text-transform', 'uppercase')->addEvent('onblur','upperCase(this)');
$frm->addTextField('fantasia', 'nome Fantasia:', 50,true)->setCss('font-size','14px')->addEvent('onblur','upperCase(this)');
$frm->addCpfCnpjField('cnpj','CNPJ:',true,null,true)->setCss('font-size','14px');
$frm->addSelectField('situacao', 'Situação:', false, 'A=Ativa,I=Inativa', false, null, null, null, null, null, null, 'A')->setCss('font-size','14px');

//$frm->addButtonAjax('Salvar', null, 'antesSalvar', 'depoisSalvar', 'salvar', 'text', false, null, 'btnSalvar',false);
// $frm->addButton('Novo', null, 'btnNovo', 'novo()');

$frm->addButtonAjax('Salvar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar');

$frm->addButton('Novo', null, 'btnNovo', 'novo()', null, true, false)->setCss('font-size','24px');


$page = $pc->addPage('Pesquisar Empresa', false, true, 'abaEmpresa');
$page->setColumns(100); // define a primeira coluna do formulï¿½rio da aba para 80 px
// o atributo noclear evita que a funï¿½ï¿½o fwClearFields limpe o campo


$frm->addTextField('psq_razao_empresa', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botï¿½o Pesquisar!');
$frm->addButton('Pesquisar', null, 'btnPesquisar', 'atualizarGride()', null, false, false);
$frm->addHtmlField('html_gride');

$frm->closeGroup(); // fim das abas

$frm->processAction();


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
        if (res)
        {
            fwAlert(res);
        }
        else
        {
            fwAlert('Dados gravados com SUCESSO!');
          //  novo();
        }
    }

    function novo()
    {
        fwClearChildFields();
        fwSelecionarAba('abaCadastro');
        fwSetFocus('codigo_empresa');
    }

    function abaClick(pc, aba, id)
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

        }


    }
    
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
                fwSelecionarAba('abaCadastro');
                
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
                fwSelecionarAba('abaCadastro');
            }
        });
    }
    function grideCancelar(campoChave, valorChave)
    {
        if (fwConfirm('Deseja cancelar a cirurgia ?',
                function(r) {
                    if (r == true)
                    {
                        fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"id": valorChave},
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
</script>