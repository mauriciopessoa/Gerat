<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este arquivo é parte do Framework Formdin.
 *
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 *
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

error_reporting(E_ALL);

$frm = new TForm('Exemplo Mensagem',200);

$frm->addTextField('nome','Nome:',30);

$frm->addMessageField('msg_local');

//$frm->setPopUpMessage('Mensagem Utilizando o metodo setPopUpMessage da TForm',null,'sucess');

$frm->setAction('Refresh,Mensagem1,Mensagem2,Mensagem3,Mensagem4,Mensagem5,Popup1,Popup2,Popup3');
$frm->show();
?>
<script>
function btnMensagem1OnClick()
{
	fwShowMessage('Mensagem no form utilizando a funcao fwShowMessage<br>Linha2<br>Linha3<br>linha4...');
}
function btnMensagem2OnClick()
{
 	fwShowMessage({message:"Mensagem de erro no form","status":0});
}
function btnMensagem3OnClick()
{
 	fwShowMessage({message:"Mensagem de erro com alert","status":0,"alert":1});
}
function btnMensagem4OnClick()
{
 	fwShowMessage({message:"Mensagem com alert","status":1,"alert":1});
}
function btnMensagem5OnClick()
{
 	fwShowMessage({message:"Mensagem em local especifico<br>Linha2<br>linha3","containerId":"msg_local"});
}
function btnPopup1OnClick()
{
	parent.app_show_message("Mensagem Erro, Utilizando o metodo setPopUpMessage da TForm","error","5");
}
function btnPopup2OnClick()
{
	parent.app_show_message("Mensagem Sucesso, Utilizando o metodo setPopUpMessage da TForm","sucess","5");
}
function btnPopup3OnClick()
{
	parent.app_show_message("Mensagem Sucesso, Utilizando o metodo setPopUpMessage da TForm","attention","5");
}
</script>
