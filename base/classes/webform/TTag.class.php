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
* Campo tag para inser��o de tags no fluxo de cria��o dos campos
* Criado para atender a necessidade de centralizar um grupo de objetos na tela
* ou colocar obejetos dentro de uma div com cor de fundo alterado
* Ex:	$frm->addTag('<div>','div_teste');
*		$frm->addTag('</div>');
*/
class TTag extends THidden
{
	public function __construct($strTagType,$strId=null)
	{
   	 	$strTagType = str_replace('<','',$strTagType);
   	 	$strTagType = str_replace('>','',$strTagType);
   	 	if( $strId &&  strpos('<'.$strTagType,'</')===false && strpos(strtolower($strTagType),'id=')===false)
   	 	{
			$strTagType.=' id="'.$strId.'"';
   	 	}
   	 	$strTagType = '<'.$strTagType.'>';
		if( is_null($strId))
		{
   	 		$strId 	= 'tag_'.mt_rand(1, 1000);
		}
		parent::__construct($strId,(string)$strTagType,false);
		$this->clearCss();
		$this->setProperty('type','tag');
		$this->setFieldType('tag');
	}
}
?>