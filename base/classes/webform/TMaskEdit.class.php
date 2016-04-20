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
*  Classe base para cria��o de inputs de texto com mascara de edi��o
*/
class TMaskEdit extends TEdit
{
	private $mask;
	public function __construct($strName,$strValue=null,$strMask=null,$boolRequired=null)
	{
		parent::__construct($strName,$strValue,null,$boolRequired);
		$this->setMask($strMask);
	}
	//-------------------------------------------------------------------------------------
	public function setMask($strNewMask=null)
	{
		$this->mask=(string)$strNewMask;
		$len = strlen($this->mask);
		parent::setMaxLenght($len);
	}
	//-------------------------------------------------------------------------------------
	public function getMask()
	{
		return $this->mask;
	}
	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		if( (string) $this->getMask()!='')
		{
			//$this->setEvent('onKeyUp','fwColocarMascara(this,"'.$this->getMask().'",event)');
			$this->addEvent('onFocus','MaskInput(this,"'.$this->getMask().'")');
			// retirar a borda vermelha se o campo tiver sido validado errado
		}
		return parent::show($print);
	}
}
/*
return;
$campo = new TMaskEdit('teste','123456789','9.9.9.9.9.9.9.9.9',true);
$campo->show();
*/
/*
$cpf = new TCpfField('num_cpf','CPF:',true);
$cpf->show();
$cnpj = new TCnpjField('num_cnpj','CNPJ:',true);
$cnpj->show();
*/

?>