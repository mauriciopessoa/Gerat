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

include('../../classes/webform/TTreeView.class.php');
$page = new THtmlPage();

$page->addJsCssFile('../js/appJs.js');
$page->addJsCssFile('dhtmlx/dhtmlxcommon.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.js');
$page->addJsCssFile('dhtmlx/treeview/dhtmlxtree.css');
$page->addInHead('<script>var treeView;</script>');

// criar o objeto treeview.
$tree = new TTreeView('treeView');

$tree->setWidth(200); // define a largura da área onde será exibida a treeview
$tree->setHeight(300); // define a altura da área onde será exibida a treeview

// adicionar manualmente os ítens na treeview
$tree->addItem(null,1,'Relatorio',true);
$tree->addItem(1,11,'Financeiro',true,null,array('URL'=>'www.bb.com.br'));

//$tree->setOnClick('treeClick'); // fefinir o evento que será chamado ao clicar no item da treeview
//$frm->addJavascript($tree->getJs());// gerar e adicionar na criação da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0,100); // posiciona a treeview na tela. left=0, top=100
//$tree->show(); // exibe o tree view
$page->addInBody( $tree );
$page->addJavascript( $tree->getJs() );
$page->show();
?>
