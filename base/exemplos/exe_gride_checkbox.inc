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
$frm = new TForm('Gride Com Colunas Checkbox',480,500);
$frm->setFlat(false);

$frm->addSelectField('cod_uf','Uf:');
$frm->addTextField('nom_pessoa','Nome:','30',false,null,'Nome de Teste a��o');
$frm->addSelectField('cod_bioma','Bioma:',false,'1=Cerrado,2=Mata Atl�ntica,3=Bioma 3',null,null,null,true,4);

$frm->addGroupField('gp','Gr');
	$frm->addHtmlField('gride');
$frm->closeGroup();

$frm->addJsFile('jquery/facebox/facebox.js');
$frm->addCssFile('jquery/facebox/facebox.css');
$frm->addSelectField('cod_uf','Estado:')->setOptions($frm->getUfs("COD_UF,SIG_UF"));

$gride = new TGrid('gd5','Gride N� 5'
			,'TESTE.PKG_MOEDA.SEL_MOEDA'
			,50
			,null
			,null
			,null
			,null
			,null
			,'gd5OnDrawCell'
			,'gd5OnDrawRow'
			,null
			,'gd5onDrawButton'
			);
$gride->addExcelHeadField('Estado','cod_uf');
$gride->addExcelHeadField('Nome','nom_pessoa');
$gride->addExcelHeadField('Biomas','cod_bioma');

$gride->addCheckColumn('sig_moeda','SIGLA','SEQ_MOEDA','SIG_MOEDA')->setWidth(200);
//$gride->addSelectColumn('sig_moeda','SIGLA','SEQ_MOEDA','TESTE.PKG_MOEDA.SEL_MOEDA')->setWidth(200);
$gride->addColumn('SEQ_MOEDA','ID',100,'Center');
$gride->addButton('Selecionar 1',null,'btnSelecionar1','fwModalBox("Exemplo de subcadastro","index.php?modulo=base/exemplos/cad_fruta.inc",350,810)');
$gride->addButton('Selecionar 2',null,'btnSelecionar2','fwFaceBoxIframe("index.php?modulo=base/exemplos/cad_fruta.inc",310,810);');
$frm->getField('gride')->add($gride);
//$frm->addMemoField('memo','obs:',2000,false,60,10);
$frm->addButton('Teste');

$frm->setAction('Refresh');
$frm->show();
?>
<script>
function fRetorno()
{
	//alert( document.getElementById('memo').innerHTML);
	alert( document.getElementById('memo').value);
}
function btnTesteOnClick()
{


	//fwFaceBox('<textarea name="memo" id="memo" maxlength="2000" size="2000" cols="40" rows="10" wrap="virtual"></textarea>',false,200,300,fRetorno);
	//return;
	var ln = parseInt(fwGetObj('gd5').getAttribute('row_count'));
	for( i=1;i<=ln;i++)
	{
		var chk = fwGetObj('sig_moeda_'+i);
		if( chk )
		{
			if (chk.checked)
			{
				var v = trim(fwGetObj('sig_moeda_desc_'+i).innerHTML);
				alert( v );
			}
		}
	}
}
</script>
