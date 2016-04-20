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

sleep(1); // mostrar a imagem de processando.
ini_set('default_charset','iso-8859-1');
error_reporting(0);
$file = $_REQUEST['id'];
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
// gravar o arquivo / Remover tag iframe
$_REQUEST['value'] = preg_replace('{(<iframe).*?(>).*?(<\/iframe>)}i', '', $_REQUEST['value']);
//$_REQUEST['value'] .=utf8_encode('<hr><center>Alterado por:Luis Eug�nio em '.date('d/m/Y h:i:s').'</center>');
if(!file_put_contents($file,utf8_decode($_REQUEST['value'])))
{
	print '<script>alert("N�o foi poss�vel gravar o texto, verifique as permiss�es de escrita no arquivo '.$file.')</script>';
	return;
}
print utf8_decode($_REQUEST['value']);
print '<script>alert("Grava��o Ok");</script>';
?>
