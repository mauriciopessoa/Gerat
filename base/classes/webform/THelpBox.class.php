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
* Classe para implementa��o de caixas on-line de apresenta��o de texto e im�gem
*
* <code>
* $frm->addBoxField('campo_1','Informe o nome completo',$this->getBase().'imagens/folder.gif',null,null,null,null,null,null,'Ajuda');
* $frm->addBoxField('campo_2',null,$this->getBase().'exemplos/ajuda.html','ajax',null,null,null,null,null,'Ver arquivo de ajuda');
* $frm->addBoxField('campo_3','Este � o texto de ajuda que ser� exibido quando o usu�rio clicar na imagem',null,null,null,null,null,null,null,'Exibir ajuda');
* $frm->addBoxField('campo_y',null,$this->getBase()."js/jquery/facebox/stairs.jpg",'jpg','Visualizar Foto:','folder.gif',true,null,null,'Imagem');
* </code>
*/
class THelpBox extends TControl
{
	private $image;
	private $fileName;
	private $dataType; // image, ajax
	public function __construct($strName, $strValue=null, $strFileName=null, $strDataType=null, $strImage=null,$strHint=null)
	{
		parent::__construct('div',$strName,$strValue);
		$this->setFieldType('helpbox');
		$this->setHint($strHint);
		$this->setFileName($strFileName);
		$this->setDataType($strDataType);
		$this->setImage($strImage);
	}
	//--------------------------------------------------------------------
	public function show($print=true)
	{
		$this->clearChildren();

		$this->add($this->getValue());
		$this->setValue(null);
		return parent::show($print);
	}
	//----------------------------------------------------------------------
	public function getValue()
	{
		$e = new TButton('btn_help_box_'.$this->getId());
		$e->setImage($this->image);
		$value = $this->value;
		$isImage=false;
		// verificar so texto ou o nome do arquivo � uma imagem
		if( preg_match('/\.(jpe?g|gif|bmp|png)$/i',$value.$this->getFileName()))
		{
			$isImage=true;
			$this->setDataType('image');
		}
		if( $this->getFileName())
		{
			$value=$this->getFileName();
			$this->setValue('');
			if(!$this->getDataType())
			{
				$this->setDataType('ajax');
			}
		}
		/*
		if($this->getDataType())
		{
			$value = '{"'.$this->getDataType().'":"'.$value.'"}';
		}
		else
		{
			$value ="'".$value."'";
		}
		*/
		//$value = preg_replace("/".chr(10)."/",'',$value);
		$value = str_replace( chr(10),'<br\>' ,$value );
		if( $this->getDataType() == 'ajax')
		{
			$e->setOnClick('fwFaceBox("'.$value.'",true)');
		}
		else
		{
			if( $isImage )
			{
				$e->setOnClick('fwFaceBox("'.$value.'",true)');
			}
			else
			{
				$e->setOnClick('fwFaceBox("'.$value.'",false)');
			}
		}
		return $e;
	}
	public function setImage($strImage=null)
	{
		$strImage = is_Null($strImage) ? 'icon_help-16x16.png' : $strImage;
		$this->image = $strImage;
	}
	public function getImage($strImage=null)
	{
		return $this->image;
	}
	public function setDataType($strNewValue=null)
	{
		$this->dataType = $strNewValue;
	}
	public function getDataType()
	{
		return $this->dataType;
	}
	public function setFileName($strFileName=null)
	{
		$this->fileName = $strFileName;
		if( $this->fileName)
		{
			if( !$this->getHint())
			{
				$this->setHint( parent::getValue() );
			}
			$this->setValue('');
		}
	}
	public function getFileName()
	{
		return $this->fileName;
	}

}
//$val = new THelpBox('hlpTeste','Ajuda texto de exemplo');
//$val->show();
?>