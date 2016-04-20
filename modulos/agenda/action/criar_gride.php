<?php

if ($_POST['psq_razao_empresa'])
{
    
    $dados = EmpresaDAO::selectAll(null, 'razao_social like \'%'.$_POST['psq_razao_empresa'].'%\'');        
    
    $g = new TGrid('gd', 'Empresas Cadastradas', $dados, null, null, 'codigo_empresa', null, 15, null);
    $g->addColumn('razao_social', 'Raz�o Social', 400, 'left');
    $g->addColumn('fantasia', 'Nome Fantasia', 300, 'left');
    //$g->addColumn('cancelada', 'Cancelada', 30, 'center');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar Empresa');
   // $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Cancelar Cirurgia');

    //  $g->addButton( 'Imprimir', null, 'btnpdf','gerar_pdf',null,'print16.gif' );
    $g->addFooter('Total de registros: ' . $g->getRowCount());

    // adicionar fun��o de tratamento da montagem do gride para desabilitar as a��es de alterar e excluir do usu�rio admin
    $g->setOnDrawActionButton('tratarBotoes');
    // adicionar fun��o de tratemanto da linha para mudar a cor da fonte dos registros cancelados
    $g->setOnDrawRow('tratarLinha');
    // adicionar fun��o para tratamento da celula cancelado para escrever sim ou n�o
    $g->setOnDrawCell('tratarCelula');
    $g->show();
}
else
{
    echo '<h3><center><blink>Informe algo para pesquisar!</blink></center></h3>';
}

/**
 * fun��es de configura��o do Gride
 */
function tratarBotoes($rowNum, $button, $objColumn, $aData)
{
    if ($aData['RAZAO_SOCIAL'] == '')
    {
        $button->setVisible(false);
    }

    if ($aData['CANCELADA'] == 'S' && $button->getId() == 'btnCancelar')
    {
        $button->setVisible(false);
    }
}

function tratarLinha($row, $rowNum, $aData)
{
    if ($aData['CANCELADA'] == 'S')
    {
        $row->setCss('color', '#f00');
    }
    else
    {
        $row->setCss('color', '#008000');
    }
}

function tratarCelula($rowNum, $cell, $objColumn, $aData, $edit = null)
{

    if ($objColumn->getFieldName() == 'cancelada')
    {
        if ($aData['CANCELADA'] == 'S')
        {
            $cell->setValue('Sim');
        }
        else
        {
            $cell->setValue('N�o');
        }
    }
}

?>
