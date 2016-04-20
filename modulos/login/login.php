<?php
// utilizar o "*" como identificador dos campo obrigat�rio
DEFINE( 'REQUIRED_FIELD_MARK','*');

$frm = new TForm('Acesso ao Sistema',140,310);

// n�o mostar a barra de rolagem vertical na tela, mesmo que o conte�do ultrapasse a altura do formuul�rio.
$frm->setOverflowY(false);

// remover o bot�o fechar do formul�rio
$frm->hideCloseButton();

// alterar a primeira coluna virtual do formdin para 60px para diminuir o espa�o padr�o entre o r�tulo e o campo.
$frm->setColumns(array(60));

// adicioar os campos
$frm->addTextField('nome_login'		,'Login:',30,true);
$frm->addPasswordField('senha_login','Senha:',true,true,1000,null,null,null,30);

// mensagem para testar
//$frm->addHtmlField('msg','<center>Nome=<b>teste</b> e Senha=<b>123456</b></center>');

// adicionar os bot�es de a��o
$frm->addButton('Entrar','entrar','btnValidar');
$frm->addButton('Sair','sair','btnSair');

// processar as a��es
$frm->processAction();

// exibir o formul�rio
$frm->show();
?>
