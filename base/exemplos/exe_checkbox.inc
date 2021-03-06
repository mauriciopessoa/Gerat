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

$frm = new TForm('Campo Checkbox');
//$frm->setOnlineDoc(true);

$frm->addCheckField('campo_1','Biomas:',true,'1=Cerrado,2=Mata Atl�ntica,3=Caatinga');
$frm->addCheckField('campo_2','Moeda:',true,'TESTE.PKG_MOEDA.SEL_MOEDA',null,null,null,3);
$frm->addSelectField('campo_3','Moeda:',true,'TESTE.PKG_MOEDA.SEL_MOEDA',null,null,null,true,4);
$frm->addCheckField('campo_4','Confirma ?',true,array('1'=>''))->setcss('border','0px');
$frm->addCheckField('campo_5','Confirmar ?');

$frm->addRadioField('rad_teste','Rotulo:',false,'S=SIM,N=N�o');

$frm->setAction('Atualizar');


$frm->addButton('Validar','validar','btnValidar');

if( $acao=='validar' )
{
	$frm->validate();
}
// exibir o formul�rio
$frm->show();
?>

