<?php
define('REQUIRED_FIELD_MARK', '*'); // alterar a identificaï¿½ï¿½o dos campos obrigatï¿½rios para * vermelho

$frm = new TForm('Cadastro de Agenda', 530, 1000);

AgendaDAO::executeSql("set names utf8"); // configurando acentuação no mysql



$frm->setColorHighlightBackground('#FDFCD7'); // cor de fundo do campo que possuir dica ( hint )
//$frm->addDateField('data_cadastro', 'Data Cadastro:', true, false, date("d/m/Y")); //->addEvent('onblur','sai(this)');


$dados = AgendaDAO::selectAll(null, 'razao_social like \'%'.$_POST['psq_razao_empresa'].'%\''); 

$frm->addCheckField('st_publico','Na análise do Advogado esta peça deve ser pública?',false,null,null,null,null,null,null,null,null,true);


$frm->addTextField('codigo_empresa','Código:',10,false,10)->addEvent('onblur','buscaEmpresa(this)');
$frm->setOnlineSearch('codigo_empresa','empresa'
	,'razao_social|Razão Social:'
	,false
	,false
	,true // se for encontrada apenas 1 opï¿½ï¿½o fazer a seleï¿½ï¿½o automaticamente
	,'codigo_empresa|Código,razao_social|Razão Social'
	,'razao_social|Razão Social'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,null,null,null,null,null,null,null,null
	,false // caseSensitive
	);

$frm->addTextField('razao_social', 'Razão Social:', 50,true)->setCss('text-transform', 'uppercase');
$frm->addTextField('fantasia', 'nome Fantasia:', 50,true);
$frm->addCpfCnpjField('cnpj','CNPJ:',true,null,true);




$frm->processAction();
$frm->addButtonAjax('Salvar', null, 'antesSalvar', 'depoisSalvar', 'salvar', 'Salvando...', 'text', false, null, 'btnSalvar');
$frm->addButton('Novo', null, 'btnNovo', 'novo()');


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
            novo();
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