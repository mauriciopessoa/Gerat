<?php
// criar a instância do formulário
$frm = new TForm('Cadastro de Módulo do Sistema');

 // campo chave da tabela módulos
$frm->addHiddenField('id_modulo');

// adicionar controle de abas
$pc = $frm->addPageControl('pc',null,null,null,'abaClick()');

// adicionar primeira aba
$pc->addPage('Cadastro',true,true,'abaCadastro');
	$frm->addTextField('nome_menu','Nome para Menu:',100,true,80)->setTooltip('Nome Para Menu - Informe o nome que aparecerá no menu da aplicação.');
	$frm->addTextField('nome_modulo','Nome do Módulo:',200,true,80)->setTooltip('Nome do Módulo - Informe o nome/caminho físico do arquivo. Ex: cad_usuario,cad_cliente');
	$frm->addSelectField('cancelado','Cancelado ?',true,"N=Não,S=Sim");
	$frm->addButtonAjax('Salvar',null,'fwValidateFields()','btnNovoClick','salvar',null,null,null,null,null,null,true,false);
	$frm->addButton('Novo',null,'btnNovo','btnNovoClick()',null,false,false);

// adicionar segunda aba
$pc->addPage('Módulos',false,true,'abaModulos');
	$frm->addHtmlField('html_gride','');

// fim das abas
$frm->closeGroup();

// processar ação do formulário
$frm->processAction();

// exibir o form no browser
$frm->Show();
?>
<script>
function abaClick(pc,aba,id)
{
	if( id=='abamodulos')
	{
		atualizar_gride();
	}
}
function btnNovoClick()
{
	fwClearChildFields();
	fwSetFocus('nome_menu');
}
function atualizar_gride()
{
	fwGetGrid('seguranca/cad_modulo.php','html_gride',{"action":"criar_gride"},false);
}
function alterar(campos,valores)
{
	fwUpdateFields(campos,valores);
	fwSelecionarAba('abaCadastro');
	fwSetFocus('nome_menu');

}
</script>
