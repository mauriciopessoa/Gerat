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
$res=null;
// ler da sess�o os arquivos j� anexados
if( isset($_SESSION['meus_anexos'] ) )
{
	$i=0;
	foreach($_SESSION['meus_anexos'] as $fileName=>$aDados)
	{
		$res['SEQ_ARQUIVO'][$i] =	( $i+1 );
		$res['NOM_ARQUIVO'][$i] =	$fileName;
		foreach($aDados as $key => $val)
		{
			$res[$key][$i] = $val;
		}
		$i++;
	}
}
$gride = new TGrid('gd4'
				,null
				,$res
				,null
				,null
				,'SEQ_ARQUIVO'
				,'NOM_TEMP,NOM_ARQUIVO'
				,10
				,'base/exemplos/gride_anexos.php');
$gride->addButton('Visualizar',null,'btnVisualizar','btnVisualizarClick()');
$gride->addRowNumColumn();
$gride->addColumn('NOM_ARQUIVO','Arquivos Anexados',800,'left');
$gride->setExportExcel(false);
$gride->show();
?>
