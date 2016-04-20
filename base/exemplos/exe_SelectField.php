<?php
TPDOConnection::test(false);
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
$frm = new TForm('Exemplo do Campo Select',400);

$frm->addHtmlField('html_gp2','<center><b>Este exemplos est�o utilizando o banco de dados local "base/exemplos/bdApoio.s3db" (sqlite)</center></b><br/>');


$frm->addGroupField('gp1','Selects Normais');
	$frm->addSelectField('sit_cancelado','Cancelado:',null,'0=N�o,1=Sim',null,null,'1');
	$frm->addSelectField('seq_bioma'	,'Bioma:',true,'CE=CERRADO,PA=PANTANAL,MA=MATA ATL�NTICA',null,null,null,true,4);
	$frm->addHtmlField('status');
$frm->closeGroup();


$frm->addGroupField('gp2','Selects Combinados');
	$frm->addSelectField('cod_regiao','Regi�o:',null,'1=NORTE,2=NORDETE,3=SUDESTE,4=SUL,5=CENTRO OESTE')->setEvent('onchange','regiaoChange()');
	$frm->addSelectField('cod_uf','Estado:',false,null,false);
	$frm->addSelectField('cod_municipio'	,'Munic�pio:',null,null,false);
	$frm->combinarSelects('cod_regiao','cod_uf','tb_uf','cod_regiao','cod_uf','nom_uf');
	$frm->combinarSelects('cod_uf','cod_municipio','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Munic�pios --','0','Nenhum Munic�pio Encontrado','cod_regiao','callBackSelectCombinado()');

	$frm->addSelectField('cod_uf_2','Estado 2:',false);
	$frm->addSelectField('cod_municipio_2'	,'Munic�pio 2:',null,null,false);
	$frm->combinarSelects('cod_uf_2','cod_municipio_2','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Munic�pios --','0','Nenhum Munic�pio Encontrado');
$frm->closeGroup();

$frm->addGroupField('gp3','Selects Ajax');
 	$frm->addSelectField('cod_estados_ajax'	,'Estado (ajax):');
	$frm->addButton('Preencher',null,'btnMunAjax','lerMunAjax()',null,null,false);
$frm->closeGroup();


$frm->setAction('Atualizar,Validar');
$frm->addButton('Limpar',null,'btnLimpar','btnLimparClick()');
$frm->addButton('Iniciar Estado 2',null,'btnUF2','btnUF2Click()');

if( $acao=='Validar' )
{
	d($_POST);
	$frm->validate();

	$txt = $frm->getField('seq_bioma')->getText();
	$val = $frm->getField('seq_bioma')->getValue();
	$frm->set('status','<PRE>Biomas selecionado:'.print_r($txt,true).'<br>Valores selecionado:'.print_r($val,true).'<br>CreateBvars:<br>'.print_R($frm->createBvars('seq_bioma'),true).'</PRE>');
}

// exibir o formul�rio
$frm->show();
?>
<script>
function btnLimparClick()
{
	//jQuery('#sit_cancelado').get(0).options.length=null;
	//ou
	//jQuery('#sit_cancelado').find('option').remove();
	// ou
	//document.getElementById('sit_cancelado').options.length=null;
	fwClearChildFields();
}
function callBackSelectCombinado(pai,filho)
{
	alert( 'Callback combinar select.\nO campo cod_municipio agora possui '+filho.length+' munic�pios.\n\nValor do Select Pai ('+pai.id+') ='+pai.value+'\nValor do Select Filho ('+filho.id+') = '+filho.value );
}
function regiaoChange()
{
	alert( 'Rregi�o foi alterada');
}
function lerMunAjax()
{
	fwFillSelectAjax('cod_estados_ajax','tb_uf','cod_uf','nom_uf',null,'retorno','-- estados --');
}
function retorno(id)
{
	alert( 'O campo '+id+' foi preenchido!' );
}
function btnUF2Click()
{
	var campos = 'cod_uf_2|cod_municipio_2';
	var valores= '52|5200506';
	//fwUpdateFields(campos,valores);
	fwAtualizarCampos(campos,valores);
}
</script>

