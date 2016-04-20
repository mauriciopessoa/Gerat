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
//$frm->addJsFile('FormDin4Geo.js');
$frm->disableCustomHint();
//$frm->addCoordGMSField('num_gms1','Coordenada Geogr�fica:',false,true,null,null,'NUM_LAT','NUM_LON')->setMapHeaderText('meu cabecalho' )->setMapHeaderFontColor('red')->setMapHeaderFontSize('14px')->setMapCallback('mapCallback')->setMapZoom(10);
$frm->addCoordGMSField('campo_gms','Coordenadas Geogr�ficas:',false,true,null,null,'NUM_LAT','NUM_LON')->setMapCallback('mapCallback')->setMapZoom(10);
//$frm->addCoordGMSField('num_gms2','Coordenada Geogr�fica:',false,true,null,null,'NUM_LAT','NUM_LON','Grau:,Minutos:,Segundos:',null,null,null,null,null,null,'Teste',null,null)->setEnabled(false);
$frm->addButton('Teste',null,'btnTeste','testar()');
$frm->addButton('Abrir Map',null,'btnMapa','showPointGoogleMap()');
$frm->addButton('Grau Decimal',null,'btnGrauDecimal','showGrauDecimal("num_gms1")');
$frm->addButton('Set Js',null,'btnSetJs','fwSetGmsField("num_gms1",-5.338611111111111,-35.68499999999999)');

$frm->setAction('Inicializar,Gravar,SetLat e setLon');

if( isset($acao ) )
{
	if($acao =='Gravar')
	{
		//d($_POST);
		$bvars = $frm->createBvars('num_gms1');
		d($bvars);
	}
	else if($acao=='Inicializar')
	{

        //Latitude: -5.300947222222222
        //Longitude: -35.71515555555556
		$frm->getField('num_gms1')->setLat('-5.300947222222222');
		$frm->getField('num_gms1')->setLon('-35.71515555555556');
        /*
         * 5, 18 , 3,41
         * 35, 42, 54,56
         */
	}
}
$frm->show();
?>
<script>
function showPointGoogleMap()
{
	var y='-5,827378';
	var x='-52,483373';
    fwFieldCoordShowMap(null,400,900,{"lat":y,"lon":x,"mapHeaderText":"CONSULTA MAP","mapHeaderFontColor":"blue","mapHeaderFontSize":"16"});
}
function showGrauDecimal(field)
{
	alert( "Latitude: "+fwDms2dd(field,'LAT')+'\nLongitude: '+fwDms2dd(field,'LON') );
	//alert( dms2dd('field','LON'));
}

function mapCallback(lat,lon,zoom,latDMS,lonDMS,event,map)
{
   	var latitude 		= event.latLng.lat();
	var longitude		= event.latLng.lng();

    alert( 'Callback chamado.\nSelecionado: LAT:'+lat+' LON:'+lon+'\nZoom:'+zoom
    +'\nLat Degree :'+latDMS.d
    +'\nLat Minute :'+latDMS.m
    +'\nLat Second :'+latDMS.s
    +'\nLatitude   :'+latitude
    +'\nLongitude  :'+longitude
    +'\nZoom       :'+map.getZoom()
    );
}
</script>
