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
ini_set('default_charset','iso-8859-1');
$app		= mb_strtolower($_REQUEST['aplicativo']);
$file 		= $_REQUEST['file'];
$readOnly 	= isset($_REQUEST['readonly']) ? $_REQUEST['readonly'] : false;
if(strpos('http',$file)===0)
{
	header('location:'.$file);
	die();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../js/jquery/jquery.js"></script>
<script type="text/javascript" src="../js/jquery/jquery.jeditable.mini.js"></script>
<script language="javascript" >
	jQuery(document).ready(
		function()
		{
			//site oficial: http://www.appelsiini.net/projects/jeditable
			jQuery('.editInPlace').editable('../../base/callbacks/helpOnLineSave.php',
			{
         		type		:'textarea',
         		submit  	:'Salvar',
         		cancel		:'Cancelar',
				cssclass	:'editable',
				indicator	:'<br><center>Gravando...<br><img src="../imagens/processando.gif"></center>'
				/*tooltip 	:'Clique aqui para editar o texto'*/
     		});
		}
	);
</script>
<style>
.editInPlace
{
	width:100%;
	height:80%;
	font-family: Arial;
	font-size: 12px;
	background-color: transparent;
}
.editable
{
	border:none;
	/*width:300px;
	height:150px;
	*/
}
</style>
</head>
<body>
<?php
/**
* se no nome do arquivo n�o tiver a extens�o .html, adicionar a extens�o .html e se o arquivo
* n�o existir criar um em branco
*/
if( preg_match('/\./',$file) == 0 )
{
	$file.='.html';
}

// se passar o nome do arquivo puro, procurar na pasta ajuda/
if( strpos( $file, '../' ) === false)
{
	//$dir = '../..'.( ($app) ? '/'.$app :'').'/ajuda/';
	$dir = ( ($app) ? $app.'/' :'').'ajuda/';
}
if( ! file_exists( $dir ) )
{
	print 'criar dir:'.$dir.'<br>';
	mkdir($dir,'0777',true);
}
if( !file_exists($dir))
{
	die( 'Diret�rio n�o encontrado: '.$dir);
}
$file = $dir . $file;
// abrir a div de edi��o
if( !$readOnly )
{
	print '<div class="editInPlace" id="'.$file.'">';
}

// criar o arquivo
if( ! file_exists($file) )
{
	file_put_contents($file,'');
}
if( file_exists($file) )
{
	//print 'Arquivo:'.$file.'<hr>';
	$html = file_get_contents($file);
	if(!$readOnly && trim( $html)=='')
	{
		echo 'Clique aqui para editar o texto de ajuda!';
	}
	else
	{
		echo trim($html);
	}
}
?>
</div>
</body>
</html>
