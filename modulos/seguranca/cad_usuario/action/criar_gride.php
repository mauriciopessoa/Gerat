<?php
if( $_POST['psq_nome'])
{
 	$dados = UsuarioDAO::selecionarUsuarios($_POST['psq_nome']);
	$g = new TGrid('gd','Usu�rios',$dados,null,null,'ID');
	$g->addColumn('nome','Nome',300,'left');
	$g->addColumn('login','Login',300,'left');
//	$g->addColumn('perfil','Perfil',200,'center');
	//$g->addColumn('cancelado','Cancelado',100,'center');
	$g->addButton('Alterar',null,'btnAlterar','grideAlterar()',null,'editar.gif',null,'Alterar usu�rio');
	//$g->addButton('Cancelar',null,'btnCancelar','grideCancelar()',null,'lixeira.gif',null,'Cancelar usu�rio');
	// adicionar fun��o de tratamento da montagem do gride para desabilitar as a��es de alterar e excluir do usu�rio admin
	//$g->setOnDrawActionButton('tratarBotoes');
    // adicionar fun��o de tratemanto da linha para mudar a cor da fonte dos registros cancelados
	//$g->setOnDrawRow('tratarLinha');
	// adicionar fun��o para tratamento da celula cancelado para escrever sim ou n�o
	//$g->setOnDrawCell('tratarCelula');
	$g->show();
}
else
{
	echo '<h3><center><blink>Informe parte do nome para pesquisar!</blink></center></h3>';
}


/**
* fun��es de configura��o do Gride
*/

function tratarBotoes($rowNum,$button,$objColumn,$aData)
{
	if( $aData['NOME']== 'Administrador')
	{
		$button->setVisible(false);
	}
	if( $aData['CANCELADO']== 'S' && $button->getId()=='btnCancelar')
	{
		$button->setVisible(false);
	}
}

function tratarLinha($row,$rowNum,$aData)
{
	if( $aData['CANCELADO']== 'S')
	{
		$row->setCss('color','#f00');
	}
	else
	{
		$row->setCss('color','#008000');
 	}
}

function tratarCelula($rowNum,$cell,$objColumn,$aData,$edit=null)
{
	
	if( $objColumn->getFieldName()=='cancelado')
	{
		if( $aData['CANCELADO'] == 'S')
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