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

// chamada ajax
if(isset($_POST['num_cep'])){
	header("Content-Type:text/xml");
	echo file_get_contents('http://www.buscarcep.com.br/?cep='.$_POST['num_cep'].'&formato=xml');
	exit;
}
$frm = new TForm('Exemplo Campo CEP',400,600);
// define a largura das colunas verticais do formulario para alinhamento dos campos
$frm->setColumns(array(100,100));
$fldCep = $frm->addCepField('num_cep1','Cep:',true,null,null,'des_endereco','nom_bairro','nom_cidade','cod_uf',null,null,null,null,null,null,'pesquisarCepCallback','pesquisarCepBeforeSend',false,'Cep est� incompleto')->setExampleText('N�o limpar se estiver incompleto');
$fldCep = $frm->addCepField('num_cep','Cep:',true,null,null,'des_endereco','nom_bairro','nom_cidade','cod_uf',null,null,null,null,null,null,'pesquisarCepCallback','pesquisarCepBeforeSend');
$frm->addTextField('des_endereco','Endere�o:',60);
$frm->addTextField('num_endereco','N�mero:',10);
$frm->addTextField('des_complemento','Complemento:',60);
$frm->addTextField('nom_bairro','Bairro:',60);
$frm->addTextField('nom_cidade','Cidade:',60);
$frm->addTextField('cod_municipio','Cod. Munic�pio:',10);
$frm->addSelectField('cod_uf','Uf:',2);
$frm->addTextField('sig_uf','Uf:',2);
$frm->setValue('num_cep','71505030');

$frm->addHtmlField('linha','<hr><b>Consulta com select combinado</b>');

// utilizando select combinados
$frm->addHiddenField('cod_municipio_temp','');
$fldCep = $frm->addCepField('num_cep2','Cep:',true,null,null
	,'des_endereco2'
	,null
	,null
	,'cod_uf2'
	,null
	,null
	,null
	,'cod_municipio2_temp'
	,null
	,null,'myCallback');
	$frm->addTextField('des_endereco2','Endere�o:',60);
	$frm->addSelectField('cod_uf2','Estado:',false);
	$frm->addSelectField('cod_municipio2','Munic�pio:',null,null,false);
	$frm->combinarSelects('cod_uf2','cod_municipio2','vw_municipios','cod_uf','cod_municipio','nom_municipio','-- Munic�pios --','0','Nenhum Munic�pio Encontrado');

$frm->show();
?>
<script>
function pesquisarCepCallback(xml)
{
	alert( 'Evento callback do campo cep foi chamada com sucesso');
}

function pesquisarCepBeforeSend(id)
{
	alert( 'Evento beforeSend do campo cep '+id+' foi chamado com sucesso');
}

function myCallback(dataset)
{
	console.log(jQuery("#cod_municipio2_temp").val());
	jQuery("#cod_uf2").change();
}
</script>