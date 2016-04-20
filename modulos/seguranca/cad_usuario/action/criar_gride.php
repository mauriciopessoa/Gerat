<?php
if( $_POST['psq_nome'])
{
 	$dados = UsuarioDAO::selecionarUsuarios($_POST['psq_nome']);
	$g = new TGrid('gd','Usuários',$dados,null,null,'ID');
	$g->addColumn('nome','Nome',300,'left');
	$g->addColumn('login','Login',300,'left');
//	$g->addColumn('perfil','Perfil',200,'center');
	//$g->addColumn('cancelado','Cancelado',100,'center');
	$g->addButton('Alterar',null,'btnAlterar','grideAlterar()',null,'editar.gif',null,'Alterar usuário');
	//$g->addButton('Cancelar',null,'btnCancelar','grideCancelar()',null,'lixeira.gif',null,'Cancelar usuário');
	// adicionar função de tratamento da montagem do gride para desabilitar as ações de alterar e excluir do usuário admin
	//$g->setOnDrawActionButton('tratarBotoes');
    // adicionar função de tratemanto da linha para mudar a cor da fonte dos registros cancelados
	//$g->setOnDrawRow('tratarLinha');
	// adicionar função para tratamento da celula cancelado para escrever sim ou não
	//$g->setOnDrawCell('tratarCelula');
	$g->show();
}
else
{
	echo '<h3><center><blink>Informe parte do nome para pesquisar!</blink></center></h3>';
}


/**
* funções de configuração do Gride
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
			$cell->setValue('Não');
		}
	}	
}
?>