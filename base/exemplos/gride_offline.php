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
// criar o formulario com os campos off-line do gride
$frm = new TForm(null,200,450);
$frm->addHiddenField('num_pessoa'); // chave do gride
$frm->addTextField('nom_pessoa'		,'Nome:',30,true);
$frm->addDateField('dat_nascimento'	,'Nascimento:');
$frm->addSelectField('cod_uf'		,'Estado:');
// criar o gride
$grid = new TGrid('gdx','Gride Off-line',null,null,'100%',null,null,null,'gride_offline.php');
$grid->setForm($frm);
$grid->show();
*/

// criar o formulario com os campos off-line do gride
$frm = new TForm(null,200,500);
//$frm->addHiddenField('seq_moeda'); // chave do gride

$frm->addJavascript('gridCallBack()');
//$frm->addCpfCnpjField('cpf_cnpj'	,'CPF/CNPJ:',true);
//$frm->addTextField('nom_moeda'		,'Moeda:',30,true);
//$frm->addMemoField('obs_anexo','Obs:',100,false,20,5);
//$frm->addTextField('sig_moeda'		,'Sigla:',4,true);
//$frm->addTextField('nom_anexo'		,'Anexo:',50);
$frm->addTextField('tx_especie_nativa'		,'Especie:',50,true)->setExampleText('ex: mogno');
$frm->addTextField('des_nome_popular'		,'Nome Popular:',20);
$frm->setAutoComplete( 'tx_especie_nativa'
                       ,'CAR.PKG_CAD_CAR.SEL_TAXON'
                       ,'NOM_CIENTIFICO'
                       ,'DES_NOME_POPULAR'
                       ,false
                       ,null
                       ,null
                       ,4
                       ,1000
                       ,50
                       ,null
					   //,null,null,null,true
                       );

//$frm->addFileField('nom_arquivo'	,'Anexo Async:',true,'pdf,gif,txt,jpg',null,40,true);

//$frm->addSelectField('sit_cancelado','Cancelada:',true);
// criar o gride
//$grid = new TGrid('gdx','Gride Off-line','TESTE.PKG_MOEDA.SEL_MOEDA',null,'100%',null,null,null,'base/exemplos/gride_offline.php');
$res['SEQ_MOEDA'][0] 		= 1000;
$res['NOM_MOEDA'][0] 		= 'Dollar';
$res['SIG_MOEDA'][0] 		= 'US$';
$res['NOM_ANEXO'][0] 		= 'imagem.jpg';
$res['TX_ESPECIE_NATIVA'][0] = 'Nome da especie nativa';
$res['OBS_ANEXO'][0] 		= 'asd�fkasd fasdfasdfasdfasdfasd fasdf asdf asdf';
$res['DES_NOME_POPULAR'][0] 		= 'Nome popular teste';
$res['SIT_CANCELADO'][0] 	= 'N';
//$res=null;
$grid = new TGrid('gdx','Gride Off-line',$res,null,550,'SEQ_MOEDA',null,null,'base/exemplos/gride_offline.php');
$grid->setForm($frm,false);
$grid->show();

/*
 * $tb = new TTable();
$tb->setCss('font-size','12px');
$row = $tb->addRow();
$row->addCell('<center>Exemplo dos dados do Grid que est�o na vari�vel de sess�o:<br><b>$_SESSION[APLICATIVO]["offline"]["gdx"]</b></center>');
$row = $tb->addRow();
$row->addCell('<pre><div style="border:1px dashed black;width:540px;height:150px;overflow:hidden;overflow-y:auto;">'.print_r($_SESSION[APLICATIVO]['offline']['gdx'],true).'</div></pre>');
$tb->show();
 *
 */
?>
