<?php
/*
 Limpar a sessão da aplicação.
 A constante APLICATIVO deve ser definda no index.php caso seja necessário que o login seja
 feito para cada aplicação. ex: define('APLICATIVO','SISTESTE');
 Se não for definida a classe TApplication criarÁ como "FORMDIN" e o login/logout de uma aplicação,
 valerá para todas as outras aplicações até o encerramento da sessão.
*/
$_SESSION[APLICATIVO]=null;

// redirecionar para a url do google
$frm->addJavascript('top.location="http://www.google.com"');

// remover todos os campos do formulário
$frm->removeField();

// adicionar um campo html para exibir a mensagem de encerramento
$frm->addHtmlField('mensagem','<br><center><h3>Encerrando. Aguarde...</h3></center>');

// quando o formulário está desabilitado, todos os campos são desabilitados e os botões não aparecem;
$frm->setEnabled(false);
?>
