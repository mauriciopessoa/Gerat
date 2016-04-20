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
Todo elemento que possuir a propriedade tooltip="true" ser� processado
ex: <input type="button" tooltip="true">
*/
$frm = new TForm('Exemplo de Hints / Tooltips');
//define('REQUIRED_FIELD_MARK','*');
//$frm->setColorHighlightBackground('#FAFAD2');

$frm->setColumns(array(150));
$frm->addTextField('endereco','Endere�o:',150	,false,50)->setHint('Endere�o - O endere�o deve ser informado completo, sendo o nome da rua, o bairro, o unidade da federa��o e o complemento.');
$frm->addTextField('longo1','Hint Longo:',150	,false,50)->setHint('M�sica de Lulu Santos - Nada do que foi ser� de novo do jeito que ja foi um dia, tudo passa tudo sempres passar�, a vaida vem em ondas como um mar!!!<br>Tudo que se v� n�o � igual ao que a gente viu a um segundo tudo muda o tempo todo no mundo.');
$frm->addTextField('longo2','Hint Muito Longo:'	,150,false,50)->setHint('M�sica de Roberto Carlos - Eu tenho tanto, pra lhe falar, mas com palavras n�o sei dizer, como � grande o meu amor por voc�.<br>E n�o h� nada pra comparar para poder lhe explicar, como � grande o meu amor por voc�.<br>Nem mesmo o ceu nem as estrelas, nem mesmo o mar e o infinito, n�o � maior que meu amor nem mais bonito.<br>Me desespero a procurar alguma forma de lhe falar como � grande o meu amor por voc�.');
$frm->addTextField('longo3','Hint Com Tabela:'	,150,false,50)->setHint('<table border=1><th>COLUNA 1</th><th>COLUNA 2</th><tr><td>A</td><td>B</td></tr></table>');
$frm->getLabel('longo2')->setToolTip('ol�');

$frm->addTextField('dica1','Dica 1'	,150,false,50)->setToolTip('Cabe�alho','Texto da dica');
$frm->addDateField('dica2','Data')->setToolTip('Cabe�alho','Texto da dica');
$frm->addMemoField('dica3','Obs 1',500,true,30,5,null,null,false)->setToolTip('Cabe�alho','Texto da dica');
$frm->addMemoField('dica4','Obs 2',500,true,20,5,false,false,false)->setToolTip('Cabe�alho','Texto da dica<table><tr><td>teste tabela </td></tr></table>');
$frm->setAction('Atualizar');
$frm->show();
?>
