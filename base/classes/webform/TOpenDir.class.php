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
* Classe base para sele��o de diret�rios
*/
class TOpenDir extends TEdit
{
	private $btnOpen;
	private $rootDir;
	private $title;
	private $callback;
	public function __construct($strName, $strRootDir=null, $strValue=null, $intMaxLength=null, $boolRequired=null, $intSize=null, $strTitle=null, $strJsCallBack=null )
	{
		$intSize = is_null($intSize) ? '60' : $intSize;
		$intMaxLength = is_null( $intMaxLength) ? $intSize : $intMaxLength;
		parent::__construct($strName, $strValue, $intMaxLength, $boolRequired, $intSize );
		$this->setFieldType('opendir');
		$strRootDir = is_null($strRootDir) ? './' : $strRootDir;
		$this->setHint('Selecionar - Clique duas vezes para abrir a caixa de dialogo!');
		$this->setReadOnly(true);
		$this->setRootDir($strRootDir);
		$this->btnOpen = new TButton('btn'.ucfirst($strName),'...',null,'evento',null,'folderOpen.gif','folderopen_desabilitado.gif','Selecionar pasta' );
	}
	public function show($print=true)
	{
		$btnClear = new TButton('btn'.ucfirst($this->getId()).'_clear', 'x', null, 'jQuery("#'.$this->getId().'").val("");',null,'borracha.gif' );
		$btnClear->setHint('Apagar');
		$btn = $this->getButton();
		$btn->setAction('');
        if( !$this->getEnabled())
        {
            $btn=null;
        }
        else
        {
            $btn->setEvent('onclick','fwOpenDir("'.$this->getId().'","'.$this->getRootDir().'","'.$this->getCallBack().'","'.$this->getTitle().'")');
    		$this->setEvent('ondblclick',$btn->getEvent('onclick'));
        }
		return parent::show($print).( ($btn) ? $btn->show($print).$btnClear->show(false):'');
	}
	public function getButton()
	{
		return $this->btnOpen;
	}
	public function setRootDir($strNewValue=null)
	{
		$this->rootDir = $strNewValue;
	}
	public function getRootDir()
	{
		return $this->rootDir;
	}
	public function setId($strNewValue=null)
	{
        parent::setId($strNewValue);
	}
	public function setTitle($strNewValue=null)
	{
		$this->title = $strNewValue;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setCallback($strNewValue=null)
	{
		$this->callback = $strNewValue;
	}
	public function getCallback()
	{
		return $this->callback;
	}
}
?>