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

  $frm = new TForm('Exemplo de Campo Grupo');
  $frm->addTextField('nome','Campo nome comprido com wordwrap true:',30,null,null,null,null,null,null,null,true);

  $frm->addGroupField('gp00','Grupo Teste I',80,null,null,null,false,'gx',true,null,null,null,true);
	  //$frm->addTextField('nome2','Campo nome comprido com wordwrap true:',30,null,null,null,null,null,null,null,true);
	  $frm->addCheckField('gravar','Marque aqui para n�o gravar este grupo:',null,null,false,false,null,1,null,null,null,true);
	  $frm->addTextField('nome3','Endere�o:',30);
	  $frm->addTextField('nome4','Bairro:',40);
	  $frm->addTextField('nome5','Cep:',50);
  $frm->closeGroup();


  $frm->addGroupField('gp01','Grupo Teste I',null,null,null,true,true,'gx',true);
  	$frm->addHtmlField('html_1','<b>Campo grupo SEM quebra na coluna do r�tulo</b>');
  	$frm->addTextField('txt_nome','Nome completo da pessoa f�sica:',60);
  $frm->closeGroup();
  $frm->addGroupField('gp02','Grupo Teste II',null,null,null,null,true,'gx')->setCss('background-color','white');
  	$frm->addHtmlField('html_2','<b>Campo grupo com fundo branco e COM quebra na coluna do r�tulo</b>');
  	$frm->addTextField('txt_nome','Nome completo da pessoa f�sica:',60);
  $frm->closeGroup();

  $frm->setAction('Gravar,Refresh');
  $frm->addButton('Confirmar',null,'btnConfirmar','fwConfirm("Tem certeza ?","confirmOk(1)","confirmOk(0)")');
  $frm->show();
?>
