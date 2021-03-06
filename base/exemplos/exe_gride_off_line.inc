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


include('base/classes/FormDin3.func.inc');
$frm = new TForm('Gride OFF-LINE',300,600);
$frm->addSelectField('seq_impureza_metal','Metal',false,'1=Chumbo,2=Arsenio,3=Cromo')->addEvent('onChange','this.form.chave_gride_impureza_metalica.value=this.options[this.selectedIndex].value');
$frm->addSelectField('cod_impureza_comp','Valor (mg/kg)',false,array('='=>'=','>'=>'&gt;','<'=>'&lt;'),false,false,null,null,null,null,'--');
$frm->addNumberField('val_impureza_metalica','',7,true,4,false,null,0,1000);
$frm->addHiddenField('chave_gride_impureza_metalica');
$frm->addButton('+',null,'btn_gride_impureza_metalica','gride_linha_alterar(this)',null,false,false,null,null,'Clique aqui para adicionar metal � lista');
$frm->addHtmlField('gride_impureza');
$frm->setAction('Gravar');

$arrSeq_impureza_metal = $frm->getField('seq_impureza_metal')->getOptions();
if ( is_array($_POST['text_seq_impureza_metal']) ) {
	foreach ( $_POST['text_seq_impureza_metal'] as $k=>$v ) {
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['SEQ_IMPUREZA_METALICA'][] = $_POST['text_seq_impureza_metal'][$k];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['DES_IMPUREZA_METALICA'][] = $arrSeq_impureza_metal[ $_POST['text_seq_impureza_metal'][$k] ];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['COD_IMPUREZA_COMP'][] = $_POST['text_cod_impureza_comp'][$k];
		$bvars_prd['CURSOR_IMPUREZA_METALICA']['VAL_IMPUREZA_METALICA'][] = $_POST['text_val_impureza_metalica'][$k];
	}
}

$frm->setValue('gride_impureza'
	,'<br>'.criarGride('gride_impureza_metalica'
	,''
	,$bvars_prd['CURSOR_IMPUREZA_METALICA']
	,null
	,($soLeitura?'':'Editar\Clique aqui para editar registro\base/imagens/editar.gif\ \gride_linha_editar(this)|
	  Remover\Clique aqui para remover registro\base/imagens/cancelhabilitada.gif\ \gride_linha_remover(this)')
	,'SEQ_IMPUREZA_METALICA' // campos atualizar na tela,
	,'text_seq_impureza_metal/0/text/SEQ_IMPUREZA_METALICA
	 `DES_IMPUREZA_METALICA|Metal
	 `text_cod_impureza_comp/0/text/COD_IMPUREZA_COMP
	 `COD_IMPUREZA_COMP|&lt;=
	 `text_val_impureza_metalica/0/text/VAL_IMPUREZA_METALICA
	 `VAL_IMPUREZA_METALICA|Valor (mg/kg)
	 ' // colunas do gride
	,0,null,null,null,null,null,null,'Nenhum registro encontrado',null
	,'ALINHAMENTO_TEXTO|VAL_IMPUREZA_METALICA||right
	 `ALINHAMENTO_TEXTO|COD_IMPUREZA_COMP||center' //$configuracao
	,false,null,null,null,null ,null,null ,null,null,null,null,false,null,false));
$frm->show();


/*
include('base/classes/FormDin3.func.inc');
include('base/classes/FormDin3.class.php');
$aCampos['val_salario'] = new CampoDecimal('val_salario','Sal�rio:',false,null,null,null,null,15,null,null,null,null,2,null,null,true);
$aCampos['des_email']	= new CampoEmail('des_email','Email:');
$frm = new FormDin3($aCampos,'Teste Decimal',$_POST);
$frm->adicionarCampoDecimal('val_salario2','Sal�rio2:',false,null,null,2,15);
$frm->setEvento('des_email',array('onKeyPress'=>'return disabilitarTeclaCtrl(event,"v");'));
print $frm->criarForm();
*/
?>
<script>
function disabilitarTeclaCtrl(e,teclas)
{
	var teclasProibidas;
	if( teclas )
	{
		var teclasProibidas = teclas.slice(',');
	}
	else
	{
		//Lista de todas as combina��es de CTRL + key que voce quer desativar
		teclasProibidas = new Array('a', 'n', 'c', 'x', 'v', 'j');
	}
	var key;
	var isCtrl;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
		if(window.event.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	else
	{
		key = e.which;     //firefox
		if(e.ctrlKey)
			isCtrl = true;
		else
		isCtrl = false;
	}
	if(isCtrl)
	{
		for(i=0; i<teclasProibidas .length; i++)
		{
			if(teclasProibidas[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
			{
				key=0;   
				return false;
			}
		}
	}
	return true;
}
</script>
