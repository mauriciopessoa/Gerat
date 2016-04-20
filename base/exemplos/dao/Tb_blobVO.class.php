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

class Tb_blobVO
{
	private $id_blob = null;
	private $nome_arquivo = null;
	private $conteudo_arquivo = null;
	private $tempName = null;

	public function Tb_blobVO( $id_blob=null, $nome_arquivo=null, $conteudo_arquivo=null )
	{
		$this->setId_blob( $id_blob );
		$this->setNome_arquivo( $nome_arquivo );
		$this->setConteudo_arquivo( $conteudo_arquivo );
	}
	//--------------------------------------------------------------------------------
	function setId_blob( $strNewValue = null )
	{
		$this->id_blob = $strNewValue;
	}
	function getId_blob()
	{
		return $this->id_blob;
	}
	//--------------------------------------------------------------------------------
	function setNome_arquivo( $strNewValue = null )
	{
		$this->nome_arquivo = $strNewValue;
	}
	function getNome_arquivo()
	{
		return $this->nome_arquivo;
	}
	//--------------------------------------------------------------------------------
	function setConteudo_arquivo( $strNewValue = null )
	{
		$this->conteudo_arquivo = $strNewValue;
	}
	function getConteudo_arquivo()
	{
		return $this->conteudo_arquivo;
	}
	//--------------------------------------------------------------------------------
	function setTempName($strNewValue=null)
	{
		$this->tempName = $strNewValue;
	}
	function getTempName()
	{
		return $this->tempName;
	}
	//--------------------------------------------------------------------------------
}
?>