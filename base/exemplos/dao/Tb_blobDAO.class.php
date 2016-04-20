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

class Tb_blobDAO extends TPDOConnection
{
	public function tb_blobDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public function insert( Tb_blobVO $objVo )
	{
		if( $objVo->getId_blob() )
		{
			return self::update($objVo);
		}

        // para mysql
        //$values = array(  $objVo->getNome_arquivo(), file_get_contents($objVo->getTempName()) );
		//self::executeSql("insert into tb_blob (nome_arquivo,conteudo_arquivo) values (?,?)",$values);


		// para sqlite
       	$query = self::prepare("insert into tb_blob (nome_arquivo,conteudo_arquivo) values (?,?)");
		$query->bindParam(1, $objVo->getNome_arquivo()				, PDO::PARAM_STR);
		$query->bindParam(2, fopen( $objVo->getTempName(), "rb")	, PDO::PARAM_LOB);
		$query->execute();

	}
	//--------------------------------------------------------------------------------
	public function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from tb_blob where id_blob = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 id_blob
								,nome_arquivo
								,conteudo_arquivo
								from tb_blob where id_blob = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 id_blob
								,nome_arquivo
								from tb_blob'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public function update ( Tb_blobVO $objVo )
	{
		$values = array( $objVo->getNome_arquivo()
						,$objVo->getConteudo_arquivo()
						,$objVo->getId_blob() );
		return self::executeSql('update tb_blob set
								 nome_arquivo = ?
								,conteudo_arquivo = ?
								where id_blob = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>