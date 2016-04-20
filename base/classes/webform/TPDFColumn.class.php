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

class TPDFColumn
{
	private $header;
	private $width;
	private $align;
	private $fieldName;
	private $fontColor;
	private $fontStyle;
	private $fontSize;
	private $fontFamily;
	private $fillColor;
	public function __construct( $strHeader=null,$intWidth=null,$strAlign=null, $strFieldName=null, $hexFillColor=null, $strFontStyle=null, $intFontSize=null,$hexFontColor=null, $strFontFamily=null)
	{
		$this->setHeader($strHeader);
		$this->setWidth($intWidth);
		$this->setAlign($strAlign);
		$this->setFieldName($strFieldName);
		$this->setFillColor($hexFillColor);
		$this->setFontStyle($strFontStyle);
		$this->setFontColor($hexFontColor);
		$this->setFontFamily($strFontFamily);
		$this->setFontSize($intFontSize);
	}
	public function setHeader($strNewValue=null)
	{
		$this->header = $strNewValue;
		return $this;
	}
	public function getHeader()
	{
		return $this->header;
	}

	public function setWidth($intNewValue=null)
	{
		$this->width = $intNewValue;
		return $this;
	}
	public function getWidth()
	{
		return $this->width;
	}

	public function setAlign($strNewValue=null)
	{
		$this->align = $strNewValue;
		return $this;
	}
	public function getAlign()
	{
		return is_null($this->align) ? 'L' : strtoupper($this->align);
	}

	public function setFieldName($strNewValue=null)
	{
		$this->fieldName = $strNewValue;
		return $this;
	}
	public function getFieldName()
	{
		return $this->fieldName;
	}

	public function setFontColor($strHexColor=null)
	{
		$this->fontColor = $strHexColor;
		return $this;
	}
	public function getFontColor()
	{
		return is_null($this->fontColor) ? 0 : $this->fontColor; // preta
	}

	public function setFillColor($hexFillColor=null)
	{
		$this->fillColor = ( $hexFillColor == '' ) ? null : $hexFillColor;
		return $this;
	}
	public function getFillColor()
	{
		return is_null($this->fillColor) ? 255 : $this->fillColor; // branca
	}

	public function setFontStyle($strNewValue=null)
	{
		$this->fontStyle = $strNewValue;
		return $this;
	}
	public function getFontStyle( $currentFontStyle=null )
	{
		return is_null( $this->fontStyle ) ? $currentFontStyle : $this->fontStyle;
	}
	public function setFontSize($intNewValue=null)
	{
		$this->fontSize = $intNewValue;
		return $this;
	}
	public function getFontSize($currentValue=null)
	{
		return is_null($this->fontSize) ? $currentValue : $this->fontSize;
	}
	public function setFontFamily($strNewValue=null)
	{
		$this->fontFamily = $strNewValue;
	}
	public function getFontFamily($currentValue=null)
	{
		return is_null($this->fontFamily) ? $currentValue : $this->fontFamily;
	}

}
?>