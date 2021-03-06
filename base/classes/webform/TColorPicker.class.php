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
* Campo para sele��o de cor
*
*/
class TColorPicker extends TEdit
{
	public function __construct($strName,$strValue=null,$boolRequired=null)
	{

		parent::__construct($strName,$boolRequired,(string)$strValue);
		parent::setFieldType('color');
		parent::setProperty('type','hidden');
		parent::setMaxLenght(null);
		parent::setSize(null);
		parent::setRequired($boolRequired);
		$this->clearCss();
		$this->clearEvents();
	}
	public function show($print=true)
	{
		$this->clearChildren();
		$a = new TElement('a');
		$a->setId($this->getId().'_preview');
		//$a->setProperty('href',"javascript:pickColor('".$this->getId()."');");
		$a->setProperty('href',"javascript:void(0);");
		$a->addEvent('onclick',"if( this.getAttribute('readonly') == 'readonly' ) { return }; pickColor('".$this->getId()."');");
		$a->setClass('fwColorPick');
		$a->setCss('background-color',$this->getValue());
		$a->add('&nbsp;&nbsp;&nbsp;');
		if( $this->getReadOnly())
		{
			$a->setAttribute('readonly','readonly');
		}
		$this->add($a);
		return parent::show($print);
	}
}
//$t = new TColorPicker('cod_cor',null,true);
//$t->show();
?>