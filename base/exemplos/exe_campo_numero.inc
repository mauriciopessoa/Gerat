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


//$num = new TNumber('fnum','2.5678',10,null,6);
//echo $num->getValue();
//return;
//$strNewValue= '1,78.45';
//print 	preg_replace('/,/','',$strNewValue);

//phpinfo();
//return;
$frm = new TForm('Campo Num�rico');
//$frm->setAutoSize(true);
//$frm->setColumns(array(50,100,200,200));
$frm->addNumberField('num_pessoa'			,'Qtd:',9,false,2,true,null,5,null,null,null,true,true);
$frm->addNumberField('num_peso',             'Peso Unit�rio',4,true,2,false)->setExampleText('Kg');
$frm->addNumberField('num_peso2',            'Peso Unit�rio2',9,true,2,false)->setExampleText('Kg');

//$frm->addTag('<div style="border:1px dashed red;">');
//$frm->addNumberField('val_salario'	,'Sal�rio:',10,false,2,false);
//$frm->addNumberField('val_taxa'		,'Taxa:',10,false,4,null,null,null,null,null,null,null,null,null,null,'Informe a taxa de vari��o do valor');
//$frm->addSelectField('sit_cancelado','Cancelado?',null,'S=Sim,N=N�o')->addEvent('onChange','alert("oi")');
//$frm->addTag('</div>');
$frm->set('num_peso','1,5');
$frm->setAction('Gravar,Testar');

if($acao=='Gravart')
{
	if( $frm->validate())
	{
		//d($_POST);
		$bvars = $frm->createBvars('num_pessoa,val_salario,val_taxa');
		//d($bvars);
		$frm->setPopUpMessage('Valida��o OK');
	}
}
// exibir o formul�rio
$frm->show();
?>
<script>
function btnTestarOnClick()
{
	//var i=145741.587987;
	//alert( i.formatMoney(2) ) ; 
	//alert( fwAddPoints(i));
	//alert( fwAddPoints('123456'));
	//alert( fwAddPoints('1234.56'));
	//alert( fwAddPoints('1234,56'));
	//alert( fwAddPoints('555,234.56'));
}
</script>
