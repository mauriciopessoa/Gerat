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
*	Classe criar campos de conte�do livre ( html )
*/
class THtml extends TControl
{
	private $includeFile;
	private $width;
	private $height;
	private $gridFile;
	private $loadingMessage;
	public function __construct($strName,$strValue=null,$strIncludeFile=null,$strHeight=null,$strWidth=null,$strGridId=null,$strGridFile=null,$strLoadingMessage=null)
	{
		//parent::__construct('fieldset',$strName);
		parent::__construct('div',$strName,$strValue);
		parent::setFieldType('html');
		$this->setClass('fwHtml');
		$this->setWidth($strWidth);
		$this->setHeight($strHeight);
		$this->setIncludeFile($strIncludeFile);
		$this->setGridFile($strGridFile,$strGridId);
		$this->setLoadingMessage($strLoadingMessage);
	}
	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		$this->add($this->getHtmlValue());
		return parent::show($print);
	}
	//-------------------------------------------------------------------------------------
	public function setIncludeFile($strFileName=null)
	{
		$this->includeFile =$strFileName;
	}
	//-------------------------------------------------------------------------------------
	public function getIncludeFile()
	{
		if( !is_null($this->includeFile) && !file_exists($this->includeFile) )
		{
			$this->setValue('Arquivo '.$this->includeFile.' n�o encontrado');
		}
		else
		{
			return $this->includeFile;
		}
	}
	//-------------------------------------------------------------------------------------
	public function getHtmlValue()
	{
		if($this->getIncludeFile() )
		{
			return $this->parseFile();
		}
		return null;
	}
	//-----------------------------------------------------------------------------
	protected function parseFile()
	{
		//return implode("", file($this->getIncludeFile(),1));
		ob_start();
		eval("?>" .implode("", file($this->getIncludeFile(),1))."<?" );
		$c = ob_get_contents();
		ob_clean();
		return $c;
	}
	//------------------------------------------------------------------------------
	public function setValue( $strNewValue = null )
	{
		$this->clearChildren();
		$this->add($strNewValue);
		parent::setValue(null);
	}
	//-------------------------------------------------------------------------------
	public function getValue()
	{
		if($this->getIncludeFile() )
		{
			return $this->parseFile();
		}
		return $this->value;
		//return implode('',$this->getChildren());
	}
	//-----------------------------------------------------------------------------------
	/**
	* Define o nome de um arquivo que cria um gride utilizando a classe TGrid
	* Se for definido este parametro, o TForm criar� o javascript para carregamento do gride via ajax
	*
	* @param mixed $strGridFile
	*/
	public function setGridFile($strGridFile,$strGridId,$mixFormFields=null)
	{
		if( !is_null($strGridFile) )
		{
			$this->gridFile=null;
			$this->gridFile['id'] 	= $strGridId;
			$this->gridFile['file'] = $strGridFile;
			$this->setFormFields($mixFormFields);
			$this->setIncludeFile(null);
		}
	}
	/**
	* Retonra o array com as informa��es do ID e FILE do arquivo do gride
	* se for passado null como parametro.
	* Se for passado id, retorna o ID
	* Se for passado file, retorna o FILE
	*/
	public function getGridFile($strKey=null)
	{
		if( is_null($strKey))
		{
			return $this->gridFile;
		}
		else
		{
			return $this->gridFile[$strKey];
		}
	}
	//-------------------------------------------------------------------------------------
	public function setLoadingMessage($strNewValue=null)
	{
		$this->loadingMessage = str_replace("'",'"',$strNewValue);
	}
	public function getLoadingMessage()
	{
		return $this->loadingMessage;
	}
	//---------------------------------------------------------------------
	public function setFormFields($mixFormFields = null)
	{
		if( is_string($mixFormFields))
		{
			$mixFormFields = explode(',',$mixFormFields);
		}
		$this->gridFile['formFields'] = $mixFormFields;
	}
}
/*
// teste do campo html
$html = new THtmlField('html_teste','Luis Eugenio',null,800,600);
//$html = new THtmlField('html_teste','Luis Eugenio','t.html',600,200);
//$html = new THtmlField('html_teste','Luis Eugenio','teste.inc',600,200);
//$html->setValue('as�dkflaskdfjakldjfaskdfj');
//$html->setIncludeFile('y.html');
$html->show();
*/

/*
$frm = new TForm('Campo Html',100,800);
$f = $frm->addHtmlField('url_arquivo'		,'http://siscom.ibama.gov.br/mapoteca_img/landsat_origin_html/228-71.html');
		$f->setcss('color','blue');
		$f->setcss('text-decoration','underline');
		$f->setcss('cursor','pointer');
		$f->setEvent('onclick','alert("abrir janela")');
$frm->setAction('GRAVA');
$frm->show();
print_r($_POST);
*/
/*
$h = new THtml('obs','Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div Observa��o oara teste de quebra do campo html dento de uma div ',null,100,500);
print $h->getValue();
//$h->show();
print '<hr>';
$h = new THtml('obs',null,'ajuda/nom_pessoa.html',100,500);
//$h->show();
print $h->getValue();
*/
?>