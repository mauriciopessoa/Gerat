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

$frm = new TForm('Estilos do Menu Principal',230,600);
$frm->setCss('background-color','#FAFAD2');
$frm->addHtmlField('current','')->setCss(array('font-size'=>14,'color'=>'blue','text-align'=>'center','margin-bottom'=>"10px"));
$frm->addButton('standard',null,'btn1','setMenu("standard")',null,true,false);
$frm->addButton('aqua_dark',null,'btn2','setMenu("aqua_dark")',null,false,false);
$frm->addButton('aqua_sky',null,'btn3','setMenu("aqua_sky")',null,false,false);
$frm->addButton('aqua_orange',null,'btn4','setMenu("aqua_orange")',null,false,false);
$frm->addButton('clear_blue',null,'btn5','setMenu("clear_blue")',null,false,false);
$frm->addButton('clear_green',null,'btn6','setMenu("clear_green")',null,false,false);

$frm->addButton('dhx_black',null,'btn7','setMenu("dhx_black")',null,true,false);
$frm->addButton('dhx_blue',null,'btn8','setMenu("dhx_blue")',null,false,false);
$frm->addButton('glassy_blue',null,'btn9','setMenu("glassy_blue")',null,false,false);
$frm->addButton('modern_black',null,'btn10','setMenu("modern_black")',null,false,false);
$frm->addButton('modern_black',null,'btn11','setMenu("modern_black")',null,false,false);
$frm->addButton('modern_blue',null,'btn12','setMenu("modern_blue")',null,false,false);

$frm->addButton('modern_red',null,'btn13','setMenu("modern_red")',null,true,false);
$frm->addButton('clear_silver',null,'btn14','setMenu("clear_silver")',null,false,false);

$frm->addHtmlField('message','Para alterar o tema do menu, adicione a linha <blink><b><span id="exemplo">$app->setMenuTheme("clear_silver");</span></b></blink> no index.php')->setCss(array('font-size'=>12,'color'=>'red','text-align'=>'center','font-weight'=>'normal','margin-top'=>'10px'));

$frm->addJavascript('jQuery("#current").html(top.menuTheme+"<br/>")');
$frm->show();
?>
<script>
function setMenu(tema)
{
	top.app_change_menu_theme(tema,'menu_principal.php');
	jQuery("#current").html(tema);
	jQuery("#exemplo").html('$app->setMenuTheme("'+tema+'");');

}
</script>

