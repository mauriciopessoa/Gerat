<?php
// utilizar o "*" como identificador dos campo obrigatório
DEFINE( 'REQUIRED_FIELD_MARK','*');

$frm = new TForm('Acesso ao Sistema',140,310);

// não mostar a barra de rolagem vertical na tela, mesmo que o conteúdo ultrapasse a altura do formuulário.
$frm->setOverflowY(false);

// remover o botão fechar do formulário
$frm->hideCloseButton();

// alterar a primeira coluna virtual do formdin para 60px para diminuir o espaço padrão entre o rótulo e o campo.
$frm->setColumns(array(60));

// adicioar os campos
$frm->addTextField('nome_login'		,'Login:',30,true);
$frm->addPasswordField('senha_login','Senha:',true,true,1000,null,null,null,30);

// mensagem para testar
//$frm->addHtmlField('msg','<center>Nome=<b>teste</b> e Senha=<b>123456</b></center>');

// adicionar os botões de ação
$frm->addButton('Entrar','entrar','btnValidar');
$frm->addButton('Sair','sair','btnSair');

// processar as ações
$frm->processAction();

// exibir o formulário
$frm->show();
?>
