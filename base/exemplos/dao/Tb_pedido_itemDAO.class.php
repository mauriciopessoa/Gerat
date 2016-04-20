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

class Tb_pedido_itemDAO extends TPDOConnection
{
	public function tb_pedido_itemDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( Tb_pedido_itemVO $objVo )
	{
		if( $objVo->getId_item() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getId_pedido()
						, $objVo->getProduto()
						, $objVo->getQuantidade()
						, $objVo->getPreco()
						);
		return self::executeSql('insert into tb_pedido_item(
								 id_pedido
								,produto
								,quantidade
								,preco
								) values (?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_pedido_item where id_item = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_item
								,id_pedido
								,produto
								,quantidade
								,preco
								from tb_pedido_item where id_item = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_item
								,id_pedido
								,produto
								,quantidade
								,preco
								from tb_pedido_item'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( Tb_pedido_itemVO $objVo )
	{
		$values = array( $objVo->getId_pedido()
						,$objVo->getProduto()
						,$objVo->getQuantidade()
						,$objVo->getPreco()
						,$objVo->getId_item() );
		return self::executeSql('update tb_pedido_item set
								 id_pedido = ?
								,produto = ?
								,quantidade = ?
								,preco = ?
								where id_item = ?',$values);
	}
	//--------------------------------------------------------------------------------
    public function select_itens_pedido($id_pedido = null)
	{
		$dados = self::executeSql('select id_item,produto,quantidade,preco,quantidade*preco as total from tb_pedido_item where id_pedido = ?',array($id_pedido) );
		return $dados;
	}
}