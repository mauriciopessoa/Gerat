<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este arquivo é parte do Framework Formdin.
 * 
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 * 
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

if ( !session_id() ) 
{
	session_start();
}
if( !defined('PASTA_BASE') )
{
	// permitir utilizar o arquivo de configuração config_sem_autenticar quando a variavel de sessão ACESSO_PUBLICO estiver true
	$arquivo = encontrarArquivoNivel('includes/config_sem_autenticar.inc',$nivel);
	if( $arquivo && isset($_SESSION['ACESSO_PUBLICO']) && $_SESSION['ACESSO_PUBLICO'] == true )  
	{
		include_once($arquivo);
	}
	else if( $arquivo = encontrarArquivoNivel('includes/config.inc',$nivel) ) 
	{
		include_once($arquivo);
	}
	else
	{
		echo 'Módulo conexao.inc. Arquivo config.inc não encontrado';
		return;
	}
}

if( $arquivo = encontrarArquivoNivel(PASTA_BASE.'classes/banco.inc',$nivel) )
{
	include_once($arquivo);
}
else
{
	print utf8_encode('Módulo base/includes/conexao.inc, arquivo banco.inc não encontrado.');
	return;
}
$clientedb = new banco();
$GLOBALS['conexao'] = $clientedb;

if( (isset($_REQUEST["modulo"]) && strtolower($_REQUEST["modulo"])=='limparcache'))
{
	$clientedb->limparCache();
	$_POST["modulo"]=null;
	$_GET["modulo"]=null;
	$_REQUEST["modulo"]=null;
	echo '<script>alert("Cache da classe banco foi limpo com SUCESSO!")</script>';
}
/**
* Recupera um pacote do Banco, deve ser usado caso tenha um pacote com uma função que retorne dados um ou mais cursores
*
* $porLinha - retorna o array de dados no formato $res[0]['NUM_PESSOA']=2, o padrão é $res['NUM_PESSOA'][0] = 2;
* $cursor_skip - quantidade de registros que devem ser ignorados a partir do primeiro registro
* $cursor_linhas - quantidade de linhas a serem retornadas
* 
* @param mixed $pacote
* @param array $bvars
* @param mixed $res
* @param mixed $tempo_cache
* @param mixed $porLinha
* @param mixed $cursor_skip
* @param mixed $cursor_linhas
*/
Function recuperarPacote($pacote,&$bvars,&$res,$tempo_cache=-1,$porLinha=null,$cursor_skip=null,$cursor_linhas=null){
	if(is_array($bvars) )
		$bvars=array_change_key_case($bvars, CASE_UPPER);
	$mens = $GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache,$porLinha,$cursor_skip,$cursor_linhas);
	if($bvars['CURSOR']) {
		$res = $bvars['CURSOR'];
	   if (count($res[key($res)])==0 ) {
		   $res=null;
		}
	}
	return $mens;
}
 
/*
Function recuperarPacote($pacote,&$bvars,&$res,$tempo_cache=-1){
	if(is_array($bvars) )
	$bvars=array_change_key_case($bvars, CASE_UPPER);
	$mens = $GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache);

	if($bvars['CURSOR']) {
		$res = $bvars['CURSOR'];
	   if (count($res[key($res)])==0 ) {
		   $res=null;
		}
	}
	return $mens;
}
*/
Function executarPacote($pacote,&$bvars,$tempo_cache=-1)
{
	if(is_array($bvars) )
		$bvars=array_change_key_case($bvars, CASE_UPPER);
	$mens=$GLOBALS['conexao']->executar_pacote_func_proc($pacote,$bvars,$tempo_cache);

	if ( !$mens )
		$GLOBALS['conexao']->commit();
	else
		$GLOBALS['conexao']->rollback();
	return $mens;
}

function encontrarArquivo($arquivo) {
    for( $i=0;$i<10;$i++) {
        $path = str_repeat('../',$i);
        if( file_exists($path.$arquivo ) ) {
        	return $path.$arquivo;
        	break;
            }
        }
    return null;
}

function encontrarArquivoNivel($arquivo,&$i) {
    for( $i=0;$i<10;$i++) {
        $path = str_repeat('../',$i);
        if( file_exists($path.$arquivo ) ) {
        	return $path.$arquivo;
        	break;
            }
        }
    return null;
}
?>

