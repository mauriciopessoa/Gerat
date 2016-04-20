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
$frm->addTextField('cod_unidade','C�digo:',10);
$frm->addTextField('nom_unidade','Unidade:',60);
$frm->addTextField('url_unidade','Url:',60);
$frm->addTextField('sig_unidade','Sigla:',60);


$frm->addGroupField('gpTree','Exemplo Treeview')->setcloseble(true);

// simulando consulta ao banco de dados
$res=null;
$res['COD_UNIDADE_PAI'][] = null;
$res['COD_UNIDADE'][] = 1;
$res['NOM_UNIDADE'][] = 'Presid�ncia';
$res['URL_UNIDADE'][] = 'www.presidencia_ibama.gov.br';
$res['SIG_UNIDADE'][] = 'PRESI';

$res['COD_UNIDADE_PAI'][] = 1;
$res['COD_UNIDADE'][] = 11;
$res['NOM_UNIDADE'][] = 'Dilretoria de Planejamento';
$res['URL_UNIDADE'][] = 'www.diplan_ibama.gov.br';
$res['SIG_UNIDADE'][] = 'DIPLAN';



$tree = $frm->addTreeField('tree',null,$res,'COD_UNIDADE_PAI','COD_UNIDADE','NOM_UNIDADE',null, array('SIG_UNIDADE','URL_UNIDADE') );
$tree->setStartExpanded(true);
$tree->setOnClick('treeClick'); // fefinir o evento que ser� chamado ao clicar no item da treeview
                                                                               
//$frm->setAction('Atualizar');
$frm->show();
?>
<script>
function treeClick(id)
{
	/*
	alert( 'Item id:'+treeJs.getSelectedItemId()+'\n'+
	'Item text:'+treeJs.getItemText(id )+'\n'+
	'User data URL:'+treeJs.getUserData(id,'URL_UNIDADE')
	);
	*/
	// atualizar os campos do formul�rio
	jQuery("#cod_unidade").val(treeJs.getSelectedItemId());
	jQuery("#nom_unidade").val(treeJs.getItemText(id ));
	jQuery("#url_unidade").val(treeJs.getUserData(id,'URL_UNIDADE'));
	jQuery("#sig_unidade").val(treeJs.getUserData(id,'SIG_UNIDADE'));
	
}
</script>
