<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Minist�rio do Planejamento
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo � parte do Framework Formdin.
 *
 * O Framework Formdin � um software livre; voc� pode redistribu�-lo e/ou
 * modific�-lo dentro dos termos da GNU LGPL vers�o 3 como publicada pela Funda��o
 * do Software Livre (FSF).
 *
 * Este programa � distribu�do na esperan�a que possa ser �til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer MERCADO ou
 * APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/LGPL em portugu�s
 * para maiores detalhes.
 *
 * Voc� deve ter recebido uma c�pia da GNU LGPL vers�o 3, sob o t�tulo
 * "LICENCA.txt", junto com esse programa. Se n�o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda��o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/*
Exemplo dos parametros recebidos na variavel de sess�o: $_SESSION[APLICATIVO]['onlineSearch'][$sessionField];
Array
(
	[fieldName] => des_nome
	[packageFunction] => SIGER.PKG_PUBLICO.SEL_DADOS_PESSOA
	[autoFillFilterField] => NOM_PESSOA
	[autoStart] =>
	[autoSelect] => 1
	[updateFormFields] => NOM_PESSOA|des_nome,END_PESSOA|des_endereco,DES_BAIRRO
	[gridColumns] => NOM_PESSOA|Nome,NUM_CPF|Cpf
	[focusFieldName] => des_endereco
	[filterFields] => NUM_CPF|CPF||||cpf,NOM_PESSOA|Nome
	[windowHeight] => 400
	[windowWidth] => 600
	[windowHeader] => Consulta Pessoa Jur�dica
	[gridHeader] => Registros Encontrados
	[searchButtonLabel] =>
	[formFilterFields] =>
	[functionExecute] =>
	[maxRecords] => 100
	[clickCondition] =>
	[columnLink] => NUM_CPF
	[multiSelectKeyField] =>
	[arrSqls] =>
	[crudModule]=>
	[prototypeParentWin]=>
)
*/
$GLOBALS[ 'strJsClick' ] = ''; // variavel global para guardar o javascript do autoselect quando existir somente 1 op��o no gride

$sessionField = $_GET[ 'sessionField' ];
$aParams = $_SESSION[ APLICATIVO ][ 'onlineSearch' ][ $sessionField ];

//print_R($_REQUEST);
//print_R($aParams);
//die();
//-----------------------------------------------------------
// Fazer o cadastro on-line se tiver passado o nome do m�dulo
//-----------------------------------------------------------
if ( isset( $_POST[ 'formDinAcao' ] ) && $_POST[ 'formDinAcao' ] == 'cadastrar_online' || ( isset( $_POST[ 'onLineSearch' ] ) && $_POST[ 'onLineSearch' ] ) )
{
	if ( $_POST[ 'formDinAcao' ] != 'Sair' )
	{
		if ( isset( $aParams[ 'crudModule' ] ) && $aParams[ 'crudModule' ] )
		{
			$moduleName = $aParams[ 'crudModule' ];
			$_POST[ 'fw_back_to' ] = $_POST[ 'modulo' ];
			$_POST[ 'modulo' ] = $moduleName;

			if ( !file_exists( $moduloName ) )
			{
				$moduleName = $currentPath . $moduleName;
			}
			$e = new TElement();
			$base = $e->getBase();
			if ( file_exists( $moduleName ) )
			{
				if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() )
				{
					include($base . 'includes/conexao.inc' );
				}
				// criar automaticamento os campos ocultos no formulario que ser� chamado
				$_REQUEST[ 'onLineSearch' ] = true;
				$_REQUEST[ 'subform' ] = true;
				$_REQUEST[ 'modulo' ] = $moduleName;
				// abrir o formul�rio
				include( $moduleName );
				exit;
			}
			else
			{
				print "M�dulo: " . $aParams[ 'crudModule' ] . ' n�o encontrado e nem ' . $moduleName;
			}
		}
	}
	unset( $_REQUEST[ 'onLineSearch' ] );
}
//--------------------------------------------------------------------------
$form = new TForm( $aParams[ 'windowHeader' ], $aParams[ 'windowHeight' ] - 32, $aParams[ 'windowWidth' ] - 32, 'formsearch' );
$form->addJsFile('onlineSearch.js');
$form->headerCloseButton->setCss( 'display', 'none' );
$form->setCss( 'border', '0px' );
$form->setFlat( true );

if ( $_REQUEST[ 'modalWinId' ] )
{
	$form->setCss( 'background-color', '#efefef' );
	$form->setCss( 'border', '1px solid silver' );
}
$aParams[ 'dialogParentId' ] = isset($aParams[ 'dialogParentId' ] ) ? $aParams[ 'dialogParentId' ] : '';
$form->addHiddenField( 'sessionField', $sessionField );
$form->addHiddenField( 'prototypeParentWin', $aParams[ 'prototypeParentWin' ] );
//$form->addHiddenField( 'dialogId', $_REQUESTs[ 'dialogId' ] );

$form->setShowMessageForm( false );
$acao = isset( $acao ) ? $acao : null;

// preencher o campo de filtro com o valor que estiver preenchido no formul�rio
if ( !$acao )
{
	$form->addJavascript( 'osStart("' . $aParams[ 'autoFillFilterField' ] . '","' . $aParams[ 'fieldName' ] . '","' . $aParams[ 'autoStart' ] . '","' . $aParams[ 'filterFields' ] . '")' );
}
// adicionar os campos de pesquisa ao form
addFields( $form, $aParams[ 'filterFields' ], $aParams[ 'formFilterFields' ], $aParams[ 'arrSqls' ] );

// campo para exibir o gride e as mensagens de aguarde processamento
$html = $form->addHtmlField( 'html_gride' );
$html->setCss( 'border', '0px' );
$html->setCss( 'padding-top', '10px' );
$html->setCss( 'text-align', 'center' );

// bot�es do formul�rio
$aParams[ 'searchButtonLabel' ] = is_null( $aParams[ 'searchButtonLabel' ] ) ? "Pesquisar" : $aParams[ 'searchButtonLabel' ];

$form->addButton( $aParams[ 'searchButtonLabel' ], null, 'btnPesquisar', 'osPesquisar()' );
$form->addButton( 'Fechar', null, 'btnFechar', 'fechar();' );

$acao = isset( $_POST[ 'formDinAcao' ] ) ? $_POST[ 'formDinAcao' ] : '';

// tratamento da a��o
switch( $acao )
{
	case "pesquisar":
		if ( $form->validate() )
		{
			$bvars = null;
			$res = null;

			if ( function_exists( 'recuperarPacote' ) )
			{
				if ( is_array( $form->getDisplayControls() ) )
				{
					foreach( $form->getDisplayControls() as $name => $dc )
					{
						if ( $dc->getField()->getProperty( 'filter' ) == 'true' )
						{
							$bvars[ $name ] = $dc->getField()->getValue();
						}
					}
				}
				//print_r($bvars);
				$res=null;
				//break;
				if ( $erro = $GLOBALS[ 'conexao' ]->executar_recuperar_pkg_funcao( $aParams[ 'packageFunction' ], $bvars, $res ) )
				//if( $erro = recuperarPacote($aParams['packageFunction'],$bvars,$res,60))
				{
					$form->setMessage( $erro );
					break;
				}

			}
			else if( class_exists( 'TPDOConnection' ) && TPDOConnection::getInstance() )
			{
				$where = '';

				if ( is_array( $form->getDisplayControls() ) )
				{
					foreach( $form->getDisplayControls() as $name => $dc )
					{
						if ( $dc->getField()->getProperty( 'filter' ) == 'true' )
						{
							if ( trim( $dc->getField()->getValue() ) != '' )
							{
								$where .= $where == '' ? '' : ' and ';
								if( $dc->getField()->getProperty( 'searchFormated' ) == 'true' && method_exists( $dc->getField(),'getFormated') )
								{
									$value=$dc->getField()->getFormated();
								}
								else
								{
									$value = $dc->getField()->getValue();
								}
								if( isset($aParams[ 'caseSensitive' ]) &&  ! $aParams[ 'caseSensitive' ] )
								{
									if ( preg_match('/like|true/i',$dc->getField()->getProperty( 'partialKey' )) == 1 ) 
                                    {
										$where .= "(upper(" . $name . ") like upper('%" . $value . "%'))";
									} else {
										$where .= "(upper(" . $name . ")=upper('" . $value . "'))";
									}
								}
								else
								{
									if ( $dc->getField()->getProperty( 'partialKey' ) == 'true' ) {
										$where .= "(" . $name . " like '%" . $value . "%')";
									} 
                                    else 
                                    {
								        $where .= "(" . $name . "='" . $value . "')";
							        }
						        }
					        }
				        }
                    }
				}
				$sql = "select * from " . $aParams[ 'packageFunction' ] . ( ( $where == '' ) ? '' : ' where ' . $where );
                if( (integer) $aParams[ 'maxRecords' ] > 0 && DEFINED('BANCO') && preg_match('/MYSQL|SQLITE|POSTGRE/i',BANCO) == 1 )
                {
                    $sql  .= ' LIMIT ' . $aParams[ 'maxRecords' ];
                }
				$res = TPDOConnection::executeSql( $sql );
				TPDOConnection::showError();
			}
			if ( $res )
			{
                if( preg_match('/LIMIT/i',$sql ) == 0 )
                {
				    // limitar na quantidade de registros informada
				    if ( ( int ) $aParams[ 'maxRecords' ] > 0 )
				    {
					    foreach( $res as $k => $a )
					    {
						    $res[ $k ] = array_slice( $a, 0, ( int ) $aParams[ 'maxRecords' ] );
					    }
				    }
                }
				//$html->setValue(gride($res,$aParams,$form,null,null,$form->getWidth()-7,250));
                
				setGrid( $res, $aParams, $form );
			}
			else
			{
				//$form->setMessage('Nenhum registro encontrado');
				$form->addHtmlField( 'html_msg', '<center><b><br>Nenhum registro encontrado!<b></center>' )->setCss( 'font-size', '18px' );

				if ( isset( $aParams[ 'crudModule' ] ) && $aParams[ 'crudModule' ] )
				{
					$form->addButton( 'Cadastrar', 'cadastrar_online', 'btnCadastrar', null, null, true, false );
				}
			}
		}
		break;

	//----------------------------------------------------------
	case "finalizar": // quando for multiselect
		$values = '';

		if ( isset( $_POST[ $aParams[ 'multiSelectKeyField' ] ] ) )
		{
			if ( is_array( $_POST[ $aParams[ 'multiSelectKeyField' ] ] ) )
			{
				$values = implode( ',', $_POST[ $aParams[ 'multiSelectKeyField' ] ] );
			}
		}
		else if( isset( $_POST[ strtoupper( $aParams[ 'multiSelectKeyField' ] )] ) )
		{
			if ( is_array( $_POST[ strtoupper( $aParams[ 'multiSelectKeyField' ] )] ) )
			{
				$values = implode( ',', $_POST[ strtoupper( $aParams[ 'multiSelectKeyField' ] )] );
			}
		}
		else if( isset( $_POST[ strtolower( $aParams[ 'multiSelectKeyField' ] )] ) )
		{
			if ( is_array( $_POST[ strtolower( $aParams[ 'multiSelectKeyField' ] )] ) )
			{
				$values = implode( ',', $_POST[ strtolower( $aParams[ 'multiSelectKeyField' ] )] );
			}
		}
		$form->addJavascript( 'osSelecionar("' . strtolower( $aParams[ 'multiSelectKeyField' ] ) . '","' . $values . '","' . $aParams[ 'functionExecute' ] . '",0,"' . $aParams[ 'focusFieldName' ] . '");' );
		break;
//----------------------------------------------------------------
}
$form->show();
/*
*************************************************************************************************
*********************************                                 *******************************
*********************************  F U N � � E S  D E  A P O I O  *******************************
*********************************                                 *******************************
*************************************************************************************************
*/
// criar os campos no formulario
function addFields( $form, $filterFields, $formFilterFields, $arrSqls )
{
	if ( !is_null( $filterFields ) )
	{
		$aFilterFields = explode( ',', $filterFields );
        
		foreach( $aFilterFields as $k => $v )
		{
			@list( $name, $label, $length, $size, $required, $type, $decimalPlaces, $partialKey, $searchFormated ) = explode( '|', $v );
         
			$required = ( strtolower( $required ) === "true" ) ? true : false;
			$partialKey = preg_match('/true|like/i', trim($partialKey ) ) == 1  ? "true" : "false";
			$newField = null;
			switch( strtolower( $type ) )
			{
				case 'uf';
					$newField = $form->addSelectField( $name, $label, $required );
					$bvars = null;
					//$clientedb = new banco();
					$sql = "SELECT COD_UF,NOM_UF||' / '||SIG_UF AS SIG_UF FROM UF ORDER BY SIG_UF";
					$l = null;
					$GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $b, $aUf, $l, 0 );
					$newField->setFirstOptionText( '-- todos --' );
					$newField->setOptions( $aUf, 'SIG_UF', 'COD_UF' );

					break;

				case 'select';
					$newField = $form->addSelectField( $name, $label, $required );
					$arrSqls = json_decode( $arrSqls, true );

					if ( is_array( $arrSqls ) && array_key_exists( $name, $arrSqls ) !== false )
					{
						if ( is_string( $sql ) )
						{
							$sql = trim( $arrSqls[ $name ] );
							$linhas = null;
							$res = null;
							$cache = 300;
							$bvars = null;
							$campoChave = null;
							$campoDescricao = null;

							//$clientedb 		= new banco();
							// verificar se passou o nome de um pacote ou uma instru��o sql
							if ( substr( strtolower( $sql ), 0, 7 ) !== 'select ' )
							{
								// passou pacote
								$p = explode( ',', $sql );
								$sql = $p[ 0 ];
								$cache = isset( $p[ 1 ] ) ? $p[ 1 ] : $cache;
								$campoChave = isset( $p[ 2 ] ) ? $p[ 2 ] : $campoChave;
								$campoDescricao = isset( $p[ 3 ] ) ? $p[ 3 ] : $campoDescricao;
								print_r( $GLOBALS[ 'conexao' ]->executar_pacote_func_proc( $sql, $bvars, $cache, $linhas ) );
								$res = $bvars[ 'CURSOR' ];
							}
							else
							{
								// passou SQL
								if ( function_exists( 'recuperarPacote' ) )
								{
									$GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $bvars, $res, $linhas, 0, $cache );
								}
								else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
								{
									$res = TPDOConnection::executeSql( $sql );
								}
							}
						}
						else if( is_array( $arrSqls ) )
						{
							$res = $arrSqls;
						}
						$newField->setFirstOptionText( '-- todos --' );
						$newField->setOptions( $res, $campoDescricao, $campoChave );
					}
					break;

				case 'cpf';
					$newField = $form->addCpfField( $name, $label, $required );
					break;

				//-------------------------------------
				case 'cnpj';
					$newField = $form->addCnpjField( $name, $label, $required );
					break;

				//-------------------------------------
				case 'cpfcnpj';
					$newField = $form->addCpfCnpjField( $name, $label, $required );
					break;

				//-------------------------------------
				case 'data';
					$newField = $form->addDateField( $name, $label, null, $required );
					break;

				//-------------------------------------
				case 'int';
					$length = is_null( $length ) ? 10 : $length;
					$newField = $form->addNumberField( $name, $label, $length, $required, 0 );
					break;

				case 'dec';
					$length = is_null( $length ) ? 10 : $length;
					$newField = $form->addNumberField( $name, $label, $length, $required, $decimalPlaces );
					break;

				case 'hidden';
					$length = is_null( $length ) ? 100 : $length;
					$newField = $form->addHiddenField( $name, null, $required );
					break;

					//-------------------------------------
					default:
				$length = is_null($length) ? 30 : $length;
					$size = is_null( $size ) ? $length : $size;
					$newField = $form->addTextField( $name, $label, $length, $required, $size );
			}

			// colocar a propriedade filter no campo para poder montar o array bvars na a��o pesquisar
			if ( !is_null( $newField ) )
			{
				$newField->setProperty( 'filter', 'true' );
				$newField->setProperty('partialKey',$partialKey);
				$newField->setProperty('searchFormated',$searchFormated);
			}
		}
	}

	if ( !is_null( $formFilterFields ) )
	{
		$aFilterFields = explode( ',', $formFilterFields );
		$topFields = null;
		$aFormFields = null;

		foreach( $aFilterFields as $k => $v )
		{
			if ( strpos( $v, '=' ) !== false )
			{
				// NUM_PESSOA=20
				@list( $nameBvars, $value ) = explode( '=', $v );
				$field = $form->addHiddenField( strtoupper( $nameBvars ), $value );
				$field->setProperty( 'filter', 'true' );
			}
			else
			{
				// num_cpf|NUM_PESSOA
				@list( $nameForm, $nameBvars ) = explode( '|', $v );
				$nameBvars = is_null( $nameBvars ) ? strtoupper( $nameForm ) : $nameBvars;
				$field = $form->addHiddenField( $nameBvars );
				$field->setProperty( 'filter', 'true' );
				$topFields .= is_null( $topFields ) ? "" : ",";
				$topFields .= $nameForm . '|' . $nameBvars;
			}
		}

		if ( $topFields )
		{
			// alimentar os campo da consulta on-line com os valores do formul�rio do usu�rio
			$form->addJavaScript( 'osGetTopValues("' . $topFields . '")' );
		}
	}
}

//-----------------------------------------------------------------------------------------------
function setGrid( $res, $aParams, $form )
{

	$g = new TGrid( 'gdsearch', $aParams[ 'gridHeader' ], $res );
	$g->setOnDrawCell( 'gdOnDrawCell' );
	$g->enableDefaultButtons( false );

	// colunas
	// criar o link de sele��o na coluna iformada ou na primeira coluna do $res se n�o tiver sido informado
	$columnLink = key( $res ); // primeira coluna ser� a link
	$firstColumn = null;

	if ( !$aParams[ 'gridColumns' ] )
	{
		$aParams[ 'gridColumns' ] = implode( ',', array_keys( $res ) );
	}

	if ( $aParams[ 'gridColumns' ] )
	{
		$aColumns = explode( ',', $aParams[ 'gridColumns' ] );

		forEach( $aColumns as $k => $v )
		{
			@list( $field, $label, $width, $align ) = explode( "|", $v );
			$align = isset( $align ) ? $align : 'l';

			if ( strtolower( $align ) == 'l' || strtolower( $align ) == 'left' )
			{
				$align = 'left';
			}
			else if( strtolower( $align ) == 'r' || strtolower( $align ) == 'right' )
			{
				$align = 'right';
			}
			else if( strtolower( $align ) == 'c' || strtolower( $align ) == 'center' )
			{
				$align = 'center';
			}
			else
			{
				$align = 'left';
			}
			// se a coluna de link n�o existir ou for informada uma inv�lida, assumir a primeira coluna do gride
			$aParams[ 'columnLink' ] = is_null( $aParams[ 'columnLink' ] ) ? $field : $aParams[ 'columnLink' ];

			if ( $aParams[ 'columnLink' ] == $field )
			{
				if ( $aParams[ 'multiSelectKeyField' ] )
				{
					$oCol = $g->addCheckColumn( strtoupper( $field ), $label, strtoupper( $field ), $field );
					$oCol->setWidth( $width );
				}
				else
				{
					$oCol = $g->addColumn( $field, $label, $width, $align );
				}
				$columnLink = $field;
				$oCol->setProperty( 'link', 'true' );
			}
			else
			{
				$oCol = $g->addColumn( $field, $label, $width, $align );
			}
		}

		// quando for multiselect adicionar ao form um bot�o para finalizar consulta
		if ( $aParams[ 'multiSelectKeyField' ] )
		{
			$btn = $form->addButton( 'Finalizar Sele��o', 'finalizar', 'btnFinalizar' );
			$btn->setProperty( 'title', 'Marque os �tens desejados e clique aqui para finalizar a sele��o' );
			$aParams[ 'autoSelect' ] = false;
		}
		// tem que ser chamada a funcao show(false) para gerar o script de autoselecionar quando tem somente 1 opcao
		$form->getField( 'html_gride' )->add( $g->show( false ) );

		//$form->getField('html_gride')->add($g);
		// se existir apenas uma op��o no gride, fazer a sele��o autom�tica
		if ( count( $res[ key( $res )] ) == 1 && $aParams[ 'autoSelect' ] )
		{
			// para o formulario fechar automaticamente tem que ter um delay de 1 segundo para evitar erro no javascript da pagina
			if ( $GLOBALS[ 'strJsClick' ] )
			{
				if ( !is_array( $form->getMessages() ) )
				{
					$GLOBALS[ 'strJsClick' ] = str_replace( ',0);', ',500);', $GLOBALS[ 'strJsClick' ] );
					$form->addJavascript( $GLOBALS[ 'strJsClick' ] );
				}

				// pode ser que a �nica op��o esteja desabilitada se existir o parametro clickCondition, ent�o n�o desabilitar os campos do form
				if ( !$aParams[ 'clickCondition' ] )
				{
					$form->setEnabled( false );
				}
			}
			return '';
		}
	}
}

function gdOnDrawCell( $rowNum, $cell, $objColumn, $aData, $edit )
{
	if ( $objColumn->getProperty( 'link' ) == 'true' )
	{
		$sessionField = $_GET[ 'sessionField' ];
		$aParams = $_SESSION[ APLICATIVO ][ 'onlineSearch' ][ $sessionField ];
		$aUpdateFormFields = explode( ',', $aParams[ 'updateFormFields' ] );
		$exprOk = true;

		if ( $aParams[ 'clickCondition' ] )
		{
			$aParams[ 'clickCondition' ] = str_replace( array( ' or ', ' and ', ' OR ', ' AND ' ), array( ' || ', ' && ', ' || ', ' && ' ), $aParams[ 'clickCondition' ] );
			//@eval('$ok='.$aParams['clickCondition'].';');
			$expr = $aParams[ 'clickCondition' ];
			$expr = str_replace( '$res[', '$aData[', $expr );
			$expr = str_replace( '[$k]', '', $expr );
			@eval( '$exprOk=' . $expr . ';' );
		}

		if ( $aParams[ 'multiSelectKeyField' ] )
		{
			$edit->setId( $edit->getId() . '_' . $rowNum );

			if ( !$exprOk )
			{
				$edit->setProperty( 'disabled', 'true' );
			}
		}
		else
		{
			if ( is_array( $aUpdateFormFields ) )
			{
				// criar os parametros de retorno ao selecionar a op��o
				foreach( $aUpdateFormFields as $k1 => $v1 )
				{
					$aV = explode( '|', $v1 ); // $v1 = END_PESSOA|des_endereco
					$aV[ 1 ] = isset( $aV[ 1 ] ) ? $aV[ 1 ] : strtolower( $aV[ 0 ] );
					$aUpdateFields[] = $aV[ 1 ];
					$value = null;

					if ( isset( $aData[ $aV[ 0 ] ] ) )
					{
						$value = $aData[ $aV[ 0 ] ];
					}
					else if( isset( $aData[ strtolower( $aV[ 0 ] )] ) )
					{
						$value = $aData[ strtolower( $aV[ 0 ] )];
					}
					else if( isset( $aData[ strtoupper( $aV[ 0 ] )] ) )
					{
						$value = $aData[ strtoupper( $aV[ 0 ] )];
					}
					$value = $value ? $value : '';
					$aUpdateValues[] = str_replace( chr( 10 ), ' ', str_replace( chr( 13 ), '', str_replace( "'", "�", str_replace( '"', '�', trim( $value ) ) ) ) );
				}
			}
			$strFields = implode( '|', $aUpdateFields );
			$strValues = implode( '|', $aUpdateValues );

			if ( $exprOk )
			{
				$GLOBALS[ 'strJsClick' ] = 'osSelecionar(\'' . $strFields . '\',\'' . $strValues . '\',\'' . $aParams[ 'functionExecute' ] . '\',0,\'' . $aParams[ 'focusFieldName' ] . '\');';
				$link = '<a class="fwLinkOnlineSearch" title="Clique aqui para selecionar!" href="javascript:void(0)" onClick="' . $GLOBALS[ 'strJsClick' ] . '">' . $cell->getValue() . '</a>';
			}
			else
			{
				$link = $cell->getValue();
			}
			$cell->setValue( $link );
		}
	}
}
///-----------------------------------------------------------------------------------------------
/*function gride_old($res,$aParams,$form)
{

	include('base/includes/funcoes.inc');
	include('base/classes/FormDin3.func.inc');
	// colunas
	$colGrid="";
	$gridCfg='COR_FUNDO||$nl%2!=0|#efefef';
	// criar o link de sele��o na coluna iformada ou na primeira coluna do $res se n�o tiver sido informado
	$columnLink		= null;
	$firstColumn	= null;

	if($aParams['gridColumns'])
	{
		$aColumns = explode(',',$aParams['gridColumns']);
		forEach($aColumns as $k=>$v)
		{
			@list($field,$label,$width,$align) = explode("|",$v);
			$colGrid .= $colGrid == "" ? "" : ",";
			$colGrid .= $field.'|'.$label;
			// se a coluna de link n�o existir ou for informada uma inv�lida, assumir a primeira coluna do gride
			$aParams['columnLink'] = is_null($aParams['columnLink']) ? $field : $aParams['columnLink'];
			if( $aParams['columnLink'] == $field)
			{
				$columnLink = $field;
			}
			if( (int)$width > 0 )
			{
				$gridCfg .=',LARGURA|'.$field.'||'.$width;
			}
			if( strtolower( (string)$align) == 'c' )
			{
				$gridCfg .=',ALINHAMENTO_TEXTO|'.$field.'||center';
			}
			elseif( strtolower( (string)$align) == 'r' )
			{
				$gridCfg .=',ALINHAMENTO_TEXTO|'.$field.'||right';
			}
		}
	}
	else
	{
		// se n�o foi informada nenhuma coluna, mostrar todas as colunas do $res
		foreach($res as $k=>$v)
		{
			$colGrid .= $colGrid == "" ? "" : ",";
			$colGrid .= $k.'|'.str_replace('_',' ',$k);
		}
	}
	// se a coluna de link n�o existir assumir a primeira coluna do $res
	if( ! array_key_exists($aParams['columnLink'],$res))
	{
		$aParams['columnLink'] = key($res);
	}
	// criar array com o nome dos campos que ser�o atualizados no formul�rio ao selecionar uma op��o
	$aUpdateFormFields=null;
	if($aParams['updateFormFields'])
	{
		// ,'END_PESSOA|des_endereco,DES_BAIRRO'
		$aUpdateFormFields = explode(',',$aParams['updateFormFields']);
	}

	// limitar a quantidade de registros
	if($aParams['maxRecords'] == 0)
	{
		$aParams['maxRecords'] = count($aParams['columnLink']);
	}

	// criar o link de sele��o na coluna do gride
	foreach($res[$aParams['columnLink']] as $k=>$v)
	{
		$aUpdateFields=array();
		$aUpdateValues=array();
		if(is_array($aUpdateFormFields))
		{
			// criar os parametros de retorno ao selecionar a op��o
			foreach($aUpdateFormFields as $k1=>$v1)
			{
				$aV 	= explode('|',$v1); // $v1 = END_PESSOA|des_endereco
				$aV[1] 	=  isset($aV[1]) ?  $aV[1] : strtolower($aV[0]);
				$aUpdateFields[] = $aV[1];
				$aUpdateValues[] = str_replace(chr(10),' ',str_replace(chr(13),'',str_replace("'","�",str_replace('"','�',trim($res[$aV[0]][$k])))));
			}
		}
		$strFields = implode('|',$aUpdateFields);
		$strValues = implode('|',$aUpdateValues);

		$ok=true;
		if($aParams['clickCondition'])
		{
			$aParams['clickCondition'] = str_replace(array(' or ',' and ',' OR ', ' AND '),array(' || ',' && ',' || ',' && '),$aParams['clickCondition']);
			@eval('$ok='.$aParams['clickCondition'].';');
		}
		// se for multiselect n�o tem onClick
		if( $ok && ! $aParams['multiSelectKeyField'])
		{
			$strJsClick = 'osSelecionar(\''.$strFields.'\',\''.$strValues.'\',\''.$aParams['functionExecute'].'\',0);';
			$res[ $aParams['columnLink']][$k] = '<a class="fwLinkOnlineSearch" title="Clique aqui para selecionar!" href="javascript:void(0)" onClick="'.$strJsClick.'">'.$v.'</a>';
			//echo $res[ $aParams['columnLink']][$k].'<br>';
		}
		// criar os checkbox para multiselect
		if( $aParams['multiSelectKeyField'] )
		{
			$res[ $aParams['columnLink']][$k] = '<input type="checkbox" style="cursor:pointer;vertical-align:middle;" name="'.$aParams['multiSelectKeyField'].'[]" value="'.$res[$aParams['multiSelectKeyField']][$k].'"'.( ($ok) ? "" : " disabled").'>&nbsp;'.(($ok)?'<b>':"").$v.(($ok)?'</b>':"");
		}
	}
	// quando for multiselect adicionar ao form um bot�o para finalizar consulta
	if( $aParams['multiSelectKeyField'] )
	{
		$btn=$form->addButton('Finalizar Sele��o','finalizar','btnFinalizar');
		$btn->setProperty('title','Marque os �tens desejados e clique aqui para finalizar a sele��o');
		$aParams['autoSelect']=false;
	}

	// se existir apenas uma op��o no gride, fazer a sele��o autom�tica
	if( count($res[key($res)])==1 && $aParams['autoSelect'] )
	{
		// para o formulario fechar automaticamente tem que ter um delay de 1 segundo para evitar erro no javascript da pagina
		$strJsClick = str_replace(',0);',',1000);',$strJsClick);
		$form->addJavascript($strJsClick);
		$form->setEnabled(false);
		return '';
	}
	else
	{
		return criarGride('gdsearch',$aParams['gridHeader']
			,$res
			,null
			,''
			,null
			,$colGrid
			,$aParams['windowHeight']-180
			,$aParams['windowWidth']-80
			,null
			,null
			,null
			,null
			,null
			,'Nenhum registro encontrado'
			,null //colunas ocultar
			,$gridCfg
			,false // so leitura
			,false // quebra linha autom�tica
			);
	}
}
*/
//-----------------------------------------------------------------------------------
/*
function getPath()
{
	$base='base/';
	$path='';
	for($i=0;$i<10;$i++)
	{
		if(!file_exists($path.$base))
		{
			$path .='../';
		}
		else
		{
			break;
		}
	}
	return $path;
}
*/
?>