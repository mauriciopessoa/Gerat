<?php
$frm = new TForm('Cadastro de Perfil',null,500);

// campo chave da tabela
$frm->addHiddenField('id_perfil');

// campos de entrada de dados
$frm->addTextField('perfil','Perfil:',50,true,50);
$frm->addSelectField('cancelado','Cancelado ?',true,"N=N�o,S=Sim",true);

//bot�o salvar ajax
$frm->addButtonAjax('Salvar', null, 'fwValidateFields()', 'depoisSalvar', 'salvar', 'Salvando', 'text', false, null, 'btnGravar', null, true,false);
$frm->addButton('Novo',null,'btnNovo','novo()',null,false,false);

// campo html para exibir o gride com os perfis j� cadastrados
$frm->addHtmlField('html_gride', '');

// processar as a��es do formul�rio que est�o na pasta action/
$frm->processAction();

// Executar a fun��o javascript de inicializa��o do formul�rio
$frm->addJavascript('inicializar()');

// exibir o formul�rio
$frm->show();
?>

<script>
function inicializar()
{
	atualizar_gride();
	novo();
}
function depoisSalvar(resultado)
{
	if( resultado )
	{
		alert( resultado );
	}
	inicializar();
}
function alterar(campos,valores)
{
	fwUpdateFields(campos,valores);
	jQuery("#formdin_body").css('background-color','#ffffff');
}
function atualizar_gride()
{
	fwGetGrid('seguranca/cad_perfil/action/criar_gride.php','html_gride',null,true);
}
function novo()
{
	fwClearChildFields();
	jQuery("#formdin_body").css('background-color','#efefef');
}
</script>
