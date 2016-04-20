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
* Classe para implementar campos de entrada de dados de varias linhas (textareas)
*
*/
class TMemo extends TEdit
{
	private $showCounter;
	private $onlineSearch;
	public function __construct($strName,$strValue=null,$intMaxLength,$boolRequired=null,$intColumns=null,$intRows=null,$boolShowCounter=null)
	{
		parent::__construct($strName,$strValue,$intMaxLength,$boolRequired);
		parent::setTagType('textarea');
		parent::setFieldType('memo');
		$this->setColumns($intColumns);
		$this->setRows($intRows);
		$this->setShowCounter($boolShowCounter);
		$this->setProperty('wrap','virtual'); //Physical, off
	}
	public function show($print=true)
	{
		$this->setProperty('size',null);
		if((string)trim($this->getValue())!="")
		{
			$this->add($this->getValue());
		}
		$this->value=null;
		// adicionar o evento de valida��o de tamanho
		$this->addEvent('onkeyup','fwCheckNumChar(this,'.$this->maxlength.')');
		// remover os caracteres ENTER deixando somente as quebras de linhas
		$this->addEvent('onBlur','fwRemoverCaractere(this,13);this.onkeyup();');

		// se for para mostrar o contador de caracteres, criar um div externo
		if($this->getShowCounter())
		{
			$div = new TElement('div');
			$div->setId($this->getId().'_div');
			$div->setCss('display','inline');
			$div->add( parent::show(false).$this->getOnlineSearch());
			$counter = new TElement('span');
			$counter->setId($this->getId().'_counter');
			$counter->setCss('border','none');
			$counter->setCss('font-size','11');
			$counter->setCss('color','#00000');
			$div->add('<br>');
			$div->add($counter);
			$script=new TElement('<script>');
			$script->add('// inicializar o contador de caracteres.');
			$script->add('fwGetObj("'.$this->getId().'").onkeyup();');
			$div->add($script);
			return $div->show($print);
		}
		else
		{
			return parent::show($print).$this->getOnlineSearch();
		}
	}
	public function setColumns($intNewValue=null)
	{
		$intNewValue = is_null($intNewValue) ? 50 : $intNewValue;
		$this->setProperty('cols',$intNewValue);
	}
	public function getColumns()
	{
		return $this->getProperty('cols');
	}
	public function setRows($intNewValue=null)
	{
		$intNewValue = is_null($intNewValue) ? 5 : (int) $intNewValue;
		$this->setProperty('rows',$intNewValue);
	}
	public function getRows()
	{
		return $this->getProperty('rows');
	}
	public function setShowCounter($boolShow=null)
	{
		$boolShow = is_null($boolShow) ? true : (bool) $boolShow;
		$this->showCounter = $boolShow;
	}
	public function getShowCounter()
	{
		return $this->showCounter;
	}
	public function clear()
	{
		$this->clearChildren();
		parent::clear();
	}
	public function setOnlineSearch($strNewValue=null)
	{
		$this->onlineSearch = $strNewValue;
	}
	public function getOnlineSearch()
	{
		return $this->onlineSearch;
	}

}
/*
return;
$memo = new TMemo('obs_exemplo','Luis',500,false,50,10);
$memo->setValue('Luis Eug�nio Barbosa, estou lhe enviando este e-mail para confirmar se o precos da propsota est� de acordo com o que combinamos ontem.');
$memo->show();
*/
?>