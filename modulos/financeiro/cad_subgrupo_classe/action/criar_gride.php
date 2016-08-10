<?php

if ($_POST['psq_cid'])
{
    
    
    $dados = Subclasse_financeiraDAO::selectAll(null, 'descricao like \'%'.$_POST['psq_cid'].'%\'');  
    $g = new TGrid('gd', 'Subclasse Financeira cadastrados', $dados, null, null, 'codigo', null, 15, null);
    $g->addColumn('codigo', 'id', 100, 'left');
    $g->addColumn('descricao', 'Descrição', 100, 'left');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar subclasse');
    $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Excluir subclasse');

    //  $g->addButton( 'Imprimir', null, 'btnpdf','gerar_pdf',null,'print16.gif' );
    $g->addFooter('Total de registros: ' . $g->getRowCount());

    // adicionar função de tratamento da montagem do gride para desabilitar as ações de alterar e excluir do usuário admin
    $g->setOnDrawActionButton('tratarBotoes');
    // adicionar função de tratemanto da linha para mudar a cor da fonte dos registros cancelados
    $g->setOnDrawRow('tratarLinha');
    // adicionar função para tratamento da celula cancelado para escrever sim ou não
    $g->setOnDrawCell('tratarCelula');
    $g->show();
}
else
{
    echo '<h3><center><blink>Para criação do gride, é necessário informar o nome ou parte do nome para pesquisar!</blink></center></h3>';
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

