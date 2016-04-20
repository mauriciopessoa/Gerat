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

 class TPassword extends TEdit
{
	private $virtualKeyboard;
	private $showVirtualKeyboardImage;

	/**
	* Campo para entrada de senhas
	*
	* @param string $strName
	* @param string $strValue
	* @param integer $intMaxLength
	* @param boolean $boolRequired
	* @param integer $intSize
	* @param boolean $boolUseVirtualKeyboard
	* @param boolean $boolShowVirtualKeyboardImage
	* @param boolean $boolReadOnly
	* @return TPassword
	*/
	public function __construct($strName,$strValue=null,$intMaxLength,$boolRequired=null,$intSize=null, $boolUseVirtualKeyboard=null, $boolShowVirtualKeyboardImage=null, $boolReadOnly=null )
	{
		$intMaxLength = is_null($intMaxLength) ? 20 : $intMaxLength;
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired);
		$this->setFieldType('password');
		$this->setSize( is_null( $intSize) ? 20 : $intSize );
		$this->setProperty('type','password');
		$this->setProperty('autocomplete','off');
		$this->addEvent('onkeypress','return getCapsLock(event,this);');
		$this->addEvent('onkeydown','fwDisableCtrlKey(event,"c,v",this)'); // desabilitar ctrl+"v" e "c" no campo senha
		$this->setReadOnly( $boolReadOnly );
		if( $boolUseVirtualKeyboard === true )
		{
			$this->enableVirtualKeyborad();
			$this->setShowVirtualKeyboardImage($boolShowVirtualKeyboardImage);
			if( $boolReadOnly===false)
			{
				$this->setReadOnly( false );
    		}
		}
	}

	public function enableVirtualKeyborad()
	{
		$this->virtualKeyboard = true;
		$this->setReadOnly(true);
	}

	public function disableVirtualKeyborad()
	{
		$this->virtualKeyboard = false;
	}

	public function getVirtualKeyboard()
	{
		return $this->virtualKeyboard;
	}

	public function getShowVirtualKeyboardImage()
	{
		return $this->showVirtualKeyboardImage;
	}

	public function setShowVirtualKeyboardImage($boolNewValue=null)
	{
		$this->showVirtualKeyboardImage = $boolNewValue;
	}
}
/*
return;
$val = new TPassword('des_senha');
$val->show();
*/
?>