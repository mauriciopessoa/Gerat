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

class TbTesteDAO extends TPDOConnection
{
	public function tbTesteDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( TbTesteVO $objVo )
	{
		if( $objVo->getId() )
		{
			return $this->update($objVo);
		}
		$values = array(  $objVo->getNome_teste() 
						, $objVo->getData_teste() 
						, $objVo->getNumero_teste() 
						);
		return self::executeSql('insert into tbTeste(
								 nome_teste
								,data_teste
								,numero_teste
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tbTeste where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id
								,nome_teste
								,data_teste
								,numero_teste
								from tbTeste where id = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id
								,nome_teste
								,data_teste
								,numero_teste
								from tbTeste'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( TbTesteVO $objVo )
	{
		$values = array( $objVo->getNome_teste()
						,$objVo->getData_teste()
						,$objVo->getNumero_teste()
						,$objVo->getId() );
		return self::executeSql('update tbTeste set 
								 nome_teste = ?
								,data_teste = ?
								,numero_teste = ?
								where id = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>
