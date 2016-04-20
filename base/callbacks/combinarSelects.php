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

ini_set('default_charset','iso-8859-1');
/*session_start();
error_reporting(0);
include("../../includes/config.inc");
include("../includes/conexao.inc");
*/

if( $_REQUEST['fwDebug']==1)
{
	print_r( $_REQUEST );
	die();
}

// executar pacote
$bvars=array(strtoupper($_REQUEST['colunaFiltro'])=>$_REQUEST['valorFiltro']);
// where que podera se utilizado no comando select se n�o tiver sido informado o nome de um pacote
$where		= strtoupper($_REQUEST['colunaFiltro'])."='".$_REQUEST['valorFiltro']."'";
if((string)$_REQUEST['campoFormFiltro']<>'')
{
	$aCampos 	= explode('|',$_REQUEST['campoFormFiltro']);
	$aValores 	= explode('|',$_REQUEST['campoFormFiltroValor']);
	foreach($aCampos as $k=>$v)
	{
		if((string)$aValores[$k]<>'')
		{
			$bvars[$v]=$aValores[$k];
			$where.=' and '.$v."='".$aValores[$k]."'";
		}
	}
}
if( $_REQUEST['fwSession_expired'] && $_REQUEST['fwSession_expired'] == true )
{
	 echo '{"fwSession_expired":"1"}';
	 die();
}

$campoCodigo  	= strtoupper($_REQUEST['colunaCodigo']);
$campoDescricao = strtoupper($_REQUEST['colunaDescricao']);
$retorno='{"campo":"'.$_REQUEST['campoSelect'].
			'","selectPai":"'.utf8_decode($_REQUEST['selectPai']).
			'","valorInicial":"'.utf8_decode($_REQUEST['valorInicial']).
			'","selectFilhoStatus":"'.$_REQUEST['selectFilhoStatus'].
			'","descPrimeiraOpcao":"'.utf8_decode($_REQUEST['descPrimeiraOpcao']).
			'","valorPrimeiraOpcao":"'.utf8_decode($_REQUEST['valorPrimeiraOpcao']).
			'","funcaoExecutar":"'.$_REQUEST['funcaoExecutar'].
			'","selectUniqueOption":"'.$_REQUEST['selectUniqueOption'].
			'","descNenhumaOpcao":"'.utf8_decode($_REQUEST['descNenhumaOpcao']).'"';
// executar pacote
$pacoteCache = explode('|',$_REQUEST['pacoteOracle']);
if (!isset($pacoteCache[1]))
{
	$pacoteCache[1] = NULL;
}
//if(strpos($pacoteCache[0],'.PKG')>0)
if( preg_match('/\.PK\a?/i',$pacoteCache[0]) > 0 )
{
	if( $erro = recuperarPacote($pacoteCache[0],$bvars,$res,$pacoteCache[1]))
	{
		/*$banco = new banco();
		$bvars = array('COD_UF'=>53);
		$erro = $banco->executar_pacote_func_proc($pacoteCache[0],$bvars,0);
		$res = $bvars['CURSOR'];
		if( $res )
			print "alert('sim')";
		else
		   print "alert('{$erro[0]}')";
		return;
		*/
		print "alert('Erro na fun��o combinarSelect().\\n".$erro[0]."')";
		return;
	}
}
else
{
	$sql = 'select '.$campoCodigo.','.$campoDescricao.' from '.$pacoteCache[0];
	if($where != "")
	{
		$sql .= " where ".$where;
	}
	$sql .= " order by ".$campoDescricao;

	if( $_REQUEST['fwDebug'] == '1' || $_REQUEST['fwDebug'] == '2' )
	{

		//echo 'Comando SQL:<br>';
		//echo $sql;
		$sql = 'select COD_MUNICIPIO, NOM_MUNICIPIO from municipio where cod_uf = 53 order by nom_municipio';
	}

    if( !class_exists('TPDOConnection') || !TPDOConnection::getInstance() )
    {
		$bvars=null;
		$res=null;
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = $sql;
		if( $erro = $GLOBALS['conexao']->executar_recuperar($sql,$bvars,$res,$nrows,(int)$pacoteCache[1]))
		{
			if( preg_match('/falha/i',$erro ) > 0 )
			{
				$res[$campoCodigo][] = 0;
				$res[$campoDescricao][] = "Erro na funcao combinarSelect(). Erro:".$erro;
			}
		}
	}
	else
	{
		$res = TPDOConnection::executeSql($sql);
		if( TPDOConnection::getError() )
		{
			$res[$campoCodigo][] = 0;
			$res[$campoDescricao][] = "Erro na funcao combinarselect(). Erro:".TPDOConnection::getError();
		}
	}
}

if( $_REQUEST['fwDebug'] == 3)
{
	echo 'Resultado consulta:<br>';
	print_r($res);
	die('<hr>fim debug');
}

if($res)
{
	/**
	* remover retorno de linha
	*/
	foreach( $res[$campoDescricao] as $k=>$v)
	{
		$res[$campoDescricao][$k] = preg_replace('/'.chr(13).'/',' ',$res[$campoDescricao][$k]);
		$res[$campoDescricao][$k] = preg_replace('/'.chr(10).'/',' ',$res[$campoDescricao][$k]);
		$res[$campoDescricao][$k] = preg_replace('/  /',' ',$res[$campoDescricao][$k]);
	}

	if( !array_key_exists($campoCodigo,$res))
	{
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = "1) Erro nos parametros da funcao combinarSelect(). A coluna ".$campoCodigo." nao existe no retorno do banco";
		//print "alert('Erro nos parametros da fun��o combinarSelect().\\nA coluna ".$campoCodigo." n�o existe no retorno da fun��o \\n".$_REQUEST['pacoteOracle']."')";
		//return;
	}
	else if( !array_key_exists($campoDescricao,$res))
	{
		$res[$campoCodigo][] = 0;
		$res[$campoDescricao][] = "2) Erro nos parametros da funcao combinarSelect(). A coluna ".$campoDescricao." nao existe no retorno do banco";
		//	print "alert('Erro nos parametros da fun��o combinarSelect().\\nA coluna ".$campoDescricao." n�o existe no retorno da fun��o \\n".$_REQUEST['pacoteOracle']."')";
		//	return;
	}
	if($res){
		$retorno.=',"dados":{';
		foreach($res[$campoCodigo] as $k=>$v)
		{
			$retorno .= ($k>0) ? ',' : '';
			//$retorno.='"'.$v.'":"'.str_replace("'",'�',str_replace('"','�',$res[$campoDescricao][$k]) ).'"';
			$retorno.='"'.$v.'":"'.htmlspecialchars(str_replace('"','�',$res[$campoDescricao][$k])).'"';
		}
		//$retorno.='"where":"'.$where.'"';
		$retorno.="}";
	}
}
$retorno .= ($retorno == '') ? '' : '}';
echo $retorno;