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

/**
* Classe para entrada de dados tipo CNPJ
*/
class TCnpj extends TMask
{
	private $invalidMessage;
	private $alwaysValidate;
	private $callback;

	/**
	* Met�do construtor
	*
	* @param string $strName
	* @param string $strValue
	* @param boolean $boolRequired
	* @return TCnpj
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null,$strInvalidMessage=null, $boolAwaysValidate = null,$strJsCallback=null)
	{
		parent::__construct($strName,$strValue=null,'',$boolRequired);
		$this->setFieldType('cnpj');
		$this->setEvent('onblur','fwValidarCnpj(this,event)');
		$this->setEvent('onkeyup','fwFormatarCnpj(this,event)');
		$this->setSize(19);
		$this->setInvalidMessage($strInvalidMessage);
		$this->setAlwaysValidate($boolAwaysValidate);
		$this->setCallback($strJsCallback);
	}

	public function show($print=true)
	{
        $this->setAttribute('meta-invalid-message',$this->getInvalidMessage());
        $this->setAttribute('meta-always-validate',$this->getAlwaysValidate());
        $this->setAttribute('meta-callback',$this->getCallback());
		return parent::show($print);
	}

	/**
	* Retorna o CNPJ formatado
	*
	*/
	public function getFormated()
	{
		if ( $this->getValue() )
		{
			$cnpj = @preg_replace("/[^0-9]/","",$this->getValue());
			return substr($cnpj,0,2).".".substr($cnpj,2,3).".".substr($cnpj,5,3)."/".substr($cnpj,8,4)."-".substr($cnpj,12,2);
		}
		return $ghis->getValue();
	}

	/**
	* Retorna o CNPJ sem formata��o
	*
	*/
	public function getValue()
	{
		return @preg_replace("/[^0-9]/","",$this->value);
	}
	public function setInvalidMessage($strNewValue=null)
	{
		$this->invalidMessage = $strNewValue;
	}

	public function getInvalidMessage()
	{
		return $this->invalidMessage;
	}

	public function setAlwaysValidate($boolNewValue=null)
	{
		$this->alwaysValidate = $boolNewValue;
	}

	public function getAlwaysValidate()
	{
		return ($this->alwaysValidate===true) ? 'true' :'false' ;
	}

	public function setCallback($strJsFunction=null)
	{
		$this->callback = $strJsFunction;
	}

	public function getCallback()
	{
		return $this->callback;
	}



}
?>