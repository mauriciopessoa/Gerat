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
*  Classe para criar bot�es
*/
class TButton extends TControl
{
	private $action;
	private $onClick;
	private $confirMessage;
	private $imageEnabled;
	private $imageDisabled;
	private $submitAction;
	public function __construct($strName,$strValue=null,$strAction=null,$strOnClick=null,$strConfirmMessage=null,$strImageEnabled=null,$strImageDisabled=null,$strHint=null,$boolSubmitAction=null)
	{
		$strName = is_null( $strName ) ? $this->removeIllegalChars( $strValue ) : $strName;
		parent::__construct('button',$strName,$strValue);
		$this->setHint($strHint);
		//print $strHint.',';
		$this->setFieldType('button');
		$this->setProperty('type','button');
		$this->setAction($strAction);
		$this->setOnClick($strOnClick);
		$this->setConfirmMessage($strConfirmMessage);
		$this->setSubmitAction($boolSubmitAction);
		// definir o estilo do bot�o
		/*$this->setCss('border','1px outset silver');
		$this->setCss('background-color','#E1E1E1');
		$this->setCss('background','#ddd url('.$this->getBase().'imagens/fwbuttonbg.gif) left center repeat-x');
		$this->setCss('color','blue');
		$this->setCss('cursor','pointer');
		*/
		$this->setImage($strImageEnabled);
		$this->setImageDisabled($strImageDisabled);
		$this->setClass('fwButton');
	}

	public function show($print=true)
	{
	    // ajustar as propriedades se o bot�o for uma imagem
	    $isImage=false;
		if((string)$this->getImage()!="")
		{
			$this->setTagType('img');
			$this->setFieldType('img');
			$this->setProperty('src',$this->getImage());
			if( $this->getClass() == 'fwButton' )
			{
				$this->setProperty('class',null);
				$this->setCss('background',null);
				$this->setCss('cursor','pointer');
				$this->setCss('background-color',null);
				$this->setCss('font-family',null);
				$this->setCss('font-size',null);
				$this->setCss('border','none');
				$this->setCss('color',null);
				$this->setCss('vertical-align','top');
                if( is_null( $this->getProperty('alt')))
                {
                    $this->setProperty('alt', $this->getvalue() );
                }
                if( !$this->getProperty('title'))
                {
                	$this->setProperty('title', $this->getValue() );
                }
                $this->setAttribute('type',null);
				$this->setValue('');
			}
			$isImage=true;
		}

        // regra de acessibilidade
        if( is_null( $this->getHint() ) )
        {
            $this->setHint($this->getValue());
        }

//		$jsConfirm=null;
		$jsConfirmBegin=null;
		$jsConfirmEnd=null;
		if((string)$this->getConfirmMessage() != '')
		{
			//Alterado para padronizar as mensagens utilizando o fwConfirm
			//Por Diego Barreto e Felipe Colares
// 			$jsConfirm = 'if( !confirm("'.$this->getConfirmMessage().'")){return false;} ';
			$jsConfirmBegin = 'fwConfirm("'.htmlentities($this->getConfirmMessage(),null,'ISO-8859-1').'", function() { ';
			$jsConfirmEnd	= '}, function() {})';
		}

		// o evento action tem precedencia sobre o evento onClick
		if((string)$this->getAction()!='')
		{
			if( $this->getSubmitAction() )
			{
				$formAction = 'fwFazerAcao("'.$this->getAction().'")';
// 				$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};this.disabled=true;this.value="Aguarde";this.style.color="red";'.$formAction);
				$this->addEvent('onclick',$jsConfirmBegin.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};jQuery(this).attr("disabled","true").val("Aguarde").css("color","red");'.$formAction.$jsConfirmEnd);
			}
			else
			{
// 				$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};');
				$this->addEvent('onclick',$jsConfirmBegin.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};.'.$jsConfirmEnd);
			}
			//$this->addEvent('onclick',$jsConfirm.'if( typeof(btn'.ucwords($this->getId()).'OnClick)=="function"){btn'.ucwords($this->getId()).'OnClick(this);return true;};this.disabled=true;this.value="Aguarde";this.style.color="red";fwFazerAcao("'.$this->getAction().'")');
			//$this->addEvent('onclick','if(!'.$this->getId().'Click()) { return false } '.$jsConfirm.'fwFazerAcao("'.$this->getAction().'")');
		}
		else if($this->getOnClick())
		{
			$this->setEvent('onclick',$jsConfirmBegin.$this->getOnClick().$jsConfirmEnd,false);
		}
		if( !$this->getEnabled() )
		{
			$this->setCss('cursor','default');
			if( ! $this->getProperty('title') )
			{
				$this->setProperty('title',htmlentities('A��o desabilitada',null,'ISO-8859-1') );
			}
			// a imagem n�o tem como desabilitar ent�o remover os eventos
			if( $isImage )
			{
				$this->clearEvents();
			}
		}
		$this->add( $this->getValue() );
		$this->setValue(null);
		return parent::show($print);
	}
	//-----------------------------------------------------------------------------------------------
	public function setAction($strNewValue=null)
	{
		$this->action = $strNewValue;
	}
	public function getAction()
	{
		if((string) $this->action =='' && (string)$this->getOnClick()=='')
		{
			$this->setAction($this->getValue());
		}
		return $this->action;
	}
	public function setOnClick($strFunctionJs=null)
	{
		$this->onClick = $strFunctionJs;
	}
	public function getOnClick()
	{
		if( !is_null($this->onClick))
		{
			return $this->onClick;
		}
		return $this->getEvent('onclick');
	}
	public function setConfirmMessage($strNewMessage=null)
	{
		$this->confirMessage = $strNewMessage;
	}
	public function getConfirmMessage()
	{
		return $this->confirMessage;
	}
	public function setImage($strNewImage=null)
	{
		$this->imageEnabled=$strNewImage;
	}
	public function getImage()
	{
		$path="";
		if($this->getEnabled())
		{
			$image = $this->imageEnabled;
		}
		else
		{
			$image = $this->getImageDisabled();
		}
		if($image)
		{
			// se n�o foi informado o endere�o manualmente, encontrar na pasta base
			if( strpos($image,'/')===false)
			{
				if( ! file_exists($image) )
				{
					$path = $this->getBase().'imagens/';
				}

			}
		}
		if( ! file_exists($path.$image) )
		{
			$image = str_replace('_disabled.','.',$image);
		}
		return $path.$image;
	}
	public function setImageDisabled($strNewImage=null)
	{
		$this->imageDisabled=$strNewImage;
	}
	public function getImageDisabled()
	{
		if( !$this->imageDisabled )
		{
			if( file_exists($this->getBase().'imagens/'.str_replace('.','_disabled.',$this->imageEnabled)))
			{
				return str_replace('.','_disabled.',$this->imageEnabled );
			}
			else
			{
				return 'fwblank16x16.png';
			}
		}
		return $this->imageDisabled;
	}
	public function setSubmitAction($boolNewValue=null)
	{
		$this->submitAction = $boolNewValue;
	}
	public function getSubmitAction()
	{
		return is_null($this->submitAction) ? true : $this->submitAction;
	}
	public function clearEvents()
	{
		$this->setOnClick(null);
		parent::clearEvents();
	}
}
/*
$btn = new TButton('btnGravar','Gravar','actGravar',null,'Confirma Grava��o ?');
$btn->setImage('btnCalendario.gif');
$btn->show();
*/

//$btn = new TButton('btnGravar','Gravar',null,'fwTeste()','Tem Certeza ?','../../imagens/search.gif','../../imagens/lixeira.gif');
//$btn->setEnabled(false);
//$btn->setVisible(false);
//$btn->show();
?>