<?php

if ($_POST['psq_cid'])
{
    
    
    $dados = Subclasse_financeiraDAO::selectAll(null, 'descricao like \'%'.$_POST['psq_cid'].'%\'');  
    $g = new TGrid('gd', 'Subclasse Financeira cadastrados', $dados, null, null, 'codigo', null, 15, null);
    $g->addColumn('codigo', 'id', 100, 'left');
    $g->addColumn('descricao', 'Descri��o', 100, 'left');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar subclasse');
    $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Excluir subclasse');

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
    echo '<h3><center><blink>Para cria��o do gride, � necess�rio informar o nome ou parte do nome para pesquisar!</blink></center></h3>';
}

/**
 * fun��es de configura��o do Gride
 */
function tratarBotoes($rowNum, $button, $objColumn, $aData)
{
    if ($aData['codigo'] == '')
    {
        //$button->setVisible(false);
    }

 
}




?>

