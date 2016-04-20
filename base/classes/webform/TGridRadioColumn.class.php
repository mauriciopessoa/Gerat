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

class TGridRadioColumn extends TGridEditColumn
{
	private $descField;
	private $descValue;
	private $values;
	public function __construct($strEditName,$strTitle=null,$strKeyField,$strDescField=null,$boolReadOnly=null)
	{
		parent::__construct($strEditName,$strTitle,$strKeyField,'radio',null,null,null,null,$boolReadOnly);
		$this->setSortable(true);
		if( is_null( $strDescField ) )
		{
			$this->setCss('text-align','center');
		}
		$this->setDescField($strDescField);
		if( $_POST && isset($_POST[$strEditName]))
        {
        	$this->setvalues($_POST[$strEditName]);
		}
	}
	//---------------------------------------------------------------------------------------------------
	public function getEdit()
	{
		if(!$this->getTitle())
		{
			$this->setTitle('[X]');
		}
		$radio = new TElement('input');
		$radio->setProperty('type','radio');
		$radio->setCss('vertical-align','middle');
		$radio->setId($this->getEditName().'_'.$this->getRowNum());
		//$radio->setName($this->getEditName().'['.$this->getRowNum().']');
		$radio->setName($this->getEditName().'[]');
		$radio->setValue($this->getValue());
		//$radio->addEvent('onclick',"fwFieldradioBoxClick(this,'".$this->getEditName().'_desc_'.$this->getRowNum()."')");
        if($this->getReadOnly())
        {
			$radio->setProperty('disabled','true');
        }
        $hidden=null;
        if( is_array($this->getValues()))
        {
        	//print $this->getValue().':';
     		if( array_search($this->getValue(),$this->getValues()) !== false)
			{
				$radio->setProperty('checked','true');
				if($radio->getProperty('disabled'))
				{
					$hidden = new THidden($radio->getName(),$this->getValue());
					$hidden->setName($radio->getName());
					$hidden->setId($radio->getId());
					$radio->setId($radio->getId().'_disabled');
					$radio->setName($radio->getName().'_disabled');
					$radio->add($hidden);
				}

			}
        }
		if($this->getDescField())
		{
			$span = new TElement('span');
			$span->setId($this->getEditName().'_desc_'.$this->getRowNum());
			$span->setCss('cursor','pointer');
			$span->setCss('margin-right','2px');
			$span->add($this->getDescValue());
			$span->setEvent('onclick',"fwGetObj('".$this->getEditName()."_".$this->getRowNum()."').click();");
			if($radio->getProperty('checked'))
			{
				//$span->setCss('color','#0000ff');
 			}
			$radio->add($span);
		}
		// adicionar o nome do campo como attibuto do input
		$radio->setAttribute('fieldname',$this->getFieldName() );

        return $radio;
	}
	public function setDescField($strNewValue=null)
	{
		$this->descField = $strNewValue;
	}
	public function getDescField()
	{
		return $this->descField;
	}
	public function setDescValue($strNewValue=null)
	{
		$this->descValue = $strNewValue;
	}
	public function getDescValue()
	{
		return $this->descValue;
	}
	public function setValues($arrValues=null)
	{
		$this->values = $arrValues;
	}
	public function getValues($arrValues=null)
	{
		return $this->values;
	}
}
?>