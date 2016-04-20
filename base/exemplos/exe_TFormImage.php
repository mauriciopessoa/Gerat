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
$frm = new TFormImage(null,'./imagem/frm_login.png');
$frm->setRequiredFieldText('');
$frm->setShowCloseButton(false);

// posicionar os controles sobre a imagem no lugar correto utilizando o metodo setXY()
$btn = $frm->addButton('Imagem',null,null,'alert("Validar Acesso")',null,true,true,'imagem/botao_transparente.png',null,'Validar');
//$btn = $frm->addButton('Imagem',null,null,'alert("Validar Acesso")',null,true,true,'imagem/botao_branco.png');
$btn->setXY(315,160);

$f1 = $frm->addTextField('login','',300,true,22);
$f1->setcss('height',25)->setCss('border','0px solid red')->setCss('background','transparent')->setCss('font-size','14px')->setCss('color','#0000FF')->setCss('font-weight','bold');
$f1->setXY(212,74);

$f2 = $frm->addPasswordField('senha','',true,true,300,null,null,null,22);
$f2->setCss(array('height'=>'25','border'=>'0px solid red','background'=>'transparent','font-size'=>'14px','color'=>'#ff0000','font-weight'=>'bold') );
$f2->setXY(212,107);

$frm->show();
?>