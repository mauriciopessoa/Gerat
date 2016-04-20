<?

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


$arquivo = $_REQUEST['arquivo'];
if((string)$_REQUEST['pacoteOracle']<>'')
{
	session_start();
	include("conexao.inc");
	if( (string)$_REQUEST['colunaChave']<>'')
	{
		$bvars=array($_REQUEST['colunaChave']=>$_REQUEST['valorChave']);
	}
	print_r(recuperarPacote($_REQUEST['pacoteOracle'],$bvars,$res,-1));
	print $res[$_REQUEST['colunaAjuda']][0];
}
else if($_REQUEST['arquivo'])
{
	$path='';
	if( !file_exists($path.$arquivo))
	{
		$path ='../';
		if( !file_exists($path.$arquivo))
		{
			$path ='../../';
			if( !file_exists($path.$arquivo))
			{
				$path ='../../modulos/';
				if( !file_exists($path.$arquivo))
				{
					$path ='../../ajuda/';
					if( !file_exists($path.$arquivo))
					{
						print 'Arquivo '.$arquivo.' n�o encontrado.<br>Pasta atual:<b>'.__FILE__.'<b>';
						return;
					}
				}
			}
		}
	}
	if( file_exists($path.$arquivo))
	{
		sleep(1);
		print file_get_contents($path.$arquivo);
	}
}
?>
