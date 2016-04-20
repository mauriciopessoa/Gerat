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

if( $_REQUEST['id'] )
{
	print $_REQUEST['value'];
	return 'luis';
}
$file = $_REQUEST['file'];
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
			//http://www.appelsiini.net/projects/jeditable
			/*jQuery('.editable').editable('../../modulos/gravar_ajuda.php',
			{
         		type	: 'textarea',
         		submit  : 'Salvar'
     		});
     		*/
			jQuery('.editInPlace').editable('../../base/callbacks/helpOnLine.php',
			{
         		type	: 'textarea',
         		submit  : 'Salvar',
				/*style  : 'inherit'*/
				cssclass : "editable"
				
     		});
		}
	);
</script>
<style>
.editInPlace 
{
	width:100%;
	height:85%;
	font-family: Arial;
	font-size: 12px;
	background-color: white;	
}
.editable
{
	background-color:yellow;
	width:300px;
	height:150px;
}
</style>
</head>
<body>
<?php
print '<div class="editInPlace" id="'.$file.'">'."\n";
print '<pre>';
print_r($_REQUEST);
print '</pre>';
/**
* se no nome do arquivo n�o tiver a extens�o .html, adicionar a extens�o .html e se o arquivo 
* n�o existir criar um em branco
*/
if( strpos(strtolower($file),'.html') === false)
{
	$file.='.html';
}
// se passar o nome do arquivo puro, procurar na pasta ajuda/
if( strpos( $file, '../' ) === false) 
{
	$file = '../../ajuda/'.$file;	
}
// criar o arquivo
if( ! file_exists($file) )
{
	//file_put_contents($file,'O texto de ajuda para este campo ainda n�o foi definido!');
}
if( file_exists($file) )
{
	print 'Arquivo:'.$file.'<hr>';
	print file_get_contents($file);
}
?>
</div>
</body>
</html>
