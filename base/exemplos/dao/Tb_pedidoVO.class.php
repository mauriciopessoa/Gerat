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

class Tb_pedidoVO
{
	private $id_pedido = null;
	private $data_pedido = null;
	private $nome_comprador = null;
	private $forma_pagamento = null;
	public function Tb_pedidoVO( $id_pedido=null, $data_pedido=null, $nome_comprador=null, $forma_pagamento=null )
	{
		$this->setId_pedido( $id_pedido );
		$this->setData_pedido( $data_pedido );
		$this->setNome_comprador( $nome_comprador );
		$this->setForma_pagamento( $forma_pagamento );
	}
	//--------------------------------------------------------------------------------
	function setId_pedido( $strNewValue = null )
	{
		$this->id_pedido = $strNewValue;
	}
	function getId_pedido()
	{
		return $this->id_pedido;
	}
	//--------------------------------------------------------------------------------
	function setData_pedido( $strNewValue = null )
	{
		$this->data_pedido = $strNewValue;
	}
	function getData_pedido()
	{
		return is_null( $this->data_pedido ) ? date( 'Y-m-d' ) : $this->data_pedido;
	}
	//--------------------------------------------------------------------------------
	function setNome_comprador( $strNewValue = null )
	{
		$this->nome_comprador = $strNewValue;
	}
	function getNome_comprador()
	{
		return $this->nome_comprador;
	}
	//--------------------------------------------------------------------------------
	function setForma_pagamento( $strNewValue = null )
	{
		$this->forma_pagamento = $strNewValue;
	}
	function getForma_pagamento()
	{
		return $this->forma_pagamento;
	}
	//--------------------------------------------------------------------------------
}
?>