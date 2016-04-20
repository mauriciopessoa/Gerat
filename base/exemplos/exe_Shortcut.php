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

//define('REQUIRED_FIELD_MARK','*');
$frm = new TForm('Exemplo do Teclas de Atalho');


$frm->addTextField('fld_nome','Nome:',60,false,60,null,null,null,null,null);
$frm->addTextField('fld_endereco','Endere�o:',40,false,40,null,null,null,null,null);
$frm->addTextField('fld_telefone','Tele&fone:',20,false,20,null,null,null,null,null);
$frm->addMemoField('memo','&Obs:',2000,false,30,3);

$pc = $frm->addPageControl('pc',null,null,null,null);
	$p = $pc->addPage('F9|Cadastro A��o',true,true,'aba1',null);
		$frm->addTextField('acao','&A��o:',20,true);

	$p = $pc->addPage('&Pesquisa',false,true,'aba2',false);

		$pc2 = $frm->addPageControl('pc2',null,null,null,null);
		$pc2->addPage('&Sub Pesquisa',true,true,'aba21');
			$frm->addGroupField('gp1','Grupo');
   				$frm->addTextField('pesquisa','Pes&quisa:',20,true);
   			$frm->closeGroup();


$frm->addShortcut('F10','btnVoltar');
$frm->addShortcut('F2','fld_nome');
$frm->addShortcut('F8',null,null,'alert(1)');
$frm->addShortcut('ALT+E','fld_endereco');


$frm->addButton('&Salvar',null,'btnSalvar',null,null,false,false);
$frm->addButton('&Imprimir',null,'btnImprimir');
$frm->addButton('Voltar',null,'btnVoltar');


$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init()
{
   //	fwApplyShortcuts();
}
</script>