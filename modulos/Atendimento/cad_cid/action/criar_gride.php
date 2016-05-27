<?php

if ($_POST['psq_cid'])
{
    
    $dados = Cid_10DAO::selectAll(null, 'descricao like \'%'.$_POST['psq_cid'].'%\'');        
    
    $g = new TGrid('gd', 'CIDs Cadastradas', $dados, null, null, 'codigo', null, 15, null);
    $g->addColumn('cod_cid', 'CID', 400, 'left');
    $g->addColumn('descricao', 'Descri��o', 300, 'left');
    //$g->addColumn('cancelada', 'Cancelada', 30, 'center');
    $g->addButton('Alterar', null, 'btnAlterar', 'grideAlterar()', null, 'editar.gif', null, 'Alterar CID');
    $g->addButton('Cancelar', null, 'btnCancelar', 'grideCancelar()', null, 'lixeira.gif', null, 'Excluir empresa');

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
