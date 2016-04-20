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

class TGridSelectColumn extends TGridEditColumn
{
	private $options;
	private $firstOptionText;
	private $keyField;
	private $displayField;
	private $initialValueField;

	/**
	* Implementa coluna do tipo menuSelect no gride
	*
	* Ex: addSelectColumn('seq_tipo','TIPO','SEQ_TIPO','1=Um,2=Dois');
	*
	* @param string $strEditName
	* @param string $strTitle
	* @param string $strFieldName
	* @param mixed $mixOptions
	* @param string $strWidth
	* @param boolean $boolReadOnly
	* @param string $strFirstOptionText
	* @param string $initialValueField
	*
	* @return TGridSelectColumn
	*/
	public function __construct($strEditName,$strTitle,$strFieldName,$mixOptions=null,$strWidth=null,$boolReadOnly=null,$strFirstOptionText=null,$strFirstOptionValue=null, $strKeyField=null,$strDisplayField=null,$strInitialValueField=null)
	{
		parent::__construct($strEditName,$strTitle,$strFieldName,'select',null,null,null,$strWidth,null,$boolReadOnly);
		$this->setOptions($mixOptions);
		$this->setFirstOptionText($strFirstOptionText);
		$this->setDisplayField($strDisplayField);
		$this->setKeyField($strKeyField);
		$this->setInitialValueField($strInitialValueField);
	}
	///---------------------------------------------------------------------------------------------------
	public function getEdit()
	{
	 	$edit = new TSelect(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getOptions(),$this->getValue(),false,false,null,$this->getWidth(),$this->getFirstOptionText(),null,$this->getKeyField(),$this->getDisplayField());
	 	$edit->setId(strtolower($this->getEditName()).'_'.$this->getRowNum());
        $edit->setCss($this->getCss());
        $edit->setEvents($this->getEvents());
		// adicionar o nome do campo como attibuto do input
		$edit->setAttribute('fieldname',$this->getFieldName() );
		$edit->setAttribute('fwName',$this->getEditName() );
        return $edit;
	}
	//---------------------------------------------------------------------------------------------
	public function setOptions($arrNewValues=null)
	{
		$this->options = $arrNewValues;
	}
	//---------------------------------------------------------------------------------------------
	public function getOptions()
	{
		return $this->options;
	}
	//---------------------------------------------------------------------------------------------
	public function setFirstOptionText($strFirstOptionText=null)
	{
		$this->firstOptionText = $strFirstOptionText;
	}
	//---------------------------------------------------------------------------------------------
	public function getFirstOptionText()
	{
		return $this->firstOptionText;
	}
	//----------------------------------------------------------------------------------------
	public function setDisplayField($strNewValue=null)
	{
		$this->displayField = $strNewValue;
	}
	//----------------------------------------------------------------------------------------
	public function setKeyField($strNewValue=null)
	{
		$this->keyField = $strNewValue;
	}
	//----------------------------------------------------------------------------------------
	public function getDisplayField()
	{
		return $this->displayField;
	}
	//----------------------------------------------------------------------------------------
	public function getKeyField()
	{
		return $this->keyField;
	}
	//----------------------------------------------------------------------------------------
	public function setInitialValueField($strNewValue=null)
	{
		$this->initialValueField = $strNewValue;
	}
	//----------------------------------------------------------------------------------------
	public function getInitialValueField()
	{
		return $this->initialValueField;
	}
}
?>