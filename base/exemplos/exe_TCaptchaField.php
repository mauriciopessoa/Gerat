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

$frm = new TForm('Teste Campo Captcha',300);
$frm->addHtmlField('texto','<p><h3>O termo, CAPTCHA, � um acr�nimo para <b>Completely Automated Public Turing Test to Tell Computers and Humans Apart</b> ou, numa tradu��o direta, teste de Turing p�blico completamente automatizado para diferencia��o entre computadores e humanos.<br>Leia mais em: <a target="_blank" href="http://www.tecmundo.com.br/2861-o-que-e-captcha-.htm#ixzz1qVPUhQeZ">Captcha</a></h3></p>');


$frm->addCaptchaField('campo_captcha','C�d. Seguran�a:','Captcha - Clique aqui para gerar nova combina��o');

// centralizado no formul�rio
$frm->addCaptchaField('captcha_center',null)->setAttribute('align','center');

$frm->setAction('Gravar');
$frm->addButtonAjax('Gravar Ajax',null,'fwValidateFields()','callbackGravar','Gravar','Gravando...','text',false,null,'btnGravarAjax');
if( isset($acao) && $acao == 'Gravar')
{
	if( $_POST['campo_captcha'] != $_SESSION['campo_captcha_code'] )
	{
		$frm->setError('Caracteres informados incorretamente!');
	}
	else
	{
		$frm->setMessage('Captcha OK');
	}
}
$frm->show();
?>
<script>
function callbackGravar(res)
{
	alert( res );
}
</script>