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
 
$msgLoad='Carregando...';
if( isset( $_REQUEST['msgLoad'] ) )
{
	$msgLoad = $_REQUEST['msgLoad'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<style>
html
{
	width:100%;
	height: 100%;
	margin: 0px;
	padding: 0px;
}
body
{
	width:100%;
	height: 100%;
	padding: 0px;
	margin: 0px;
	margin-top: 30px;
	text-align: center;
	overflow: hidden;
	font-family: arial, times new roman;
	font-size:16px;
	font-weight:bold;
	/*background-repeat:repeat;*/
	/*background-image:url('../imagens/marcaDagua.png');*/
	overflow:hidden;
	/*
	background-color:transparent;
	background-repeat:no-repeat;
	background-position:center center;
	*/
}
</style>
</head>
<body>
	<div style="display:block;color:navy;z-index:10000;"><?php echo $msgLoad;?></div>
  	<div style="display:block;z-index:10000;"><img src="../imagens/processando.gif" /></div>
</body>
</html>