<?php
// verificar se os campos obrigatórios estão prenchidos
if( ! $frm->validate() )
{
	return;
}
/**
* Aqui entram as regras de validação dos dados recebidos da tela de login.
*/
$dados_login = Tb_usuarioDAO::validar($frm->get('nome_login'), $frm->get('senha_login') );
if( $dados_login )
{
    /*
    Aqui devemos registrar na sessão o que desejarmos, como por exemplo, os dados do usuário logado.
    Se quiser fazer o controle de sessão por aplicação, já que podemos abrir uma aplicação em cada aba,
	utilize o array $_SESSION[APLICATIVO].
	A constante APLICATIVO, dever ser definida no index.php ou então a classe TApplication irá defini-la como FORMDIN
    Ex: $_SESSION[APLICATIVO]['login']['nome'] = 'Usuário x';
    Ex: $_SESSION[APLICATIVO]['login']['uf'] = 'DF';
    Fica a critério de cada um como fazer o controle de sessão.
    */

	$_SESSION[APLICATIVO]['logado']=true; // este será o flag para não chamar a tela de login novamente

	// colocar o nome do usuário na sessão
	$_SESSION[APLICATIVO]['usuario']['nome']=$dados_login['NOME'][0];
        
        $_SESSION[APLICATIVO]['usuario']['id']=$dados_login['ID'][0];
        


	// esconder o formulário
	$frm->setVisible(false);

	// reiniciar a aplicação
	$frm->restart();
        
}
else
{
	$frm->addError('Login inválido');
}
?>
