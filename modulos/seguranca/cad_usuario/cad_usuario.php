<?php
define('REQUIRED_FIELD_MARK','*'); // alterar a identificação dos campos obrigatórios para * vermelho

$frm = new TForm('Cadastro de Usuário');
$frm->addHiddenField('id');
$frm->setColumns(60); // define a primeira coluna do formulário para 60 px
$pc = $frm->addPageControl('pc',null,null,null,'abaClick()');
$page = $pc->addPage('Cadastro',true,true,'abaCadastro');
	$page->setColorHighlightBackground('#FDFCD7'); // cor de fundo do campo que possuir dica ( hint )
	$frm->addTextField('nome','Nome:',100,true,50,null,null,'Informe o nome completo do usuário')->setCss('text-transform', 'uppercase');
	$frm->addTextField('login','Login:',50,true,50,null,null,'Informe o nome que será utilizado para acessar o sistema')->setCss('text-transform', 'uppercase');
   //	$frm->addSelectField('id_perfil','Perfil:',false,PerfilDAO::SelectAll('PERFIL'));	
	$frm->addPasswordField('senha1','Senha:',false,true,200,null,20);
	$frm->addPasswordField('senha2','Redigite a Senha:',false,false,200,null,20);
$page = $pc->addPage('Pesquisar Usuário',false,true,'abaUsuarios');
	$page->setColumns(80); // define a primeira coluna do formulário da aba para 80 px
	// o atributo noclear evita que a função fwClearFields limpe o campo
   	$frm->addTextField('psq_nome','Localizar Nome:',40,false)->setAttribute('noclear','true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botão Pesquisar!');
   	$frm->addButton('Pesquisar',null,'btnPesquisar','atualizarGride()',null,false,false);
	$frm->addHtmlField('html_gride');
$frm->closeGroup(); // fim das abas

$frm->processAction();
$frm->addButtonAjax('Salvar',null,'antesSalvar','depoisSalvar','salvar','Salvando...','text',false,null,'btnSalvar');
$frm->addButton('Novo',null,'btnNovo','novo()');
$frm->show();
?>
<script>
function antesSalvar()
{
	if( !fwValidateFields() )
	{
		return false;
	}
        
        
      
        
        
        
        
        
	if( jQuery('#senha1').val() != jQuery('#senha2').val())
	{
		fwAlert('Senhas não conferem!');
		return false;
	}
	if( jQuery("#id").val() == '' &&  jQuery('#senha1').val() == '' )
	{
		fwAlert('Para novo usuário é necessário informar a senha!');
		return false;
	}
	return true;

} 

function depoisSalvar(res)
{
	if( res )
	{
		fwAlert(res );
	}
	else 
	{
		fwAlert('Dados gravados com SUCESSO!');
		novo();
	}
}

function novo()
{
	fwClearChildFields();
	fwSelecionarAba('abaCadastro');
	fwSetFocus('nome');}

function abaClick(pc,aba,id)
{
	if( id == 'abausuarios')
	{
		if( jQuery("#psq_nome").val() != '' )
		{
			atualizarGride();
		}
	}
}
function atualizarGride()
{
	fwGetGrid('seguranca/cad_usuario.php','html_gride',{"action":"criar_gride","psq_nome":""});
}
function grideAlterar(campoChave,valorChave)
{
	fwAjaxRequest({
		"action":"alterar",
		"dataType":"json",
		"data":{"id":valorChave},
		"callback":function(dados)
		{
			if( dados.message )
			{
				fwAlert(dados.message);
				return;
			}
			fwUpdateFieldsJson(dados);
			fwSelecionarAba('abaCadastro');
		}
	});
}
function grideCancelar(campoChave,valorChave)
{
	if( fwConfirm('Deseja cancelar o usuário ?',
		function(r){
			if( r == true )
			{
				fwAjaxRequest({
					"action":"cancelar",
					"dataType":"text",
					"data":{"id_usuario":valorChave},
					"callback":function(res)
					{
						if( res )
						{
							fwAlert(res);
						}
						atualizarGride();
					}
				});
			}
		})
	);
}
</script>