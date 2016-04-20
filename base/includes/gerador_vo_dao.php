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

$frm = new TForm('Gerador de Objeto VO e DAO',500,500);
$frm->addTextField('diretorio','Diret�rio:',50,true);
$frm->addTextField('tabela','Nome da Tabela:',30,true);
$frm->addTextField('coluna_chave','Nome da Coluna Chave:',30);
//$frm->addMemoField('sql','Sql tabelas:',5000,true,80,5);
$frm->addMemoField('colunas','Colunas:',5000,true,45,20);
$frm->setAction('Gerar');

if(!$frm->get('diretorio'))
{
	$frm->set('diretorio','dao/');
}

$acao = ( isset($acao) ) ? $acao : '';
switch( $acao )
{
	case 'Gerar':
		if( $frm->validate() )
		{
			$diretorio = str_replace('//','/',$frm->get('diretorio').'/');
			@mkdir($diretorio,"775",true);
			if( ! file_exists( $diretorio ) )
			{
				$frm->setMessage('Diret�rio '.$diretorio.' n�o existe!');
				break;
			}
			$txt = preg_replace('/'.chr(13).'/',',',$frm->get('colunas'));
			$txt = preg_replace('/'.chr(10).'/',',',$txt);
			$txt = preg_replace('/\,\,/',',',$txt);
			$txt = preg_replace('/ /','',$txt);
			$txt = preg_replace('/\,\,/',',',$txt);
			if( substr($txt,-1) ==',')
			{
				$txt=substr($txt,0,strlen($txt)-1);
			}
			$arr = explode(',',$txt);
			$coluna_chave = $frm->get('coluna_chave') ? $frm->get('coluna_chave') : $arr[0];
			//require_once('../base/classes/webform/TDAOCreate.class.php');
			$gerador = new TDAOCreate($frm->get('tabela'), $coluna_chave, $diretorio);
			foreach($arr as $k=>$v)
			{
				$gerador->addColumn($v);
			}
			$gerador->saveVO();
			$gerador->saveDAO();
			$frm->setMessage('Fim');
		}
	break;
}


/*
switch( $acao )
{
	case 'Validar':
		if( $frm->validate() )
		{
			if( ! file_exists( $frm->get( 'path' ) ) )
			{
				$frm->setMessage('Path informado n�o existe!');
				break;
			}
			//--------------------------------------------
			$res = TPDOConnection::executeSql($frm->get('sql'));
			if($res)
			{
				$g = new TGrid('gd1','Tabelas',$res);
				$col = key($res);
				$frm->addHiddenField('key',$col);
				$g->addCheckColumn($col,null,$col,$col);
				//$g->autoCreateColumns();
				$g->enableDefaultButtons(false);
				$frm->addHtmlField('gride',$g);
				$frm->setAction('Gerar');
			}
		}
	break;
	//----------------------------------------------------------------------------
	case 'Gerar':
		$key = $_POST['key'];
		if( count( $_POST[ $key ]) > 0  )
		{
			foreach($_POST[$key] as $k=>$v)
			{
				$sql = 'pragma table_info('.$v.')';
			}
		}
		break;
	//----------------------------------------------------------------------------
	//----------------------------------------------------------------------------
	//----------------------------------------------------------------------------

}
*/

//$frm->addSelectField('nom_tabela','Tabela:',null,getTabelas(),null,null,null,null,null,null,null,null,'TABELA','TABELA');
$frm->show();

//d(getTabelas());
//d(getPk('demanda'));
//d(getColNames('demanda'));

//tdb::sql();
//echo 'tipo:'.tdb::getDbType();


//--------------------------------------------------------------------------------------
// http://pt.wikibooks.org/wiki/PostgreSQL_Pr%C3%A1tico/Metadados

function getTabelas()
{
	tdb::sql();
	if( tdb::getDbType()=='postgres')
	{
		$dados = tdb::sql("SELECT schemaname AS esquema, tablename AS tabela, tableowner AS dono
						FROM pg_catalog.pg_tables
						WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
						ORDER BY schemaname, tablename");
		foreach($dados as $k=>$v)
		{
			foreach($v as $k1=>$v1 )
			{
				$res[mb_strtoupper($k1)][$k] = $v1;
			}
		}
		return $res;
	}
}
function getPk($strTableName=null)
{
	$dados = TDb::sql("SELECT ic.relname AS index_name, bc.relname AS tab_name, ta.attname AS column_name, i.indisunique AS unique_key, i.indisprimary AS primary_key
	FROM pg_class bc, pg_class ic, pg_index i, pg_attribute ta, pg_attribute ia WHERE bc.oid = i.indrelid AND ic.oid = i.indexrelid AND ia.attrelid = i.indexrelid
	AND ta.attrelid = bc.oid AND bc.relname = ? AND ta.attrelid = i.indrelid AND ta.attnum = i.indkey[ia.attnum-1]
	ORDER BY index_name, tab_name, column_name;",$strTableName);
	foreach($dados as $k=>$v)
	{
		foreach($v as $k1=>$v1 )
		{
			$res[mb_strtoupper($k1)][$k] = $v1;
		}
	}
	return $res;
}
function getColNames($strTableName=null)
{
	$dados = TDb::sql("SELECT attname as coluna FROM pg_class, pg_attribute, pg_type WHERE pg_attribute.attrelid = pg_class.oid  AND pg_attribute.atttypid = pg_type.oid and relname=? and attnum>0",$strTableName);
	foreach($dados as $k=>$v)
	{
		foreach($v as $k1=>$v1 )
		{
			$res[mb_strtoupper($k1)][$k] = $v1;
		}
	}
	return $res;

}
?>

