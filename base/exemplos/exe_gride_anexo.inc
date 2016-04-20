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

session_start();
$frm = new TForm('Exemplo de Gride com Campo Anexo');
$frm->addHiddenField('seq_propriedade',22);
$frm->addFileField('anexo','Anexo:',true,'pdf,gif,txt,jpg',null,40,true,null,'callBackAnexar');
$frm->addButton('Limpar Tudo',null,'btnLimparTudo','btnLimparTudoClick()','Tem Certeza?',true,false);
$frm->addHtmlField('campo_gride');
// cria o gride via ajax
$frm->addJavascript('init()');


if( $acao == 'gravar_anexo')
{
	// grava na sess�o os dados do arquivo anexado. A chave � o nome do arquivo 
	// para evitar anexar o mesmo arquivo 2 vezes
	$_SESSION['meus_anexos'][ $_POST['nom_arquivo'] ] =  array('SEQ_PROPRIEDADE'=>$_POST['seq_propriedade'],'NOM_TEMP'=>$_POST['nom_temp']); 
	exit(0);
}
else if( $acao == 'limpar_tudo')
{
	$_SESSION['meus_anexos']=null;
	exit(0);
}
$frm->show();
?>
<script>
function init()
{
	fwGetGrid("base/exemplos/gride_anexos.php","campo_gride",{"seq_propriedade":""});
}
function callBackAnexar(tempName,fileName,type,size)
{
	jQuery('#nom_arquivo').val(fileName);
	jQuery('#nom_temp').val(tempName);
	jQuery.post(app_url+app_index_file,
	{
		'modulo':'base/exemplos/exe_gride_anexo.inc'
		,'formDinAcao':'gravar_anexo'
		,'nom_arquivo':fileName
		,'ajax':1
		,'nom_temp':tempName
		,'seq_propriedade':jQuery("#seq_propriedade").val()
	}
	,function( erro )
	{
		if( ! erro )
		{
			if( confirm('Visualizar o arquivo anexado ?'))
			{
				fwShowTempFile(tempName,type,fileName);
			}
			init(); // atualizar o gride
		}
		else
		{
			alert( erro ); // exibir o erro
		}
	});
}
function btnVisualizarClick(campos,valores)
{
		$aValores = valores.split('|');
		fwShowTempFile($aValores[0],null,$aValores[1]);
}
function btnLimparTudoClick()
{
	jQuery.post(app_url+app_index_file,
	{
		'modulo':'base/exemplos/exe_gride_anexo.inc'
		,'formDinAcao':'limpar_tudo'
		,'ajax':1
	}
	,function( erro )
	{
		if( ! erro )
		{
			init(); // atualizar o gride
		}
		else
		{
			alert( erro ); // exibir o erro
		}
	});	
}
</script>

