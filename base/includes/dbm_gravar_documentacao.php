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
	Grava��o da documenta��o via ajax
*/
$dir  	= 'doc/';
if( !file_exists($dir))
{
	for($i=1;$i<11;$i++)
	{
		$dir = '../'.$dir;
		if( file_exists($dir))
		{
			break;
		}
	}
	
	if( !file_exists($dir))
	{
		print 'Diret�rio para grava��o dos dados ['.$dir.'] n�o encontrado!';
		return;
	}
}
$type	= 'db4';
$file 	= 'documentacao.'.$type;
$key  	= strtoupper($_REQUEST['modulo'].'_'.$_REQUEST['campo']);
$key  	= md5( strtoupper($_REQUEST['modulo'].'_'.$_REQUEST['campo']));
$dbh = dba_open($dir.$file,'c',$type) or die('Erro');
// retrieve and change values
if( !dba_replace($key,$_REQUEST['texto'],$dbh))
{
	print 'Erro de grava��o!';
}
dba_close($dbh)
?>
