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

$frm = new TForm('Campo Coordendada Geogr�fica (GMS)');
$frm->setOnlineDoc(true);
$frm->disableCustomHint();
$frm->addCoordGMSField('num_gms1','Coordenada Geogr�fica:',false,true,null,null,'NUM_LAT','NUM_LON');
$frm->addCoordGMSField('num_gms2','Coordenada Geogr�fica:',false,true,null,null,'NUM_LAT','NUM_LON','Grau:,Min:,Seg:');
$frm->addButton('Map',null,'btnMapa','showPointGoogleMap()');
$frm->setAction('Atualizar,Gravar,Inicializar');
//$frm->addJsFile('http://maps.google.com/maps/api/js?v=3.1&sensor=false&language=pt_BR&region=BR');

if( isset($acao ) )
{
	if($acao =='Gravar')
	{
		$bvars = $frm->createBvars('num_gms1');
		$frm->clearFields();
		d($bvars);

	}
	else if($acao=='Inicializar')
	{
		$frm->getField('num_gms1')->setLat('5.3388888888889');
		$frm->getField('num_gms1')->setLon('-35.685277777778');
	}
}
$frm->show();
?>
<script>
function showPointGoogleMap()
{
	//top.fwModalBox('Consulta Coordenada',top.app_url+"base/includes/ponto_google_map.php",400,700);
	//return;
	if( top.app_prototype )
	{
		top.app_faceBoxIframe(top.app_url+"base/includes/ponto_google_map.php?prototypeId="+fwGetObj('prototypeId').value+'&updateField=num_gms1',400,700);
	}
	else
	{
		fwFaceBoxIframe(top.app_url+"base/includes/ponto_google_map.php?prototypeId=&updateField=num_gms1",400,700);
	}
	//top.fwFaceBoxIframe(top.app_url+app_index_file+"?modulo=base/includes/ponto_google_map.php",450,700);
}
</script>
