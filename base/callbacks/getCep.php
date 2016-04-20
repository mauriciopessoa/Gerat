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

/*
M�dulo utilizado para preenchimento dos campos de endere�o utilizando consulta do cep, via
ajax, ao servi�o www.bucacep.com.br
Data:22-03-2010
Teste: cep=74265010
*/
error_reporting(0);
/*
//Utilizando o servi�o: http://viavirtual.com.br/webservicecep.php
$consulta = 'http://viavirtual.com.br/webservicecep.php?cep='.$_GET['cep'];
$consulta = file($consulta);
$consulta = explode('||',$consulta[0]);
$rua		=$consulta[0];
$bairro		=$consulta[1];
$cidade		=$consulta[2];
$uf			=$consulta[4];
//print_r($consulta);
print '{"rua":"'.$rua.'","bairro":"'.$bairro.'","cidade":"'.$cidade.'","uf":"'.$uf.'"}';
// java script para tratar o retorno
function getCep()
{
	var cep = jQuery('#num_cep').val();
	cep = cep.replace(/[^0-9]/g,'')
	if( cep )
	{
		fwSetEstilo('{"id":"num_cep","backgroundImage":"url(\''+pastaBase+'imagens/carregando.gif\')","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
		jQuery.get(app_url+"base/callbacks/getCep.php", {"cep":cep},
		function(data)
		{
			if( data )
			{
				fwSetEstilo('{"id":"num_cep","backgroundImage":"","backgroundRepeat":"no-repeat","backgroundPosition":"center right"}');
				eval("var dados = "+data);
   				jQuery('#des_endereco').val(dados.rua);
   				jQuery('#nom_cidade').val(dados.cidade);
   				jQuery('#nom_bairro').val(dados.bairro);
   				jQuery('#sig_uf').val(dados.uf);
			}
 		});
	}
}
*/
// chamada ajax
if(isset($_REQUEST['cep']))
{

	$cep = preg_replace('/[^0-9]/','',$_REQUEST['cep']);
	header ("content-type: text/xml; charset=ISO-8859-1");
	if( function_exists('curl_init'))
	{

	    // utilizando curl()
		$options = array(
			CURLOPT_RETURNTRANSFER => true, // return web page
			CURLOPT_HEADER => false, // don�t return headers
			CURLOPT_FOLLOWLOCATION => true, // follow redirects
			CURLOPT_ENCODING => '', // handle all encodings
			CURLOPT_USERAGENT => 'formdin', // who am i
			CURLOPT_AUTOREFERER => true, // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
			CURLOPT_TIMEOUT => 120, // timeout on response
			CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
		);
		$ch = curl_init('http://www.buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=1vVU3UcKFHfVhFxBSlWWM4kqUREbBu/');
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		if( !$errmsg = curl_error( $ch ) )
		{
			echo utf8_decode($content);
		}
		else
		{
			echo '<?xml version="1.0" encoding="utf-8" ?><webservicecep><quantidade>1</quantidade><retorno><resultado>-7</resultado><resultado_txt>'.$errmsg.'</resultado_txt><codigo_ibge></codigo_ibge></retorno></webservicecep>';
		}
		curl_close( $ch );
		return;
		//$err = curl_errno( $ch );
		//$errmsg = curl_error( $ch );
		//$header = curl_getinfo( $ch );
	}
	else
	{
		/**
		* utilizando file_get_contents()
		* n�o vai funcionar se a op��o URL file-access estiver desabilitada no servidor.
		*/
		$cep = ereg_replace('[^0-9]','',$_POST['cep']);
		header ("content-type: text/xml; charset=UTF-8");
		header("Content-Type:text/xml");
		//echo file_get_contents('http://www.buscarcep.com.br/?chave=1N4geWh.fwv1HeoCFNpBMsG1Cn1Gxf0&cep='.$cep.'&formato=xml');
		$res = file_get_contents('http://www.buscarcep.com.br/?cep='.$cep.'&formato=xml&chave=1vVU3UcKFHfVhFxBSlWWM4kqUREbBu/');
		echo utf8_decode($res);
	}




	/*
	// exemplo do retorno fixo para testar a chamada
	echo utf8_encode('<?xml version="1.0" encoding="utf-8" ?>
		<webservicecep>
			<quantidade>1</quantidade>
			<retorno>]
				<cep>71505030</cep>
				<uf>DF</uf>
				<cidade>Lago Norte</cidade>
				<bairro>Setor de Habita��es Individuais Norte</bairro>
				<tipo_logradouro>Conjunto</tipo_logradouro>
				<logradouro>SHIN QI 1  3</logradouro>
				<data>2010-06-12 00:18:12</data>
				<resultado>1</resultado>
				<resultado_txt>sucesso. cep encontrado local</resultado_txt>
				<limite_buscas>10</limite_buscas>
			</retorno>
		</webservicecep>');
	*/
	//$_SERVER['SERVER_ADDR']
	//echo file_get_contents('http://www.buscarcep.com.br/?chave=1N4geWh.fwv1HeoCFNpBMsG1Cn1Gxf0&cep='.$cep.'&formato=xml');
	return;
}
?>