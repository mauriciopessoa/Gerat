<?php
if( file_exists('./base'))
{
	require_once('./base/classes/webform/TApplication.class.php');
}
else if( file_exists('../base'))
{
	require_once('../base/classes/webform/TApplication.class.php');
}
else
{
	die('<h3>Diret�rio de instala��o do FormDin "base/" n�o encontrado!</h3>');
}


define('APLICATIVO','Gerat'); //
define('DECIMAL_SEPARATOR',',');


$app = new TApplication('Gerat','Gest�o de Atendimentos','imagens/simbolo_radiologia.png', date('d/m/y'));

//$app->setTitle('Plutos 2');


// defini??o do menu principal
$app->setMainMenuFile('includes/menu.php');







// cololcar a logo do formdin como marca d`agua
$app->setWaterMark('imagens/simbolo_radiologia2.jpg');

// Definir o m�dulo de login e a fun��o de verifica��o se o login j� foi feito.
// Esta fun��o PHP ser� respons�vel por retornar true ou false para a aplica��o,
// para que ela n�o chame novamente a tela de login.
//$app->setLoginFile('modulos/login/login.php','verificar_login');

/*
definir a fun��o para customizar os dados referentes ao usu�rio logado, que ser�o
exibidos no canto superior direito da tela
*/
//$app->setOnGetLoginInfo('login_info');

//$app->setDefaultModule('../base/includes/gerador_vo_dao.php');
//TPDOConnection::Test();

$app->run();

/**
* Fun��o para verificar se o login j� foi feito.
* Se retornar false, a TApplication vai exibir a tela de login
*
*/
function verificar_login()
{
	if( $_SESSION[APLICATIVO]['logado'] ) // n�o chamar a tela de login novamente
	{
		return true;
	}
	return false;
}
function login_info()
{
	if( $_SESSION[APLICATIVO]['usuario']['nome'] )
	{
		return '<b>'.$_SESSION[APLICATIVO]['usuario']['nome'].'</b>';
	}
	return 'Bem-Vindo';
       
}
?>
