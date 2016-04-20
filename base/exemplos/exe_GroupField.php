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

/*
$g = new TGroup('gpx','Teste AutoSize');
$g->addTextField('nome','Nome:',40,true);
$g->show();
die();
*/
$frm = new TForm('Exemplo de Grupos');
$frm->setFlat(true);
	$frm->addGroupField('gpx','Teste Novo Grupo');
		$frm->addTextField('nome1','Nome:',40,true);
		$frm->addTextField('nome2','Nome:',40,true);
		$frm->addTextField('nome3','Nome:',40,true);
		$frm->addButton('Gravar', null, 'btnGravar', 'alert(0)', null, true, false )->setAttribute( 'align', 'left' );
	$frm->closeGroup();

$pc = $frm->addPageControl('pc',80);
$pc->addPage('Cadastro',true,true,'aba');
	$frm->addGroupField('gpx','Teste Novo Grupo');
		$frm->addTextField('nome1','Nome:',40,true);
		$frm->addTextField('nome2','Nome:',40,true);
		$frm->addTextField('nome3','Nome:',40,true);
		$frm->addButton('Gravar', null, 'btnGravar', 'alert(0)', null, true, false );
	$frm->closeGroup();
$frm->closeGroup();


$frm->addGroupField('gpy','Grupo com outro Grupo e overflow Y',null,null,null,null,true);
	$frm->addTextField('nome2','Nome:',40,true);
	$frm->addGroupField('gpw','Subgrupo');
		$frm->addTextField('nome3','Nome:',40,true);
	$frm->closeGroup();
$frm->closegroup();


//$frm->setFlat(true);


/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo1','Grupo 1');
$frm->closeGroup();
*/
/*
$frm->addGroupField('gpExemplo2','Grupo 2');
	$frm->addGroupField('gpExemplo2.1','Grupo 2.1');
	$frm->closeGroup();
$frm->closeGroup();
*/

/*
$frm->addGroupField('gpExemplo3','Grupo 3',50,null,null,null,true,'gpx',true);
$frm->closeGroup();
$frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true,'gpx');
	$frm->addTextField('nome','Nome',30);
$frm->closeGroup();
*/
//$frm->addGroupField('gpExemplo4','Grupo 4',100)->setColumns(array(80));
/*
$g = $frm->addGroupField('gpExemplo4','Grupo 4',100,null,null,null,true);
$g->setColumns(array(80));
	$frm->addTextField('nome1','Nome',30);
	$frm->addTextField('nome2','Nome',30);
	$frm->addTextField('nome3','Nome',30);
	$frm->addTextField('nome4','Nome',30);
$frm->closeGroup();
*/

$frm->setAction("Refresh");
$frm->show();
?>

