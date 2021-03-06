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

//require_once 'base/classes/webform/TForm.class.php';

$frm = new TForm( 'Confirmar Pagamento Anvisa' , 260 , 635 );
$frm->setAction( 'Gravar,Limpar' );

$frm->addGroupField( 'grupo_confirma_pagamento' , 'Confirmar Pagamento Anvisa' , NULL , NULL , FALSE );
$frm->addTextField( 'num_ret' , 'N� Ret:' , 10 , TRUE , 10 )->setEnabled( FALSE );
$frm->addTextField( 'des_ret_registro_especial_temp' , 'Descri��o do Ret:' , 80 , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'nom_pessoa' , 'Nome da Pessoa:' , 80 , FALSE )->setEnabled( FALSE );
$frm->addCpfCnpjField( 'cpf_cnpj' , 'CPF/CNPJ' , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'end_pessoa' , 'Endere�o da Pessoa' , 80 , FALSE )->setEnabled( FALSE );
$frm->addTextField( 'des_bairro' , 'Bairro da Pessoa' , 80 , FALSE )->setEnabled( FALSE );
$frm->addDateField( 'dat_sit_anvisa_pago' , 'Dat. Pagamento' , TRUE );
$frm->closeGroup();

// consulta dinamica por numero de registro
$frm->setOnlineSearch('num_ret'
	, 'AGROTOXICO.PK_REGISTRO_ESPECIAL_TEMP.LIST_RET'
 	, 'NUM_RET|N� Ret:|10'
 	, 'NUM_RET'
 	, TRUE
	, TRUE
 	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP|N� Ret,DES_RET_REGISTRO_ESPECIAL_TEMP|Descri��o do Ret'
	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP|num_ret,DES_RET_REGISTRO_ESPECIAL_TEMP|des_ret_registro_especial_temp,NOM_PESSOA|nom_pessoa,NUM_CPF_CNPJ|cpf_cnpj,END_PESSOA|end_pessoa,DES_BAIRRO|des_bairro,DAT_SIT_ANVISA_PAGO|dat_sit_anvisa_pago'
 	, 'Consulta por N� Ret.'
	, 'Registros Encontrados'
 	, NULL
 	, 400
 	, 900
 	, "Consultar"
 	, NULL
 	, NULL
 	, 20
 	, TRUE
 	, NULL
 	, 'SEQ_RET_REGISTRO_ESPECIAL_TEMP');

switch ( $acao )
{
  case 'Gravar':
    
    // verifica se a pessoa est� tentando executar a mesma a��o
    if ( isset( $_SESSION[ 'token' ] ) and ( $_SESSION[ 'token' ] == md5( serialize( $_POST ) ) ) )
    {
      $frm->addJavascript( "alert('Grava��o j� foi Realizada!');" );
      break;
    } # end iF;
    
    // verifica a valida��o dos campos.
    if ( $frm->validate() )
    {
      // pega os campos do formul�rio que vai ser enviado ao pacote para atualizar os dados.
      $bvars = $frm->createBvars( 'num_ret,dat_sit_anvisa_pago' );
      
      // antes de executar pacote � criado a session[token] para verifica��o antes
      $_SESSION[ 'token' ]  = md5( serialize( $_POST ) );
           
      if( !$arrErro = executarPacote( 'AGROTOXICO.PK_REGISTRO_ESPECIAL_TEMP.ALT_CONFIRM_PAGAMENTO' , $bvars , 0 ) ) 
      {
        $frm->setPopUpMessage('Objeto Gravado com Sucesso!');
        $frm->clearFields();
      }
      else
      {
        $frm->setMessage( $arrErro );
      } # end iF;
      
    } # end iF;
    
    break;
  case 'Limpar':

    //limpando os campos do formul�rio
	$frm->clearFields();
    
    break;
} # end switch

$frm->show();

?>
