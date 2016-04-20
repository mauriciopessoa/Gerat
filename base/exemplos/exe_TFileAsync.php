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

$frm = new TForm('Exemplo Campo Arquivo Assincrono',300,700);

// define a largura das colunas verticais do formulario para alinhamento dos campos
$frm->setColumns(array(100,100));
$frm->addFileField('anexo_async','Anexo Async:',true,'pdf,gif,txt,jpg,rar,zip,doc','2M',40,true,null,'callBackAnexar');
$frm->addTextField('arquivo','Arquivo:',60);
$frm->addTextField('tipo'	,'Tipo:',40);
$frm->addTextField('tamanho','Tamanho (kb):',20);
$frm->addTextField('local'	,'Local temp:',60);

//d($_SESSION);
//d($_POST);
//print_r(file_put_contents($frm->getBase().'tmp/upload_'.md5(session_id().$res_alt['DES_ARQUIVO'][0]),'teste') );

$frm->setAction('Gravar,Novo');

switch($acao)
{
	case 'Gravar':
	{
		$frm->validate();
		//$bvars = $frm->createBvars('anexo1,anexo2');
		//d($bvars);
	}
}
$frm->show();
?>
<script>
function callBackAnexar(tempName,fileName,type,size)
{
	jQuery('#arquivo').val(fileName);
	jQuery('#local').val(tempName);
	jQuery('#tamanho').val(size);
	jQuery('#tipo').val(type);
	//alert('Fun��o de callback.\n\nTemp name:'+tempName+'\nFile name:'+fileName+'\nType:'+type+'\nSize?'+size);
	if( confirm('Visualizar o arquivo anexado ?'))
	{
		fwShowTempFile(tempName,type,fileName);
	}
}
</script>

