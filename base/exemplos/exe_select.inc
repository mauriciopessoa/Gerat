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

$frm = new TForm('Campo Select',300);

$frm->addSelectField('sit_cancelado','Cancelado:',null,'0=N�o,1=Sim');
$frm->addSelectField('seq_bioma'	,'Bioma:',true,'0=CERRADO,1=PANTANAL,2=MATA ATL�NTICA',null,null,null,true,4);


$frm->setAction('Atualizar,Sair');

$frm->addSelectField('seq_moeda' ,'Moeda 1:',true,'TESTE.PKG_MOEDA.SEL_MOEDA',null,null,null,null,null,null,'-- moeda --')->setEnabled(false);
$frm->addSelectField('seq_moeda2','Moeda 2:',true,null,null,null,null,true,4,null,'<< Selecione a Moeda >>','');
$frm->addSelectField('seq_moeda3','Moeda 3:',false,null,null,null,null,false);

$frm->setOptionsSelect('seq_moeda2','TESTE.PKG_MOEDA.SEL_MOEDA','SIG_MOEDA',null,'SIG_MOEDA=R$');
$frm->setOptionsSelect('seq_moeda3','TESTE.PKG_MOEDA.SEL_MOEDA','SIG_MOEDA',null,'SIG_MOEDA=R$');

$frm->setAction('Atualizar,Sair');

// adicionar o evento ao campo
$frm->setFieldEvent('seq_moeda','onChange','selectAlterou()');
$frm->setFieldEvent('seq_moeda3','onChange','selectAlterou()');

// retirar o evento do campo
$frm->setFieldEvent('seq_moeda','onChange');


$frm->addButton('Validar','validar','btnValidar');
$frm->addButton('Testar Disabled',null,'btnTestar','btnTestarClick()');

if( $acao=='validar' )
{
	$frm->validate();
	
}
// exibir o formul�rio
$frm->show();
?>
<script>
function selectAlterou()
{
	alert('campod select foi alterado');
}
function btnTestarClick()
{
	
	//alert( fwGetObj('seq_moeda').value);
	//alert( document.getElementById('seq_moeda').value);
	
	fwAtualizarCampos('seq_moeda','14');
	//alert( fwGetObj('seq_moeda').value);
	//fwGetObj('seq_moeda_disabled').value = 14);

}
</script>
