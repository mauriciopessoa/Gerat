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

$frm = new TForm('Teste Select Combinado com Preenchimento Ajax - M�dulo: exe_select_combinado_ajax.php',200);

$frm->addHiddenField('cod_municipio_temp');
$frm->addHiddenField('cod_bairro_temp');

$frm->addSelectField('cod_uf','Estado:')->addEvent('onchange','prencherMunicipio(this)');
$frm->addSelectField('cod_municipio','Municipio:');

//$frm->addSelectField('cod_bairro','Bairro:');

//$frm->combinarSelects('cod_uf','cod_municipio','TESTE.PKG_TESTE.SEL_MUNICIPIO','COD_UF','COD_MUNICIPIO','NOM_MUNICIPIO');
//$frm->combinarSelects('cod_municipio','cod_bairro','TESTE.PKG_TESTE.SEL_BAIRRO','COD_MUNICIPIO','COD_BAIRRO','NOM_BAIRRO');

$frm->setAction('Novo,Refresh');
$frm->addButtonAjax('Preencher Com Ajax',null,null,null,'Preencher',null,'text',null,true);


if( $acao == 'Novo' )
{
	$frm->clearFields();
}
else if ( $acao == 'Preencher' )
{
	//require_once($this->getBase().'includes/formDin4Ajax.php');

	// simular retorno do banco de dados
	$a = array('cod_uf'=>12,'cod_municipio'=>1200203,'cod_bairro'=>1200203001);
	echo json_encode($a);
	exit;
	//print_R($a);
	//die();
	//prepareReturnAjax(1,$a);
}
//d($_POST);
$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init()
{
	jQuery('#cod_uf').change();
}
function callbackPreencherAjax(res)
{
	alert( res );
	return;
	if( res )
	{
		var o = jQuery.parseJSON( res );



		jQuery("#cod_municipio_temp").val(o.cod_municipio);
		jQuery("#cod_bairro_temp").val(o.cod_bairro);
		jQuery("#cod_uf").val(o.cod_uf ).change();
		jQuery("#cod_bairro").val(o.cod_bairro ).change();
	}

}
function myCallback(res)
{
	//alert( 'voltei: res=' + res);
}
function prencherMunicipio(e)
{
	fwFillSelectAjax("cod_municipio","TESTE.PKG_TESTE.SEL_MUNICIPIO","COD_MUNICIPIO","NOM_MUNICIPIO",e.value,"myCallback","-- municipios --","-1","cod_uf|COD_UF","",0,0);
}

</script>
