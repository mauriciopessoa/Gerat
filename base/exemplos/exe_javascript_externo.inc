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
A classe TApplication prcourar� pelo aquivo javascript com o mesmo nome do modulo e com aextens�o .js na
pasta js/ do aplicativo. Se encontrar este ser� adicionado na p�gina gerada
*/
$frm = new TForm('Arquivos JS e CSS externos');
$frm->addTextField('nom_pessoa','Nome:',50,true,50,null,true,'Campo Texto','ex: texto livre',false,true);
$frm->addHtmlField('mensagem','<hr>Neste formul�rio foram inclu�dos os arquivos:<ul><li><b>js/exe_javascript_externo.js</b>;</li><li><b>css/exe_javascript_externo.css</b></li></ul><br>A classe TForm, automaticamente, procura pelos arquivos js e css, na pasta js/ e css/, que possuirem o mesmo nome do m�dulo postado.</b>');
$frm->getField('nom_pessoa')->addEvent('onBlur','if( this.value){Alerta2(this.value)}');
$frm->setAction('Refresh');
// pode ser adicionado arquivo js manualmente
$frm->addJsFile('teste.js');
if( $frm->getField('nom_pessoa')->validate() )
{
	$frm->setPopUpMessage('Campo Nome ok');
}
// pode ser adicionado arquivo css manualmente
$frm->addCssFile('teste.css');
$frm->show();
?>
