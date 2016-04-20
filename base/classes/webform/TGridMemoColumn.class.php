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

class TGridMemoColumn extends TGridEditColumn
{
	private $columns;
	private $rows;
	private $showCounter;
	/**
	* Implementa coluna para entrada de texto com v�rias linhas no gride
	*
	* @param string $strEditName
	* @param string $strTitle
	* @param string $strFieldName
	* @param integer $intMaxLength
	* @param integer $intColumns
	* @param integer $intRows
	* @param boolean $boolReadOnly
	* @param boolean $boolShowCounter
	* @return TGridMemoColumn
	*
	*/
	public function __construct($strEditName,$strTitle=null,$strFieldName=null,$intMaxLength,$intColumns=null,$intRows=null,$boolReadOnly=null,$boolShowCounter=null)
	{
		parent::__construct($strEditName,$strTitle,$strFieldName,'memo',null,$intMaxLength,null,null,null,$boolReadOnly);
		$this->setRows($intRows);
		$this->setColumns($intColumns);
		$this->setShowCounter($boolShowCounter);
	}
	///---------------------------------------------------------------------------------------------------
	public function getEdit()
	{
	 	$edit = new TMemo(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getValue(),$this->getMaxLength(),false,$this->getColumns(),$this->getRows(),$this->getShowCounter());
	 	//$edit = new TMemo(strtolower($this->getEditName()).'['.$this->getKeyValue().']',$this->getValue(),500,false,$this->getColumns(),$this->getRows(),true);
		$edit->setValue($this->getValue());
	 	$edit->setId(strtolower($this->getEditName()).'_'.$this->getRowNum());
        $edit->setCss($this->getCss());
        $edit->setEvents($this->getEvents());
		if( is_null( $edit->getCss('border') ) )
		{
			$edit->setCss('border','1px solid silver');
		}
        return $edit;
	}
	public function setRows($intNewValue=null)
	{
		$this->rows = $intNewValue;
	}
	public function getRows()
	{
		return is_null($this->rows) ? 5 : $this->rows;
	}
	public function setColumns($intNewValue=null)
	{
		$this->columns = $intNewValue;
	}
	public function getColumns()
	{
		return is_null($this->columns) ? 30 : $this->columns;
	}
	public function setShowCounter($boolNewValue=null)
	{
		$this->showCounter = $boolNewValue;
	}
	public function getShowCounter()
	{
		return is_null($this->showCounter) ? true : $this->showCounter;
	}
}
?>