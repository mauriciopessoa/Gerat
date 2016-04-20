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

class TGridCheckColumn extends TGridEditColumn
{
	private $descField;
	private $descValue;
	private $values;
	private $allowCheckAll;
	public function __construct($strEditName,$strTitle=null,$strKeyField,$strDescField=null,$boolReadOnly=null,$boolAllowCheckAll=null)
	{
		parent::__construct($strEditName,$strTitle,$strKeyField,'checkbox',null,null,null,null,$boolReadOnly);
		$boolAllowCheckAll = is_null($boolAllowCheckAll) ? true : $boolAllowCheckAll;
		$this->allowCheckAll = $boolAllowCheckAll;
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
		$check = new TElement('input');
		$check->setProperty('type','checkbox');
		$check->setClass('fwCheckbox');
		//$check->setCss('vertical-align','middle');
		//$check->setCss('cursor','pointer');
		$check->setId($this->getEditName().'_'.$this->getRowNum());
		//$check->setName($this->getEditName().'['.$this->getRowNum().']');
		$check->setName($this->getEditName().'[]');
		$check->setValue($this->getValue());
		$check->addEvent('onclick',"fwFieldCheckBoxClick(this,'".$this->getEditName().'_desc_'.$this->getRowNum()."')");
		if( $this->getEvents() )
		{
			foreach($this->getEvents() as $name=>$event)
			{
				$check->addEvent($name,$event);
			}
		}
        if($this->getReadOnly())
        {
			$check->setProperty('disabled','true');
        }
        $hidden=null;
        if( is_array($this->getValues()))
        {
        	//print $this->getValue().':';
     		if( array_search($this->getValue(),$this->getValues()) !== false)
			{
				$check->setProperty('checked','true');
				$check->setCss('color','#0000ff');
				if($check->getProperty('disabled'))
				{
					$hidden = new THidden($check->getName(),$this->getValue());
					$hidden->setName($check->getName());
					$hidden->setId($check->getId());
					$check->setId($check->getId().'_disabled');
					$check->setName($check->getName().'_disabled');
					$check->add($hidden);
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
			if($check->getProperty('checked'))
			{
				$span->setCss('color','#0000ff');
 			}
			$check->add($span);
		}

		// adicionar o nome do campo como attibuto do input
		$check->setAttribute('fieldname',$this->getFieldName() );

		/*
		assim n�o funciona - exce��o do camp check
	 	$edit = new TCheck($this->getEditName(),array($this->getvalue()=>''),null,false,null);
	 	$edit->setShowMinimal(true);
	 	$edit->setId('seq_bioma');
        $edit->setEvents($this->getEvents());
        */
        return $check;
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
	public function getAllowCheckAll()
	{
		return is_null($this->allowCheckAll) ? true : (bool)$this->allowCheckAll;
	}
}
?>