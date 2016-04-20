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

error_reporting(E_ALL);
$frm = new TForm('Exemplo Tree View',null,500);
$frm->setPosition('TR');
$frm->setAutoSize(true);



// exemplo de cria��o de uma treeview fora do formul�rio

// adicionar ao form os arquivos js e css necess�rios para o funcionamento da treeview
$frm->addJsFile('dhtmlx/dhtmlxcommon.js');
$frm->addJsFile('dhtmlx/treeview/dhtmlxtree.js');
$frm->addCssFile('dhtmlx/treeview/dhtmlxtree.css');

// criar o objeto treeview. 
$tree = new TTreeView('tree');

$tree->setWidth(400); // define a largura da �rea onde ser� exibida a treeview
$tree->setHeight(300); // define a altura da �rea onde ser� exibida a treeview

// adicionar manualmente os �tens na treeview
$tree->addItem(null,1,'Relat�rio',true);
$tree->addItem(1,11,'Financeiro',true,null,array('URL'=>'www.bb.com.br'));
$tree->addItem(1,12,'Or�ament�rio',true,null,array('URL'=>'www.bb.com.br'));

$tree->setOnClick('treeClick'); // fefinir o evento que ser� chamado ao clicar no item da treeview
$frm->addJavascript($tree->getJs());// gerar e adicionar na cria��o da pagina o codigo javascript que adiciona os itens na treeview
$tree->setXY(0,20); // posiciona a treeview na tela. left=0, top=100
$tree->show(); // exibe o tree view
$frm->addJavascript('jQuery("#tree_toolbar").hide();'); // esconder a toolbar da treeview 
// fim cria��o da treeview

$frm->setAction('Atulizar');	
$frm->show();
?>

<script>
function treeClick(id)
{
	alert( tree.getSelectedItemId());
	alert( tree.getItemText(id ) );
	alert( tree.getUserData(id,'URL') );
}
</script>

