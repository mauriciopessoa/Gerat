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

// criar o formulario com os campos off-line do gride
$frm = new TForm(null,150);

$frm->setcss('background-color','#B4CDCD');

//$frm->addJavascript('gridCallBack(REQUEST)');

$frm->addNumberField('val_salario'		, 'Salario:',10,false,2);
$frm->addSelectField('tip_pagamento'	, 'Tipo Pagamento:',null,'1=Mensal,2=Semanal,3=Di�rio',false);
$frm->addTextField('nom_moeda'			, 'Moeda:',13,false);
$frm->addTextField('sig_moeda'			, 'Sigla:',4,true,null,null,false)->setAttribute('grid_align','center')->setAttribute('grid_hidden','true');

$frm->addSelectField('cod_uf','Estado:',false,null,true);
$frm->addSelectField('cod_municipio'	,'Munic�pio:',null,null,false)->setAttribute('grid_column','NOM_MUNICIPIO');
$frm->combinarSelects('cod_uf','cod_municipio','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Munic�pios --','0','Nenhum Munic�pio Encontrado','cod_regiao','callBackSelectCombinado()');

// fazer a valida��o manualmente
if( $_REQUEST['action'] == 'save')
{
	if( ! $frm->get('nom_moeda') )
	{
		$frm->addError('O campo Moeda � de preenchimento Obrigat�rio');
	}
}
/*session_start();
session_destroy();
session_start();
*/
//error_reporting(E_ALL);
//d($_SESSION);
//print_r($_SESSION['FORMDIN']['offline']['gdx']['DES_OBS']);

//$_SESSION[APLICATIVO]['offline']=NULL;
// criar o gride
$res = null;
$res['SEQ_MOEDA'][0] 		= 10;
$res['SEQ_DOCUMENTO'][0] 	= 12;
$res['NOM_MOEDA'][0] 		= 'Dolar';
$res['SIG_MOEDA'][0] 		= 'US$';
$res['TIP_PAGAMENTO'][0] 	= 2;
$res['DES_OBS'][0]			= 'Valor Inicial';
$res['VAL_SALARIO'][0]	  	= '80,00';
$res['COD_UF'][0]	  		= '22';
$res['COD_MUNICIPIO'][0]	= null;
$res['NOM_MUNICIPIO'][0]	= null;

$res['SEQ_MOEDA'][1] 		= 11;
$res['SEQ_DOCUMENTO'][1] 	= 12;
$res['NOM_MOEDA'][1] 		= 'Real';
$res['SIG_MOEDA'][1] 		= 'R$';
$res['TIP_PAGAMENTO'][1] 		= 1;
$res['DES_OBS'][1]			= 'Valor Inicial 2';
$res['VAL_SALARIO'][1]	  	= '100,00';
$res['COD_UF'][1]	  		= '12';
$res['COD_MUNICIPIO'][1]	= '1200013';
$res['NOM_MUNICIPIO'][1]	= 'ACRELANDIA';

$grid = new TGrid('gdx','Dados Off-line'
					,$res
					,null
					,null
					,'SEQ_MOEDA,SEQ_DOCUMENTO'
					,null
					,null
					,'exe_gride_3_dados.php');

// adicionar o formul�rio ao gride para criar o gride offline
$grid->setForm($frm,false);

$grid->setShowAdicionarButton(true); // exibir o bot�o de adicionar - default =  true

// Exemplo de como alterar a largura e o alinhamento da coluna Moeda.
$grid->setOnDrawHeaderCell('drawHeader');

$grid->show();

function drawHeader($objTh,$objCol,$objHead)
{
	if( $objCol->getFieldName() == 'NOM_MOEDA')
	{
		$objHead->setCss('width','250px');
		$objCol->setTextAlign('center');
	}
}

/*$tb = new TTable();
$tb->setCss('font-size','12px');
$row = $tb->addRow();
$row->addCell('<center>Exemplo dos dados do Grid que est�o na vari�vel de sess�o:<br><b>$_SESSION[APLICATIVO]["offline"]["gdx"]</b></center>');
$row = $tb->addRow();
$row->addCell('<pre><div style="border:1px dashed black;width:540px;height:150px;overflow:hidden;overflow-y:auto;">'.print_r($_SESSION[APLICATIVO]['offline']['gdx'],true).'</div></pre>');
$tb->show();
*/
?>
