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

include( 'autoload_formdin.php');
/**
* Classe para gerar a pagina HMTL
*/
class THtmlPage extends TElement
{
	private static $arrJsCssFile;
	private static $arrJsOnLoad;
	private static $style;
	private static $js;
	private $objHtml;
	private $objHead;
	private $objTitle;
	private $objBody;
	private $objForm;

	public function __construct()
	{
		parent::__construct('DOCTYPE');

		// elstilo da p�gina
        self::$style = new TElement('style');
        // scripts da p�gina
        self::$js = new TElement('script');
		$this->objHtml 	= new TElement('html');$this->objHtml->clearCss();$this->add($this->objHtml);
		//$this->objHtml->setProperty('lang','pt-br');
		$this->objHead 	= new TElement('head');$this->objHead->clearCss();$this->objHtml->add($this->objHead);
		$this->objBody 	= new TElement('body');$this->objBody->clearCss();$this->objHtml->add($this->objBody);
		$this->objHead->add('<meta http-equiv="Expires" content="Tue, 20 Aug 1996 14:25:27 GMT">');
		$this->objHead->add('<meta http-equiv="Content-Type" content="text/html; charset='.$this->getCharset().'">');
		$this->objTitle = new TElement('title');$this->objTitle->clearCss();$this->objHead->add($this->objTitle);
	}
	/**
	* M�todo para gerar o html da p�gina
	* Se $print for false retorna o html se for true manda para o browser
	*
	* @param boolean $print
	* @return mixed
	*/
	public function show($print=true)
	{
		if( !$this->getParentControl() )
		{
			$this->includeJsCssFiles();
			if( self::$style->getChildren())
			{
				$this->addInHead(self::$style);
			}
			$this->getJavascript();
		}
		if( $this->getForm())
		{
		 	//$this->addJsFile($this->objForm->getJs());
			$this->addInBody($this->objForm);
		}
		if ( $this->objBody->getChildren())
		{
			foreach($this->objBody->getChildren() as $k=>$child )
			{
				if(is_object($child) && method_exists($child,'getFieldType') && $child->getFieldType() == 'form')
				{
					//print 'tem um formulario';
					$this->addJsCssFile($child->getJsCss());
					// o form j� esta dentro de uma tag html, ent�o nao precisa imprimir a tag html nes os js e css dele
					$child->autoIncludeJsCss(false);
					$child->showHtmlTag(false);
				}
			}
		}
		// inserir no HEAD as fun��es e comandos javascripts
		//if( $js = $this->getJavascript())
		//{
			/*$js = new TElement('script');
			$js->clearCss();
			$js->add('jQuery(document).ready(function() {');
			$js->add(chr(9).'// javasripts que ser�o executados depois que o documento estiver 100% carregado.');
   			foreach($this->getJavascript() as $k=>$strJs)
			{
				$js->add(chr(9).str_replace(";;",";",$strJs.";"));
			}
			$js->add('});');
			*/
			//$this->addInHead($js);
		//}
		if($this->getParentControl())
		{
			$this->getBody()->setTagType('');
			return $this->getBody()->show($print);
		}
		else
		{
			return parent::show($print);

		}
	}
	/**
	* M�doto para adicionar um arquivo javascript ou css na p�gina
	* se o arquivo estiver na pasta padr�o base/js ou base/css
	* n�o precisa informar o caminho
	* Pode ser informado um array de arquivos no formato key/value
	*
	* @param string $mixJsCssFile
	*/
	public function addJsCssFile($mixJsCssFile)
	{
		if( is_array($mixJsCssFile))
		{
			foreach($mixJsCssFile as $k=>$file)
			{
				$this->addJsCssFile($file);
			}
		}
		else if( is_string($mixJsCssFile))
		{
			// ignorar se j� tiver adicionado
			if( !is_array(self::$arrJsCssFile) || !isset($mixJsCssFile) || array_search($mixJsCssFile,self::$arrJsCssFile,true) === false)
			{
				self::$arrJsCssFile[] = $mixJsCssFile;
			}
		}
	}
	/**
	* M�todo interno para gerar o codigo html de inser��o do arquivo js
	*
	*/
	protected function includeJsCssFiles()
	{
		if( is_array(self::$arrJsCssFile))
		{
			$jquery=false;
			foreach(self::$arrJsCssFile as $k=>$file)
			{
				if( !file_exists($file) )
				{
					$fileTemp = $this->getBase().'js/'.$file;
					if( file_exists($fileTemp) )
					{
						$file = $fileTemp;
					}
					else
					{
						$fileTemp = $this->getBase().'css/'.$file;
						if(file_exists($fileTemp))
						{
							$file = $fileTemp;
						}
						else
						{
							$fileTemp = $this->getRoot().'css/'.$file;
							if(file_exists($fileTemp))
							{
								$file = $fileTemp;
							}
							else
							{
								$fileTemp = $this->getRoot().'js/'.$file;
								if(file_exists($fileTemp))
								{
									$file = $fileTemp;
								}
								else
								{
									$file = null;
								}
        					}
						}
					}
				}
				if($file)
				{
					if( strpos($file,'.js'))
					{
						$this->objHead->add('<script type="text/javascript" src="'.$file.'"></script>');
						if( strpos($file,'jquery')!==false)
						{
							$jquery=true;
						}
					}
					else if( strpos($file,'.css'))
					{
						$this->objHead->add('<link rel="stylesheet" type="text/css" href="'.$file.'" />');

					}
				}
			}
			if( $jquery )
			{
				$this->objHead->add('<script>try{jQuery.noConflict();}catch(e){}</script>');
			}
		}
	}
	/**
	* Adiciona conteudo dentro da tag body. Pode ser um texto ou outro objeto da classe Element
	*
	* @param mixed $child
	*/
	public function addInBody($child)
	{
		if( is_array($child) )
		{
			foreach ($child as $k=>$v)
			{
				$this->objBody->add($v);
			}
		}
		else
		{
			if($child != null )
			{
				$this->objBody->add($child);
			}
//			if( is_object($child))
//			{
//				$child->setParentControl($this);
//			}
		}
	}
	/**
	* Adiciona conteudo dentro da tag title. Pode ser um texto ou outro objeto da classe Element
	*
	* @param mixed $child
	*/
	public function addInTitle($child)
	{
		if( is_array($child) )
		{
			foreach ($child as $k=>$v)
			{
				$this->objTitle->add($v);
			}
		}
		else
		{
			if($child != null )
			{
				$this->objTitle->add($child);
			}
		}
	}
	/**
	* Adiciona conteudo dentro da tag head. Pode ser um texto ou outro objeto da classe Element
	*
	* @param mixed $child
	*/
	public function addInHead($child)
	{
		if( is_array($child) )
		{
			foreach ($child as $k=>$v)
			{
				$this->objHead->add($v);
			}
		}
		else
		{
			if($child != null )
			{
				$this->objHead->add($child);
			}
		}
	}

	public function addForm($strTitle=null, $strFormName=null, $strWidth=null, $strHeight=null, $strMethod=null, $strAction=null)
	{
		$this->objForm = new TForm($strTitle, $strHeight, $strWidth, $strFormName, $strMethod, $strAction);
		return $this->objForm;
	}
	public function getForm()
	{
		return $this->objForm;
	}
	//-----------------------------------------------------------------------------
	/**
	 * M�todo para adicionar fun��es javascript na pagina que ser�o executadas
	 * ap�s o mesmo tiver sido completamente carregado pelo browser
	 * O parametro, opcional, $intIndex deve ser utilizado para estabelecer a ordem de
	 * execu��o, os menores ser�o executados primeiro;
	 * ex:	addJavascript("alert('mensagem 1')");
	 * 		addJavascript("alert('mensagem 2')",10);
	 *
	 * @param mixed $mixJs
	 * @param integer $intIndex
	 */
	public function addJavascript($mixJs,$intIndex=null)
	{
		if(isset($intIndex))
		{
			self::$arrJsOnLoad[$intIndex] = $mixJs;
		}
		else
		{
			if( !is_array(self::$arrJsOnLoad) )
			{
				// come�ar no indice 20 para poder inserir algum javascript que precise
				// ser executado primeiro
				self::$arrJsOnLoad[20] = $mixJs;
			}
			else
			{
				self::$arrJsOnLoad[] = $mixJs;
			}
		}
	}
	//-----------------------------------------------------------------------------
	/**
	* Retorna o texto javascript ou o objeto javascripts adicionados na pagina
	*
	*/
	public function getJavascript($boolReturnText=false,$boolOnLoad=true)
	{
		$boolReturnText = $boolReturnText === null ? false : $boolReturnText;
		$boolOnLoad 	= $boolOnLoad === null ? true : $boolOnLoad;
		$arrTemp=null;
		if(is_array(self::$arrJsOnLoad))
		{
			$arrTemp = (array)self::$arrJsOnLoad;
			// colocar em ordem crescente de execu��o
			ksort($arrTemp);
			self::$js->setProperty('language','javascript');
			self::$js->clearCss();
			if( $boolOnLoad )
			{
				self::$js->add('if( typeof jQuery=="function" ){try{ jQuery(document).ready(function() {');
			}
			self::$js->add(chr(9).'// javasripts que ser�o executados depois que o documento estiver 100% carregado.');
   			foreach($arrTemp as $k=>$mixJs)
			{
				if( is_object( $mixJs ) )
				{
					self::$js->add( $mixJs );
				}
				else
				{
					self::$js->add(chr(9).str_replace(";;",";",$mixJs.";"));
				}
			}
			if( $boolOnLoad)
			{
				self::$js->add('})} catch(e){ alert( e.message ); } }');
			}
			if( $boolReturnText===true )
			{
				return self::$js->show(false);
			}
			else
			{
				$this->addInHead(self::$js);
			}
		}
		return null;
	}
	public function getBody()
	{
		return $this->objBody;
	}
	public function addStyle($strStyle)
	{
		self::$style->add($strStyle);
	}
	// compatibilidade com jLayou
	public function getJsOnLoad()
	{
		return null;
	}
	public function setJsOnLoad()
	{
	}

	public function getCharset()
	{
  		if ( ! defined('CHARSET') )
		{
			define('CHARSET','iso-8859-1');
		}
		return CHARSET;
	}

	public function setTitle($strNewValue=null)
	{
		$this->objTitle->clearChildren();
		$this->objTitle->add($strNewValue);
	}
	public function getTitle()
	{
		return $this->objTitle->getChildren[0];
	}

}
// teste
/*
$p = new THtmlPage();
$p->show();
*/
?>