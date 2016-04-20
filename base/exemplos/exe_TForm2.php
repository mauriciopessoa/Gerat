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
//d($_REQUEST);
if( $_REQUEST['subform'] == 1)
{
	//require_once('../classes/FormDin3.class.php');
	//$f = new FormDin3(null,'Teste');
	//echo $f->criarForm();
	//die();
}

$frm = new TForm('Exemplo de Subcadastro',200);


/*$frm->addJsFile('prototype/prototype.js',true);
$frm->addJsFile('prototype/window.js');
$frm->addJsFile('prototype/window_ext.js');
$frm->addCssFile('prototype/themes/alphacube.css');
  */
$frm->addTextField('nome','Nome:',null,false);
$frm->addTextField('nome2','Nome Subcadastro:',null,false)->setReadOnly(true);

$frm->setonMaximize('onMaximize');
$frm->addButton('Subcadastro',null,'btn3','subcadastro()');
$frm->show();

?>
<script>
function subcadastro()
{
	// Passsando o campo nome como json. Se n�o for informado o valor, ser� lido do formul�rio
	//fwModalBox('Este � um Subcadastro','../teste.php');
	//fwModalBox('Este � um Subcadastro','www.globo.com.br');
	fwModalBox('Este � um Subcadastro',app_index_file+'?modulo=exe_TForm.php',380,820,callbackModaBox,{'nome':''});
}

/**
* A fun��o de callback da janela modal, recebe 2 parametros:
* 1) array com todos os campos do formul�rio do subcadastro
* 2) instancia do objeto document do subcadastro
*/
function callbackModaBox(data, doc )
{
	var msg;
    // exemplo de tratamento do retorno do subcadastro
	msg = 'A fun��o callbackModalBox() foi executada!\n\nAcessando os dados da janela modal:\n'+'Campo nome = '+data.nome+'\nCores:'+String(data.cor);
	try{
		msg+='\n\n A cor '+data.cor[0]+' foi selecionada';
	} catch(e){};
	jQuery("#nome2").val(data.nome);
	msg +='\n\nUsando getElementById("nome").value='+doc.getElementById('nome').value;
	alert( msg );
}
</script>