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

$frm = new TForm('Estrutura Oragnizacional',400);

$frm->addGroupField('gpTree','Exemplo Treeview',200)->setcloseble(true);
//$pc = $frm->addPageControl('xxx',200);
//$page = $pc->addPage('label',true,true);

	$tree = $frm->addTreeField('tree',null,null,null,null,null,null,null,null);
	$tree->setStartExpanded(true);
	$tree->setTheme('bluebooks');
	$tree->setTheme('bluefolders');
	$tree->setTheme('books');
	$tree->setTheme('default');
	$tree->setTheme('scbrblue');
	$tree->setTheme('skyblue');
	$tree->setTheme('vista');
	$tree->setTheme('winstyle');
	$tree->setTheme('yellowbooks');

	$tree->addItem(null,1,'Relat�rio',true);
	$tree->addItem(1,11,'Financeiro',true,'Meu Hint',array('URL'=>'www.bb.com.br'));
	$tree->addItem(1,12,'Recursos Humanos',null,null,array('URL'=>'www.google.com.br'));
	$tree->addItem(null,2,'Arquivos',true);
	$tree->addItem(2,21,'Documentos',null,'Documentos do �rg�o',array('MODULO'=>'modulos/cad_documento'));
	$tree->addItem(2,22,'Planilhas');
	for($i=23;$i<50;$i++)
	{
		$tree->addItem(2,$i,'Nivel teste '.$i);
	}
$frm->closeGroup();
$frm->setAction('Atualizar');
$frm->show();
?>
