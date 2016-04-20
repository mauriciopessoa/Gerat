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

class TTable Extends TElement
{
	public function __construct($strName=null)
	{
		parent::__construct('table');
		$this->setId($strName);
	}

	//------------------------------------------------------------------
	public function addRow($strId=null)
	{
		$row = new TTableRow();
		$row->setId($strId);
		parent::add($row);
		return $row;
	}
}
//------------------------------------------------------------------------
class TTableRow extends TElement
{
	private $visible;
	public function __construct()
	{
		parent::__construct('tr');
		$this->setVisible(true);
	}
	//------------------------------------------------------------------
	public function addCell($value=null,$strId=null)
	{
		$cell = new TTableCell($value);
		$cell->setId($strId);
		parent::add($cell);
		return $cell;
	}
	public function setVisible($boolNewValue=null)
	{
		$boolNewValue = is_null($boolNewValue) ? true :$boolNewValue;
		$this->visible = $boolNewValue;
	}
	public function getVisible()
	{
		return $this->visible;
	}
	public function show($print=true)	{
		if($this->getVisible())
		{
			return parent::show($print);
		}
		return null;
	}
}

//------------------------------------------------------------------------
class TTableCell extends TElement
{
	public function __construct($value=null)
	{
		parent::__construct('td');
		parent::add($value);
	}
	public function getValue()
	{
		if( $this->getChildren())
		{
			$children = $this->getChildren();
			if( is_object($children[0] ) )
			{
				return '';
			}
			return implode('',$this->getChildren());
		}
		return '';
	}
	public function setValue($newValue=null)
	{
		$this->clearChildren();
		$this->add($newValue);
	}
}
/*
//------------------------------------------------------------------------------------
$tb = new TTable;
$tb->border=1;
$tb->width=300;

$row = $tb->addRow();
$row->bgColor="#efefef";
	$cell = $row->addCell('celula 1');
	$cell->colspan=5;
	$cell->align="center";
$row = $tb->addRow();

$row->bgColor="green";
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
	$cell = $row->addCell('celula 1');
$tb->show();
*/
?>