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

$frm = new TForm('Estados e Munic�piosl',500);

$ufs = TPDOConnection::executeSql("select 'uf'||cod_uf as cod_uf,nom_uf||'/'||sig_uf as nom_uf from tb_uf order by nom_uf");
$frm->addSelectField('id','Estado:',false,$ufs,null,null,null,null,null,null,'-- Todos --')->addEvent('onchange','atualizarArvore()');

$frm->addGroupField('gpTree','Exemplo Treeview')->setcloseble(true);
	$tree = $frm->addTreeField('tree','Extados x Munic�pios','vw_tree_uf_mun','ID_PAI','ID','NOME',null,null,320,null,null,null,null,null,null,null,null,null,null,null,null);
	$tree->addFormSearchFields('id'); // informar a tree para utilizar o campo id do form como parte do filtro
	$tree->setStartExpanded(true);
	$tree->setTheme('default');
$frm->closeGroup();
$frm->setAction('Atualizar');
$frm->show();

?>
<script>
function atualizarArvore()
{
	treeJs.deleteChildItems(0); // limpar a treeview
	// carregar novamente a treeview
	treeJs.loadXML(fwUrlAddParams(app_url+app_index_file+"?modulo=../../base/callbacks/treeView.php&ajax=1&parentField=ID_PAI&childField=ID&descField=NOME&tableName=vw_tree_uf_mun", {"id":null} ) );
}
</script>