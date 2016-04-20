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
 * Extens�o da classe TForm para criar formul�rios com imagem de fundo
 */
 class TFormImage extends TForm
 {
	private $bgImage;
	private $bgRepeat;
	private $bgPosition;
	private $width;
	private $height;
	public function __construct($strTitle=null, $strbgImagePath=null, $strBgRepeat=null, $strBgPosition=null, $strHeight=null, $strWidth=null, $strFormName=null, $strMethod=null, $strAction=null,$boolPublicMode=null )
	{
    	parent::__construct(null, $strHeight, $strWidth, $strFormName, $strMethod, $strAction,$boolPublicMode);
    	$this->width 	= $strWidth;
    	$this->height 	= $strHeight;
    	$this->setBgImage($strbgImagePath);
    	$this->setBgRepeat($strBgRepeat);
    	$this->setBgPosition($strBgPosition);
    	$this->setRequiredFieldText('');
	}
	public function show( $print=true )
	{
		$this->setFlat(true);
		$this->body->setCss('border-top','0px');
		$this->body->setCss('border-bottom','0px');
		$this->setCss('background-color','transparent');
		$this->setCss('background-image','url('.$this->getBgImage().')');
		$this->setCss('background-repeat',$this->getBgRepeat());
		$this->setCss('background-position',$this->getBgPosition());
		if( $this->width=='' || $this->height==''  )
		{
			if( $this->getBgImage() && function_exists('getimagesize') )
			{
				list($width, $height) = getimagesize( $this->getBgImage() );
           		if( is_null($this->width)  )
           		{
					$this->setWidth($width);
				}
				if( is_null($this->height ) )
				{
					$this->setHeight($height);
				}
			}
		}
		return parent::show($print);
	}

	//-----------------------------------------------------------------------------------
	public function setBgImage($strNewValue = null,$strRepeat=null)
	{
	    $this->bgImage = $strNewValue;
	    $this->setBgRepeat( $strRepeat );
	}
	public function getBgImage()
	{
		if( file_exists($this->bgImage))
		{
			return $this->bgImage;
		}
		return null;
	}
	//-----------------------------------------------------------------------------------
	public function setBgPosition($strNewValue = null)
	{
	    $this->bgPosition = $strNewValue;
	}
	public function getBgPosition()
	{
		return is_null($this->bgPosition) ? 'top': $this->bgPosition;
	}
	//-----------------------------------------------------------------------------------
	public function setBgRepeat($strNewValue = null)
	{
		$this->bgRepeat = $strNewValue;
	}
	public function getBgRepeat()
	{
		if( is_null($this->bgRepeat) && $this->getBgImage() && function_exists('getimagesize') )
		{
			list($width, $height) = getimagesize( $this->getBgImage() );
			//echo $this->getBgImage().' w:'.$width. ' h:'.$height.'<br>';
			if( $width > 100 && $height < 30 )
			{
				return 'repeat-y';
			}
			if( $width < 30 && $height < 100 )
			{
				return 'repeat-x';
			}
			if( $width < 10 && $height < 10 )
			{
				return '';
			}
			return 'no-repeat';
		}
		return $this->bgRepeat;
	}
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

}
?>
