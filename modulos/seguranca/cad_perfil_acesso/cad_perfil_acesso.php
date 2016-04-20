<?php
$frm = new TForm( 'Definição de Acesso do Perfil', 450 );

$frm->setColumns( 60 ); // definir a primeira coluna vertical do formulario para 60px

$frm->processAction();  // chamadas ajax encerram aqui

// ler todos os perfís ordenados pela coluna PERFIL
$perfis = PerfilDAO::selectAll( 'PERFIL' );

// criar o campo select com os perfis
$frm->addSelectField( 'id_perfil', 'Perfil:', null, $perfis, null, null, null, null, null, null, '-- selecione --', '' )->addEvent( 'onChange', 'submit()' );

// se for postado o perfil, montar a treeview
if ( $frm->get( 'id_perfil' ) )
{
    $dados = MenuDAO::selectAll( 'ORDEM' );
    $direitosAtuais = MenuDAO::getMenuPerfil( $frm->get( 'id_perfil' ) );
    $tree = $frm->addTreeField( 'tree' );
    $tree->setHeight( 310 );
    $tree->setStartExpanded( true );
    $tree->enableCheck( true ); // habilitar os checkboxes da treeview
    $tree->setTheme( 'winstyle' ); // define as imagens da treeview ( tema )

    // adicionar itens na treeview
    if ( $dados )
    {
        foreach( $dados[ 'ID_MENU' ] as $k => $v )
        {
            // marcar os items que o perfi já tem acesso
            $checked = 0;

            if ( is_array( $direitosAtuais ) )
            {
                $checked = in_array( $v, $direitosAtuais[ 'ID_MENU' ] );
            }
            $tree->addItem( $dados[ 'ID_MENU_PAI' ][ $k ], $dados[ 'ID_MENU' ][ $k ], $dados[ 'ROTULO' ][ $k ], true, $dados[ 'DES_HINT' ][ $k ], null, null, $checked );
        }
    }
    else
    {
		$frm->setMessage('Nenhum item de menu cadastrado');
    }
}
// adicionar o botão Salvar
$frm->addButton( 'Salvar', null, 'btnSalvar', 'salvarClick()', 'Confirma Gravação?' );

// exibir o formulário
$frm->show();
?>

<script>
    function salvarClick()
        {
        fwAjaxRequest(
            {
            "action": "salvar",
            "dataType": "text",
            "data":
                {
                "id_perfil": "", // se não for informado o valor, será lido o que estiver no campo id_perfil do formulário
                "ids": treeJs.getAllChecked() // ler todos os ids selecionados na treeview
                },
            "callback": function(erro)
                {
                if (erro)
                    {
                	    alert(erro);
                    }

                else
                    {
                    	fwAlert('Dados Gravados com Sucesso!!!');
                    }
                }
            });
        }
</script>