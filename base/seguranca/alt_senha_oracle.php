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
M�dulo de altera��o de senha oracle
Autor: Luis Eug�nio Barbosa
Data: 16/12/2009
*/
//$_SESSION[APLICATIVO]['login']['num_cpf']='45427380191';
//$_SESSION[APLICATIVO]['login']['nom_pessoa']='Luis Eug�nio';

$frm = new TForm('Formul�rio de Altera��o de Senha',220,500);
// campos do formulario
$frm->addCpfField('num_cpf','C.P.F.:',true);
$frm->addTextField('nom_pessoa','Nome:',50,true);
$frm->addPasswordField('des_senha_atual','Senha Atual:',true,true,20);
$frm->addHtmlField('separador','<hr>');
$frm->addPasswordField('des_senha','Nova Senha:',true,true,20);
$frm->addPasswordField('des_senha2','Digite Novamente:',true,true,20);

$frm->setAction('Gravar');

$frm->setValue('num_cpf',formatar_cpf_cnpj($_SESSION[APLICATIVO]['login']['num_cpf']));
$frm->setValue('nom_pessoa',$_SESSION[APLICATIVO]['login']['nom_pessoa']);
$frm->disableFields('num_cpf,nom_pessoa');

// tratamento das acoes do formulario
switch($acao)
{
	//---------------------------------------------------------------------------------

	case 'Gravar':
		if( $frm->validate() )
		{
			if((string)$frm->getValue('des_senha') <> (string)$frm->getValue('des_senha2'))
			{
				$frm->setMessage('Senhas n�o conferem!');
				break;
			}
			// validar senha atual
			if( $conn=oci_connect( limpar_numero($frm->getValue("num_cpf")),strtolower($frm->getValue("des_senha_atual")),BANCO_TNS))
			{
				ocilogoff($conn);
				$frm->setValue('des_senha',strtolower($frm->getValue('des_senha')));
				$bvars = $frm->createBvars('num_cpf,des_senha');
				if(!$frm->addError( executarPacote(ESQUEMA.'.PKG_SEGURANCA.ALT_SENHA_ORACLE',$bvars,-1) ) )
				{
					$frm->setMessage('Senha Alterada com Sucesso!!');
					$frm->clearFields();
					//$frm->setVisible(false);
				}
			}
			else
			{
				$frm->setMessage("Erro na valida��o da senha atual'");
				$erro = oci_error();
				if($erro["code"]==1017)
				{
					$frm->setMessage("Senha Atual Inv�lida.");
				}
				else if($erro["code"]==28000)
				{
					$frm->setMessage("Usu�rio(a) est� bloqueado(a)");
				}
			}
		}
	break;
}
$frm->show();
?>

