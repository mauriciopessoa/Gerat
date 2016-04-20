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

class TFone extends TEdit
{
	/**
	 * @param string $name
	 * @param string $value
	 * @param boolean $required
	 */
	public function __construct($strName,$strValue=null,$boolRequired=null)
	{
		parent::__construct($strName,$strValue,18,$boolRequired);
		$this->setFieldType('fone');
		$this->addEvent('onkeyup','fwFormatarTelefone(this)');
		// aplicar formata��o ao exibir.
		$js = new TElement('script');
		$js->setProperty('type',"text/javascript");
		$js->add('fwFormatarTelefone(fwGetObj("'.$this->getId().'"));');
		$this->add($js);
	}
	public function getFormated()
	{

		if( $this->getValue() )
		{
			$value = ereg_replace("[^0-9]","",$this->getValue());
			// nao pode comecar com zero
			while ( substr($value,0,1)==="0" )
			{
				$value=substr($value,1);
			}
			if ( ! $value) // nenhum valor informado
			{
				return null;
			}
			if ( strlen($value) < 5 ) // n�o precisa formatar
			{
				return $value;
			}
			if ( substr($value,0,4) == '0800' )
			{
				print 'luis';
				$value = substr($value,0,4)." " . substr($value,4,3) . " " . substr($value,7);
			}
			else if (strlen($value) < 8 )
			{
				$value = substr($value,0,3).'-'.substr($value,3);
			}
			else if (strlen($value) == 8 )
			{
				$value=substr($value,0,4).'-'.substr($value,4);
			}
			elseif (strlen($value)==9)
			{
				$value='(0xx'.substr($value,0,2).') '.substr($value,2,3).'-'.substr($value,5);
			}
			elseif (strlen($value)==10)
			{
				$value='(0xx'.substr($value,1,2).') '.substr($value,3,3).'-'.substr($value,6);
			}
			elseif (strlen($value) > 10 )
			{
				$value='(0xx'.substr($value,1,2).') '.substr($value,3,4).'-'.substr($value,7);
			}
			return $value;
		}
	}
}
//$val = new TFone('des_telefone','6234683581',50);
//$val->show();
//print '<br>'.$val->getValue();
//print '<br>'.$val->getFormated();
?>