<?php
// verificar se os campos obrigat�rios est�o prenchidos
if( ! $frm->validate() )
{
	return;
}
/**
* Aqui entram as regras de valida��o dos dados recebidos da tela de login.
*/
$dados_login = Tb_usuarioDAO::validar($frm->get('nome_login'), $frm->get('senha_login') );
if( $dados_login )
{
    /*
    Aqui devemos registrar na sess�o o que desejarmos, como por exemplo, os dados do usu�rio logado.
    Se quiser fazer o controle de sess�o por aplica��o, j� que podemos abrir uma aplica��o em cada aba,
	utilize o array $_SESSION[APLICATIVO].
	A constante APLICATIVO, dever ser definida no index.php ou ent�o a classe TApplication ir� defini-la como FORMDIN
    Ex: $_SESSION[APLICATIVO]['login']['nome'] = 'Usu�rio x';
    Ex: $_SESSION[APLICATIVO]['login']['uf'] = 'DF';
    Fica a crit�rio de cada um como fazer o controle de sess�o.
    */

	$_SESSION[APLICATIVO]['logado']=true; // este ser� o flag para n�o chamar a tela de login novamente

	// colocar o nome do usu�rio na sess�o
	$_SESSION[APLICATIVO]['usuario']['nome']=$dados_login['NOME'][0];
        
        $_SESSION[APLICATIVO]['usuario']['id']=$dados_login['ID'][0];
        


	// esconder o formul�rio
	$frm->setVisible(false);

	// reiniciar a aplica��o
	$frm->restart();
        
}
else
{
	$frm->addError('Login inv�lido');
}
?>
