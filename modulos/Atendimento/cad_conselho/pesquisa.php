<?php

$frm = new TForm('Pesquisa', 550, 500);
$frm->addTextField('psq_cid', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botï¿½o Pesquisar!');

$frm->addTextField('psq_cid', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botï¿½o Pesquisar!');
$frm->addButton('Pesquisar', null, 'btnPesquisar', 'atualizarGride()', null, false, false);
$frm->addHtmlField('html_gride');
$frm->closeGroup(); // fim das abas
$frm->processAction();
$frm->show();


function setgrid(){
if (empty($_POST['psq_cid']))
{
        
    $dados = ConselhoDAO::selectEspecifico(null, 'select a.*,b.conselho,b.uf from conselho a inner join conselho_uf b on a.codigo= b.conselho where descricao_conselho= '.$_POST['psq_cid']);  
    echo $dados;
    $g = new TGrid('gd', 'Conselho cadastrado', $dados, null, null, 'codigo', null, 15, null);
    $g->addColumn('codigo', 'id', 400, 'left');
    $g->addColumn('descricao_conselho', 'Descrição', 300, 'left');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar Especialidade');
    $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Excluir CID');

    //  $g->addButton( 'Imprimir', null, 'btnpdf','gerar_pdf',null,'print16.gif' );
    $g->addFooter('Total de registros: ' . $g->getRowCount());

    // adicionar função de tratamento da montagem do gride para desabilitar as ações de alterar e excluir do usuário admin
    $g->setOnDrawActionButton('tratarBotoes');
    // adicionar função de tratemanto da linha para mudar a cor da fonte dos registros cancelados
    $g->setOnDrawRow('tratarLinha');
    // adicionar função para tratamento da celula cancelado para escrever sim ou não
    $g->setOnDrawCell('tratarCelula');
    $g->show();
} else
    {
        echo '<h3><center><blink>Para criação do gride, é necessário informar o nome ou parte do nome para pesquisar!</blink></center></h3>';
    }
}
/**
 * funções de configuração do Gride
 */
function tratarBotoes($rowNum, $button, $objColumn, $aData)
{
    if ($aData['codigo'] == '')
    {
        //$button->setVisible(false);
    }

 
}




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
            fwClearChildFields();
          //  novo();
        }
    }
    function novo()
    {
        fwClearChildFields();
        fwSelecionarAba('abaCadastro');
        fwSetFocus('codigo');
    }
    function abaClick(pc, aba, id)
    {
        if (id == 'abaCadastro')
        {
            if (jQuery("#psq_cid").val() != '')
            {
                atualizarGride();
            }
        }
        if (id == 'abaCID')
        {
            jQuery("#Salvar").attr('disabled', 'disabled');
        }
    }
    
    function atualizarGride()
    {
        fwGetGrid('atendimento/cad_conselho/cad_conselho.php', 'html_gride', {"action": "criar_gride", "psq_cid": ""});
        
    }
    
    function buscaCID(campoChave, valorChave)
    {
        
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
            "data": {"codigo": valorChave},
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
