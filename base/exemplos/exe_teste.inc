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

$res['NUM_PESSOA'][0] = 1;
$res['NOM_PESSOA'][0] = 'Luis Eug�nio';
$res['VAL_SALARIO'][0] = '1.500,00';
$frm = new TForm('Gride Editavel');
$frm->addTextField('tx_especie_nativa','Esp�cie:',80);
$frm->setAutoComplete( 'tx_especie_nativa'
                       ,'CAR.PKG_CAD_CAR.SEL_TAXON'
                       ,'NOM_CIENTIFICO_POPULAR'
                       ,'SEQ_TAXONOMIA,DES_NOME_POPULAR'
                       ,true
                       ,null
                       ,'callback_autocomplete_especies()'
                       ,4
                       ,1000
                       ,50
                       ,null
                       );



$g = new TGrid('gd','Edit',$res,null,null,'NUM_PESSOA');
$g->addRowNumColumn();
$g->addTextColumn('nom_pessoa','Nome','NOM_PESSOA',20,20);
$col = $g->addNumberColumn('val_salario','Sal�rio','VAL_SALARIO',10,2);
$col->addEvent('onChange','alert("Salvar:"+this.value);this.style.fontWeight="bold"');
//$col->setCss('border','0px');
$g->addDateColumn('dat_nascimento','Data:','DAT_NASCIMENTO');

$frm->addHtmlField('gride',$g);
$frm->setAction('Refresh');
$frm->show();
?>
