<?php
/*
 Limpar a sess�o da aplica��o.
 A constante APLICATIVO deve ser definda no index.php caso seja necess�rio que o login seja
 feito para cada aplica��o. ex: define('APLICATIVO','SISTESTE');
 Se n�o for definida a classe TApplication criar� como "FORMDIN" e o login/logout de uma aplica��o,
 valer� para todas as outras aplica��es at� o encerramento da sess�o.
*/
$_SESSION[APLICATIVO]=null;

// redirecionar para a url do google
$frm->addJavascript('top.location="http://www.google.com"');

// remover todos os campos do formul�rio
$frm->removeField();

// adicionar um campo html para exibir a mensagem de encerramento
$frm->addHtmlField('mensagem','<br><center><h3>Encerrando. Aguarde...</h3></center>');

// quando o formul�rio est� desabilitado, todos os campos s�o desabilitados e os bot�es n�o aparecem;
$frm->setEnabled(false);
?>
