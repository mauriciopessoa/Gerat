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

$frm = new TForm('Exemplo Documenta��o On-line');
$frm->addHiddenField('oculto');
//$frm->enableOnlineDoc(false,400,600,'des_bairro','data,sit_cancelado'); // false = permitir edi��o. Tela com 200px de altura por 600px de largura
$frm->enableOnlineDoc(false,400,600,'nom_pessoa,des_endereco'); // false = permitir edi��o. Tela com 200px de altura por 600px de largura
$pc = $frm->addPageControl('pc');
$pc->addPage('Cadastro',true,true);
$frm->addTextField('nom_pessoa','Nome da pessoa:',50,true,50,null,true,'Este � um campo texto','Ex:Jo�o',false);
$frm->addTextField('des_endereco','Ender�o:',50,false,50,null,true,null,null,false);
$frm->addTextField('des_bairro','Bairro:',50,false,50,null,true,null,null,true);
$frm->addMemoField('obs','Observa��o:',200,false,80,5,null,true,true);
$frm->addDateField('data','Data:',true);
$frm->addSelectField('sit_cancelado','Cancelado ?',true,'S=Sim,N=N�o');
$frm->setAction('Gravar');
$frm->show();
?>
