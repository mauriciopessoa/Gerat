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
Classe para entrada de n�mero de processo
*/
class TProcesso extends TEdit
{
	/**
	* Classe para entrada de n�mero de processo
	*
	* @param string $name
	* @param string $value
	* @param boolean $required
	*/
	public function __construct($strName,$strValue=null,$boolRequired=null)
	{
		parent::__construct($strName,$strValue,21,$boolRequired);
		$this->setFieldType('fone');
		$this->addEvent('onkeyup','fwFormatarProcesso(this)');
		$this->addEvent('onblur','fwValidarProcesso(this)');
	}
	public function getFormated()
	{

		if( $this->getValue() )
		{
			$value = ereg_replace("[^0-9]","",$this->getValue());
			if ( ! $value) // nenhum valor informado
			{
				return null;
			}
			if( strlen($value) == 17 )
			{
				$value = substr($value,0,5).'.'.substr($value,5,6).'/'.substr($value,11,4).'-'.substr($value,15,2);
			}
			else
			{
				$value=substr($value,0,5).'.'.substr($value,5,6).'/'.substr($value,11,2).'-'.substr($value,13,2);
			}
			return $value;
		}
	}
}
?>