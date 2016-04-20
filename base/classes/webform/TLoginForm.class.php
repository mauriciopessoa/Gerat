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

Class TLoginForm extends TForm
{
	private $title;
	private $height;
	private $width;
	private $loginLabel;
	private $passwordLabel;
	private $loginField;
	private $passworkField;
	private $htmlField;
	private $onLoginFunction;
	private $onExitFunction;
	private $btnLoginLabel;
	private $btnExitLabel;

	public function __construct($strOnLoginFunction=null, $strOnExitFunction = null, $strTitle=null, $strFieldLoginLabel=null, $strFieldPasswordLabel=null, $strBtnLoginLabel=null,$strBtnExitLabel=null, $strHeight=null, $strWidth=null)
	{
		// valores padr�o
		$strTitle  				= is_null($strTitle) 				? 'Acesso ao Sistema' : $strTitle;
		$strHeight 				= is_null($strHeight) 				? '160' 	: $strHeight;
		$strWidth  				= is_null($strWidth)  				? '300'		: $strWidth;
		$strTitle  				= is_null($strTitle)  				? 'Acesso ao Sistema' : $strTitle;
		$strFieldLoginLabel		= is_null($strFieldLoginLabel)  	? 'Login:' 	: $strFieldLoginLabel;
		$strFieldPasswordLabel	= is_null($strFieldPasswordLabel)	? 'Senha:' 	: $strFieldPasswordLabel;
		$strBtnLoginLabel		= is_null($strBtnLoginLabel)  		? 'Entrar' 	: $strBtnLoginLabel;
		$strBtnExitLabel		= is_null($strBtnExitLabel)  		? 'Sair' 	: $strBtnExitLabel;


		parent::__construct($strTitle,$strHeight,$strWidth);
		$this->setShowCloseButton(false);
		$this->setShowMessageForm(false);
		$this->setAutoSize(true);
		$this->setColumns(60);
		$this->setPageOverFlow(false);

		$this->loginLabel		= $strFieldLoginLabel;
		$this->passwordLabel	= $strFieldPasswordLabel;

		$this->onLoginFunction		= $strOnLoginFunction;
		$this->onExitFunction		= $strOnExitFunction;
		$this->btnLoginLabel		= $strBtnLoginLabel;
		$this->btnExitLabel			= $strBtnExitLabel;
		$this->addGroupField('gpFields');
			$this->loginField 			= $this->addTextField('login',$this->loginLabel,30,true,30,null,true,null,null,false);
			$this->passworkField 		= $this->addPasswordField('password',$this->passwordLabel,true,true,30,null,false);
		$this->closeGroup();
		$this->addGroupField('gpMessage')->setvisible(false);
			$this->htmlField 			= $this->addHtmlField('msg');
			$this->htmlField->setCss('text-align','center');
			$this->htmlField->setCss('font-size','18px');
			$this->htmlField->setCss('color','#000000');
			$this->htmlField->setCss('font-weight','bold');
		$this->closeGroup();
    }
	public function show($print=true)
	{
		$this->setAction($this->btnLoginLabel.','.$this->btnExitLabel);

		$_POST['formDinAcao']  = isset( $_POST['formDinAcao'] ) ? $_POST['formDinAcao'] : null;
		if( $_POST['formDinAcao'] == $this->btnLoginLabel )
		{
			if( $this->validate() )
			{
				$login 		= $this->get('login');
				$password 	= $this->get('password');
				$message 	= null;
				$script		= null;
				$this->setMessage($message);
				$this->addJavascript($script);
				$this->setTitle('');
				$this->removeField(null,'msg');
				$this->htmlField->setValue('<br>Validando informa��es!');
				$this->setAction('');
				if( $this->onLoginFunction && function_exists($this->onLoginFunction) )
				{
					if( ! call_user_func_array($this->onLoginFunction,array(&$login,&$password,&$message,&$script ) ) )
					{

					}
				}
			}
		}
		else if( $_POST['formDinAcao'] == $this->btnExitLabel)
		{
				if( $this->onLoginFunction && function_exists($this->onExitFunction ) )
				{
					die( call_user_func_array($this->onExitFunction,array(&$message,&$script) ) ) ;
				}
				if( $script )
				{
					$this->setMessage($message);
					$this->addJavascript($script);
					$this->removeField(null,'msg');
					$this->addJavascript('fwApplicationEnd()');
					$this->htmlField->setValue('<br>Encerrando aplica��o!');
					$this->setAction('');
					unset($_SESSION[APLICATIVO]);
				}
		}
		return parent::show($print);
	}
}
?>