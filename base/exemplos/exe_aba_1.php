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

//error_reporting(E_ALL);
$frm = new TForm('Exemplo Utiliza��o de Abas',400,800);
//$frm->setflat(true);
//$pc = $frm->addPageControl('pc',null,null,'pcBeforeClick','pcAfterClick');
$pc = $frm->addPageControl('pc',null,null,null,null);
$acao='';
$p = $pc->addPage('Cadastro A��o',true,true,'aba1',null);
	$frm->addTextField('cadastro','Cadastro:',20,true);
	//$frm->addHtmlField('html_texto',null,null,"Observa��o:",200,500);//->setCss('background-color','yellow');
	$frm->addButton('Selecionar a aba relat�rio',null,'btnAtivarAba','btnClick()',null,true,false);
	$frm->addButton('Selecionar a aba Hist�rico',null,'btnAtivarAbaHist','btnClick2()',null,false,false);
	$frm->addButton('Desabilitar aba hist�rico',null,'btnDesabilitarAba','btnDesabilitarClick()',null,false,false);
	$frm->addButton('Habilitar aba hist�rico',null,'btnHabilitarAba','btnHabilitarClick()',null,false,false);
	$frm->addButton('Mostrar Erros',null,'btnMostrarErro','MostrarErros()');
	$frm->addMemoField('memo','Obs:',1000,true,60,10);
	$frm->addTextField('campo2','Campo2:',20);
	$frm->addShortCut('F2','aba1');


$pc->addPage('&Relat�rio',false,true,'abaRelatorio');
	$frm->addGroupField('gpRelatorio','Grupo do Relat�rio');
		$frm->addMemoField('memo2','Obs:',1000,true,60,10);
    $frm->closeGroup();

$pc->addPage('Hist�rico',false,true,'aHist');
	$frm->addTextField('historico','Hist�rico:',20);


$pc->addPage('Or�amento',false,false,'abaOrcamento');
	$frm->addGroupField('gpx','Grupo x');
		$frm->addTextField('orcamento','Or�amento:',20,true)->setHint('teste - teste');
	$frm->closeGroup();
$frm->closeGroup();
//$frm->closeGroup();
//$frm->addTextField('cadastro2','Cadastro:',20);
//$pc->setActivePage('abaHistorico',true);
//$frm->addTextField('descricao','Descri��o:',50);
$frm->setAction('Atualizar,Gravar');
//$frm->setMessage('Gravar��o realizada com sucesso');
error_reporting(~E_NOTICE);

if($acao=='Gravar')
{
	$frm->validate();
	//$frm->validate('Cadastro A��o');
	//$frm->validate('gpx');
	//$frm->validate('abaOrcamento');
	$pc->getPage('aHist')->setVisible(false);
}
$frm->show();
?>
<script>
function pcBeforeClick(rotulo,container,id)
{
	if( id == 'abarelatorio' )
	{
		//alert('N�o � permito acesso a esta aba via mouse');
		return false;
	}
	return true;
}
function btnClick()
{
	//fwGetObj('pc_container_page_abarelatorio_link').onclick();
	//ou
	//fwSelecionarAba(fwGetObj('pc_container_page_abarelatorio_link'));
	// ou
	fwSelecionarAba('abaRelatorio');
}
function btnClick2()
{
	fwSelecionarAba('aHist',null,null,true);
}
function btnDesabilitarClick()
{
	fwDesabilitarAba('aHist');
}

function btnHabilitarAbaClick()
{
	fwDesabilitarAba('aHist');
}

function btnHabilitarClick()
{
	fwHabilitarAba('aHist','pc');

}
function fwAdjustHeight2(frmId,jsonParams)
{
	alert( frmId );
}
function pcAfterClick(aba,pageControl,id)
{
	alert('A fun��o definida no evento afterClick do pageControl,\nfoi chamada e recebeu os seguintes parametros:\n\n'+
	'aba='+aba+'\n'+
	'pageControls='+pageControl+'\n'+
	'id='+id);
}
function MostrarErros()
{
	var obj = jQuery("#formdin_msg_area");
	alert( obj.length );
	obj.addClass("fwMessageAreaError");
	obj.height(150);
	obj.show();
	alert( 'ok');

}
</script>
