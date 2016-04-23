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
	die('<h3>Diretï¿½rio de instalaï¿½ï¿½o do FormDin "base/" nï¿½o encontrado!</h3>');
}


define('APLICATIVO','Gerat'); //
define('DECIMAL_SEPARATOR',',');


$app = new TApplication('Gerat','Gestão de Atendimentos','imagens/simbolo_radiologia.png', date('d/m/y'));

//$app->setTitle('Plutos 2');


// defini??o do menu principal
$app->setMainMenuFile('includes/menu.php');







// cololcar a logo do formdin como marca d`agua
$app->setWaterMark('imagens/simbolo_radiologia2.jpg');

// Definir o mï¿½dulo de login e a funï¿½ï¿½o de verificaï¿½ï¿½o se o login jï¿½ foi feito.
// Esta funï¿½ï¿½o PHP serï¿½ responsï¿½vel por retornar true ou false para a aplicaï¿½ï¿½o,
// para que ela nï¿½o chame novamente a tela de login.
//$app->setLoginFile('modulos/login/login.php','verificar_login');

/*
definir a funï¿½ï¿½o para customizar os dados referentes ao usuï¿½rio logado, que serï¿½o
exibidos no canto superior direito da tela
*/
//$app->setOnGetLoginInfo('login_info');

//$app->setDefaultModule('../base/includes/gerador_vo_dao.php');
//TPDOConnection::Test();

$app->run();

/**
* Funï¿½ï¿½o para verificar se o login jï¿½ foi feito.
* Se retornar false, a TApplication vai exibir a tela de login
*
*/
function verificar_login()
{
	if( $_SESSION[APLICATIVO]['logado'] ) // nï¿½o chamar a tela de login novamente
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
