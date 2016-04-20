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
* M�dulo para executar um comando sql e retornar os dados no formato json
* Dever ser chamado pelo index.php para que a conex�o com o banco de dados seja estabelecida
*
* @example http://localhost/sistemas/sisteste/index.php?modulo=base/callbacks/sql2json.php&ajax=1&table=BIOMA&columns=COD_BIOMA,NOM_BIOMA
*
* @param string ajax 		- deve ser informado o valor 1 sempre
* @param string table 		- deve ser informado o nome da tabela ou do esquema.pacote.funcao.
* @param string columns 	- nome das colunas que dever�o ser retornadas. Padr�o � *
* @param string where 		- string no formato json. Ex:{"NUM_CPF":"12345678909"} (Opcional)
* @param string orderBy 	- nome das colunas para ordenar os dados. (Opcional)
* @param integer cacheTime 	- tempo de cache dos dados (Opcional)
* @param integer debug 		- se 1, retorna os parametros recebidos para depura��o (Opcional)
*/
error_reporting(0);
//sleep(2);
if( $_REQUEST['debug'] )
{
	foreach($_REQUEST as $k=>$v)
	{
		$res['PARAMETRO'][] = $k;
		$res['VALOR'][] 	= $k.': '.$v;
	}
	echo json_encode($res);
	return;
}
$table 		= $_REQUEST['table'];
$cacheTime 	= $_REQUEST['cacheTime'];
$isPackage 	= preg_match('/\.PK\a?/i',strtoupper($table)) > 0;
$aConditions = json_decode($_REQUEST['where'],true);
$bvars		 = null;
$res		 = null;
$where		 = '';
if( is_array( $aConditions) )
{
	foreach($aConditions as $k=>$v)
	{
		if( $isPackage )
		{
			$bvars[strtoupper($k)]=$v;
		}
		else
		{
			$where .= ( ( $where=='' )  ? '' : ' and ' );
			$where .="({$k}='{$v}')";
		}
	}
}
// recuperar os dados do banco de dados
if( $isPackage )
{
	if( $erro = $GLOBALS['conexao']->executar_recuperar_pkg_funcao($table,$bvars,$res))
	{
		if( is_array($erro))
		{
			$res['PARAMETRO'][] = 0;
			$res['VALOR'][] 	= 'Erro: '.utf8_encode($erro[0]);
			echo json_encode($res);
			return;
		}
	}
}
else
{

	$_REQUEST['columns'] = $_REQUEST['columns'] ? $_REQUEST['columns'] : '*';
	$sql = "select {$_REQUEST['columns']} from {$table}";
	if( $where )
	{
		$sql.=' where '.$where;
	}
	if( $_REQUEST['orderBy'])
	{
		$sql.=' order by '.$_REQUEST['orderBy'];
	}
	if( class_exists('TPDOConnection') && TPDOConnection::getInstance())
	{

		$res=null;
		//$res['PARAMETRO'][] = 1;
		//$res['VALOR'][] 	= $sql;
		//echo json_encode($res);
		//return;
		$res = TPDOConnection::executeSql($sql);
		if( TPDOConnection::getError())
		{
			$res=null;
			$res['COD_ERRO'][0] = 0;
			$res['DES_ERRO'][0] = TPDOConnection::getError();
		};
	}
	else
	{
		$bvars	= null;
		$nrows	= 0;
		$mens 	= $GLOBALS['conexao']->executar_recuperar($sql,$bvars,$res,$nrows);
		if( $mens )
		{
			$res=null;
			$res['COD_ERRO'][0] = 0;
			$res['DES_ERRO'][0] = utf8_encode(print_r($mens,true));
			$res['COD_ERRO'][1] = 1;
			$res['DES_ERRO'][1] = $sql;
			echo json_encode($res);
			return;
		}
	}
}
// codificar em utf8 os dados do array
$res = is_array($res) ? $res : array();
if( count($res) > 0 )
{
	foreach ( $res as $k0=>$v )
	{
		foreach ( $v as $k1=>$dado )
	 	{
			if ( is_string($res[$k0][$k1]) )
			{
				$res[$k0][$k1] = utf8_encode($res[$k0][$k1]);
			}
		}
	}
}
// transformar o array no formato json;
echo json_encode($res);
?>
