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

//d($_REQUEST);

$frm = new TForm('Exemplos de Formul�rio',300);
$frm->addHiddenField('flat');

// adicinoar eventos ao fechar e antes de fechar
$frm->setOnBeforeClose('antesFechar()');
$frm->setOnClose('depoisFechar()');


$frm->addTextField('nome','Nome:',60);
if( $frm->get('flat')=='1')
{
	$frm->setFlat(true);
	$frm->addButton('Com bordas',null,'btn2','jQuery("#flat").val(0);fwDoAction();');
}
else
{
	$frm->addButton('Sem bordas',null,'btn2','jQuery("#flat").val(1);fwDoAction();');
}
$frm->addRadioField('sexo','Sexo:',fase,'M=masculino,F=Feminino');
$frm->addCheckField('cor','Cor:',fase,'M=Marrom,B=Branca');

$frm->addTextField('municipio','Municipio',60,false,60);

$frm->setOnlineSearch('municipio','tb_municipio'
	,'nom_municipio|Munic�pio:'
	,false
	,false
	,true // se for encontrada apenas 1 op��o fazer a sele��o automaticamente
	,'cod_municipio|C�digo,nom_municipio|Munic�pio'
	,'NOM_MUNICIPIO|municipio'
	,null
	,null,null,null,null,null,null
	,'funcaoRetorno()'
	,null,null,null,null,null,null,null,null
	,false // caseSensitive
	);



$frm->setonMaximize('onMaximize');
$frm->addButton('Fechar Modal',null,'btnFechar','fecharModal()');
$frm->addButton('Maximizar',null,'btn1','fwFullScreen(null,onMaximize)','Confirma Maximizar?');
$frm->addButton('Open Modal',null,null,'openModal()');
//$frm->setPrototypeId('1');
$frm->show();

?>
<script>
//Window.keepMultiModalWindow=true;
function openModal()
{
  	fwModalBox('Janela Modal 2','index.php?modulo=exe_TForm.php');
	//top.app_open_modal_window({url:'http://localhost/fontes/base/exemplos/index.php?modulo=exe_TForm.php'});
}
function onMaximize(res)
{
	if( res == 0 )
	{
		jQuery('#btn2').val('Maximizar');
	}
	else
	{
		jQuery('#btn1').val('Minimizar');
	}
}
function fecharModal()
{
	alert( 'fechar');
	fwClose_window();
}

function funcaoRetorno()
{
	alert('funcaoRetorno() executada!');
}

function antesFechar()
{
	return confirm('Prosseguir com o fechamento do Formul�rio ?');
}

function depoisFechar()
{
	alert( 'Formul�rio ser� fechado');
}
</script>

