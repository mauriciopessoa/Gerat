<?php

$frm = new TForm('Pesquisa', 500, 600);
$frm->addHiddenField('codigo', $strLabel,10);
$frm->addHiddenField('descricao', $strLabel,10);
$frm->addHiddenField('situacao', $strLabel,10);
$frm->addTextField('psq_cid', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botï¿½o Pesquisar!');
//$frm->addHiddenField('codigo');


$frm->addTextField('psq_cid', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botï¿½o Pesquisar!');
$frm->addButton('Pesquisar', null, 'btnPesquisar', 'atualizarGride()', null, false, false);
$frm->addHtmlField('html_gride');
$frm->processAction();
$frm->show();


function setgrid(){
if (empty($_POST['psq_cid']))
{
        
    $dados = Classe_financeiraDAO::selectEspecifico(null, 'select * from classe_financeira where descricao= '.$_POST['psq_cid']);  
    $g = new TGrid('gd', 'Classe financeira cadastrada', $dados, null, null, 'codigo', null, 15, null);
    $g->addColumn('codigo', 'Código', 400, 'left');
    $g->addColumn('descricao', 'Descrição', 300, 'left');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar classe financeira');
    $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Excluir classe financeira');

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

    function atualizarGride()
    {
        fwGetGrid('financeiro/cad_classes/cad_classes.php', 'html_gride', {"action": "criar_gride", "psq_cid": ""});
        
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
                fwClose_window();
                
            }
        });
    }
    function grideCancelar(campoChave, valorChave)
    {
        if (fwConfirm('Deseja cancelar a classe financeira?',
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
                                atualizarGride();
                            }
                        });
                    }
                })
                )
            ;
    }
</script>
