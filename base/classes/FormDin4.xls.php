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
error_reporting(0);
//Incluir a classe excelwriter
include("excelwriter.inc.php");

// checkboxes marcados no gride ( quando existir )
if( isset( $_REQUEST['checkboxes'] ))
{
	$checkboxes = json_decode($_REQUEST['checkboxes']);
}
else
{
	$checkboxes = json_decode("{}");
}

// radiobuttons marcados no gride ( quando existir )
if( isset( $_REQUEST['radiobuttons'] ))
{
	$radiobuttons = json_decode($_REQUEST['radiobuttons']);
}
else
{
	$radiobuttons = json_decode("{}");
}
$grd = $_GET[ 'gride' ];
$e = new TElement( '' );
$dirBase = $e->getBase();
$tempFile = $dirBase . 'tmp/tmp_' .$grd .'_'.session_id().'.go';

$dadosGride = null;
$tituloGride = '';
if ( file_exists( $tempFile ) )
{
	$dadosGride = unserialize( file_get_contents( $tempFile ) );
	$tituloGride = $_REQUEST[ 'title' ];
}
else
{
	echo '<h2>Dados do gride n�o foram salvos em ' . $tempFile . '</h2>';
	die();
}

// nome temporario da planilha
$fileName = $dirBase . 'tmp/Planilha '.date('d-m-Y His').'.xls';
$excel=new ExcelWriter($fileName);
if($excel==false)
{
   die($excel->error);
}

// colunas
$keys = array_keys($dadosGride);

// escrever o titulo do gride
if( $tituloGride )
{
	$excel->writeRow();
	$excel->writeCol(htmlentities( $tituloGride,null,'ISO-8859-1' ),count($keys));
}

$count=0;
foreach( $_REQUEST as $k => $v )
{
	if ( preg_match( '/^w_/', $k ) )
	{
		if( $count == 0 )
		{
			$count++;
			$excel->writeRow();
			$excel->writeCol(htmlentities("Crit�rio(s) de Sele��o:",null,'ISO-8859-1'),count($keys));
		}
		$excel->writeLine(array( htmlentities( preg_replace( '/(w_|:)/', '', $k  ),null,'ISO-8859-1'  ),array( htmlentities( $v,null,'ISO-8859-1' ),(count($keys)-1) ) ) );
	}
}

// criar os titulos das colunas
$a=null;
foreach($keys as $v )
{
	$a[]  = htmlentities(utf8_decode($v),null,'ISO-8859-1');
}
$excel->writeLine($a );


foreach($dadosGride[$keys[0]] as $k => $v )
{
	$a=null;
	foreach($keys as $col => $v1 )
	{
		$isNumber = false;
		$x = prepareNumberPlanilha( $dadosGride[$v1][$k],$isNumber );

        if( isset( $checkboxes->$col ) && is_object( $checkboxes->$col ) )
		{
			if( in_array($k,$checkboxes->$col->dados ) )
			{
				$x = '[ X ]';
			}
			else
			{
				$x='';
			}
		}
        else if( isset( $radiobuttons->$col) && is_object( $radiobuttons->$col ) )
		{
			if( in_array($k,$radiobuttons->$col->dados ) )
			{
				$x = '[ X ]';
			}
			else
			{
				$x='';
			}
		}
		$a[]=$x;
	}
	$excel->writeLine($a);
}
//$excel->writeLine($a);
$excel->close();
//ob_clean();
//flush();

// Configura��es header para for�ar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"".basename($fileName)."\"" );
header ("Content-Description: PHP Generated Data" );
//echo "O arquivo foi salvo com sucesso. <a href=\"excel3.xls\">excel.xls</a>";
$handle = fopen( $fileName, 'rb' );
if( $handle )
{
	$buffer = '';
	while( !feof( $handle ) )
	{
		$buffer = fread( $handle, 4096 );
		echo $buffer;
		ob_flush();
		flush();
	}
	fclose ( $handle );
}
else
{
	readfile ( $fileName );
}
// fim
//---------------------------------------------------------------------------
function prepareNumberPlanilha( $v = null,&$isNumber )
{
	if ( !is_numeric( preg_replace( '/[,\.]/', '', $v ) ) )
	{
		return $v;
	}
	$isNumber = true;
	// alterar o ponto por virgula para ficar compativel com a planilha
	$posPonto = ( int ) strpos( $v, '.' );
	$posVirgula = ( int ) strpos( $v, ',' );

	if ( $posPonto && $posVirgula )
	{
		if ( $posVirgula > $posPonto )
		{
			$v = preg_replace( '/\./', '', $v );
		}
		else
		{
			$v = preg_replace( '/,/', '', $v );
			$v = preg_replace( '/\./', ',', $v );
		}
	}
	else if( $posPonto )
	{
		$v = preg_replace( '/\./', ',', $v );
	}
	if( defined('DECIMAL_SEPARATOR') )
	{
		$v = preg_replace('/,/',DECIMAL_SEPARATOR,$v);
	}
	return $v;
}
?>