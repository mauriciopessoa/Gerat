<?php
$frm = new TForm('Menu Principal do Sistema',500);

$frm->addHiddenField('id_menu');
$frm->addHiddenField('id_menu_pai');

$pc = $frm->addPageControl('pc',null,null,null,'abaClick()');

$pc->addPage('Cadastro',true,true,'abaCadastro');

	$frm->addGroupField('gpTree','Selecione o Item Pai',null,null,null,null,true,'gpMenu',false);
		$dados = MenuDAO::selectAll( 'ORDEM' );
	    $tree = $frm->addTreeField( 'tree','Raiz',$dados,'ID_MENU_PAI','ID_MENU','ROTULO',null,null,200);
	    $tree->setOnDblClick('treeDblClick()');
	    $tree->setStartExpanded( true );
	    $tree->setTheme( 'winstyle' ); // define as imagens da treeview ( tema )
	$frm->closeGroup();

	$frm->addGroupField('gpCadastro','Item de Menu',null,null,null,null,true,'gpMenu',true);
		$frm->addTextField('rotulo_pai','Item Pai:',50,false,null,null,null,'Duplo clique para selecionar item pai')->setReadOnly(true)->setCss(array('color'=>'#0000FF','font-size'=>'18px','cursor'=>'pointer') )->addEvent('onDblClick','fwGroupOpen("gpTree")');
		$frm->addSelectField('id_modulo','Módulo Executar:',false,ModuloDAO::selectAll('NOME_MENU'),null,null,null,null,null,null,'-- não executar módulo --','','ID_MODULO','NOME_MENU')->addEvent('onChange','id_moduloChange(this)');
		$frm->addTextField('rotulo','Rótulo:',50,true,50);
		$frm->addNumberField('ordem','Ordem:',3,false,0);
		$frm->addSelectField('separador','Item Separador ?',true,'N=Não,S=Sim');
		$frm->addTextField('hint','Texto Ajuda:',500,false,80);
		$frm->addTextField('imagem','Imagem:',100,false,80);
		$frm->addSelectField('cancelado','Cancelado ?',true,'N=Não,S=Sim');
		$frm->addButtonAjax('Salvar',null,'fwValidateFields','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar',null,true,false);
		$frm->addButton('Novo',null,'btnNovo','novo()',null,false,false);
	$frm->closeGroup(); // fecha o grupo

$pc->addPage('Estrutura do Menu',false,true,'abaEstrutura');
	$frm->addHtmlField('html_msg1','<h3><center>Efetue duplo clique sobre o item para alterá-lo.</center></h3>');
	$treeMenu = $frm->addTreeField('treeMenu','Raiz','vw_menu','ID_MENU_PAI','ID_MENU','ROTULO');
   	$treeMenu->setHeight(300);	
	$treeMenu->setOnDblClick('treeMenuDblClick()');

$frm->closeGroup(); // fecha a aba

$frm->processAction();
$frm->show();
?>
<script>
function treeDblClick(id)
{
	jQuery("#id_pai").val(id);
	jQuery("#id_menu_pai").val( id );
	jQuery("#rotulo_pai").val( treeJs.getItemText(id) );
	fwGroupOpen('gpCadastro');
}
function id_moduloChange(e)
{
	if( e.value )
	{
		jQuery("#rotulo").val( jQuery('#'+e.id+' option:selected').text() );
	}
}
function depoisSalvar(erro)
{
	if( erro )
	{
		fwAlert( erro );
	}
	else
	{
		novo();
		atualizarTreeMenu();
	}
}
function novo()
{
	fwClearChildFields(null,'id_menu_pai,menu_pai')
	fwSetFocus('rotulo');
}
function treeMenuDblClick(id)
{
	fwAjaxRequest({
		"action":"alterar",
		"data":{"id_menu":id},
		"callback":function(resultado)
		{
			if( resultado.message)
			{
				fwAlert(resultado.message);
				return;
			}
			fwUpdateFieldsJson(resultado);
			fwSelecionarAba('abaCadastro');
			fwSetFocus('rotulo');	
		}
	});
}
function atualizarTreeMenu()
{
	fwAjaxRequest({
		"action":"lerTreeMenu",
		"dataType":"text",
		"callback":function(xml)
		{
			treeMenuJs.deleteChildItems(0);
			treeMenuJs.loadXMLString(xml);
		}
	})
}
</script>