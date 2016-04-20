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


session_start();

if ( isset($_SESSION['ACESSO_PUBLICO']) && $_SESSION['ACESSO_PUBLICO'] == true )
{
	include("../../includes/config_sem_autenticar.inc");
}
else
{
	include("../../includes/config.inc");
}
include("conexao.inc");

$acao = $_REQUEST['acao'];
switch( strtoupper( $acao ) )
{
	case 'UF_MUNICIPIO':
		$_POST['colunaFiltro']			= 'COD_UF';
		$_POST['pacoteOracle']			= 'SIGER.PKG_GERAL.SEL_MUNICIPIO';
		$_POST['colunaCodigo']			= 'COD_MUNICIPIO';
		$_POST['colunaDescricao']		= 'NOM_MUNICIPIO';
		$_POST['descPrimeiraOpcao']	= '-- selecione --';
		$_POST['valorPrimeiraOpcao']	= '';
		$_POST['descNenhumaOpcao']		= '-- vazio --';
	break;
	case 'MUNICIPIO_BIOMA':
		$_POST['colunaFiltro']			= 'COD_MUNICIPIO';
		$_POST['pacoteOracle']			= 'SIGER.PKG_TIPO_BIOMA.SEL_BIOMA_UF';
		$_POST['colunaCodigo']			= 'SEQ_TIPO_BIOMA_UF';
		$_POST['colunaDescricao']		= 'DES_TIPO_BIOMA';
		$_POST['descPrimeiraOpcao']	= '-- selecione --';
		$_POST['valorPrimeiraOpcao']	= '';
		$_POST['descNenhumaOpcao']		= '-- vazio --';
	break;
}

// executar pacote
$bvars=array(strtoupper($_POST['colunaFiltro'])=>$_POST['valorFiltro']);
if((string)$_POST['campoFormFiltro']<>'')
{
	$aCampos 	= explode('|',$_POST['campoFormFiltro']);
	$aValores 	= explode('|',$_POST['campoFormFiltroValor']);
	foreach($aCampos as $k=>$v)
	{
		if((string)$aValores[$k]<>'')
		{
			$bvars[$v]=$aValores[$k];
		}
	}
}
// executar pacote
$pacoteCache = explode('|',$_POST['pacoteOracle']);
if (!isset($pacoteCache[1]))
{
	$pacoteCache[1] = NULL;
}
if( $erro = recuperarPacote($pacoteCache[0],$bvars,$res,$pacoteCache[1]))
{
	print "alert('Erro na fun��o combinarSelect().\\n".$erro[0]."')";
	return;
}
$campoCodigo 	 = strtoupper($_POST['colunaCodigo']);
$campoDescricao = strtoupper($_POST['colunaDescricao']);
$retorno='{"campo":"'.$_POST['campoSelect'].
			'","valorInicial":"'.$_POST['valorInicial'].
			'","selectFilhoStatus":"'.$_POST['selectFilhoStatus'].
			'","descPrimeiraOpcao":"'.$_POST['descPrimeiraOpcao'].
			'","valorPrimeiraOpcao":"'.$_POST['valorPrimeiraOpcao'].
			'","descNenhumaOpcao":"'.$_POST['descNenhumaOpcao'].'"';

if($res)
{
	if( !array_key_exists($campoCodigo,$res))
	{
		print "alert('Erro nos parametros da fun��o combinarSelect().\\nA coluna ".$campoCodigo." n�o existe no retorno da fun��o \\n".$_POST['pacoteOracle']."')";
		return;
	}
	else if( !array_key_exists($campoDescricao,$res))
	{
		print "alert('Erro nos parametros da fun��o combinarSelect().\\nA coluna ".$campoDescricao." n�o existe no retorno da fun��o \\n".$_POST['pacoteOracle']."')";
		return;
	}
	if($res){
		$retorno.=',"dados":{';
		foreach($res[$campoCodigo] as $k=>$v)
		{
			$retorno .= ($k>0) ? ',' : '';
			$retorno.='"'.$v.'":"'.str_replace('"','�',$res[$campoDescricao][$k]).'"';
		}
		$retorno.="}";
	}
}
$retorno .= ($retorno == '') ? '' : '}';
print $retorno;
?>


