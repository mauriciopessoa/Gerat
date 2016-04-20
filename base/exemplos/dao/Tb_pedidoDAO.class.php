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

class Tb_pedidoDAO extends TPDOConnection
{
	public function tb_pedidoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( Tb_pedidoVO $objVo )
	{

		if( $objVo->getId_pedido() != 'Novo' )
		{
			return self::update($objVo);
		}
		$values = array( $objVo->getData_pedido()
						, $objVo->getNome_comprador()
						, $objVo->getForma_pagamento()
						);
		self::executeSql('insert into tb_pedido(
								 data_pedido
								,nome_comprador
								,forma_pagamento
								) values (?,?,?)', $values );
		return  self::executeSql('select last_insert_rowid() as ID_PEDIDO');
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_pedido where id_pedido = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_pedido
								,data_pedido
								,nome_comprador
								,forma_pagamento
								from tb_pedido where id_pedido = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_pedido
								,data_pedido
								,nome_comprador
								,forma_pagamento
								from tb_pedido'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( Tb_pedidoVO $objVo )
	{
		$values = array( $objVo->getData_pedido()
						,$objVo->getnome_comprador()
						,$objVo->getForma_pagamento()
						,$objVo->getId_pedido() );
		return self::executeSql('update tb_pedido set
								 data_pedido = ?
								,nome_comprador = ?
								,forma_pagamento = ?
								where id_pedido = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>