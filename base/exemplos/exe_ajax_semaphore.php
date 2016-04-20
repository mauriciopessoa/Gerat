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

$frm = new TForm('Exemplo de Ajax usando Sem�foro', 400, 600);

$frm->addTextField('id_semaforo','ID sem�foro:',20,true,20,'semaforo_1',null,'Informe uma string para identificar o semaforo')->add('<span id="imagem"></span>');

$frm->addHtmlField('msg', '<p>Ao fazer uma requisi��o Ajax com sem�foro, o sem�foro fica "fechado" at� que a chamada retorne.<BR />
						   Uma nova chamada com o mesmo sem�foro s� � realizada se o sem�foro estiver aberto.<BR />
						   Utilizando a fun��o javascript "fwSemaphoreIsOpen(idSemaphore)" � poss�vel verifiar se o sem�foro est� aberto ou fecahdo.</p>')->setcss('font-size','12px');

$frm->addButton('Chamar ajax com Sem�foro', null, 'btnAjax', 'chamarAjax()');
$frm->addButton('Verificar Sem�foro', null, 'btnVerfificar', 'verificarSemaforo()');

if( $acao == 'ajax_lento') {
	sleep(20);
	echo 'Voltei depois de 20 segundos!';
}
$frm->setAction('Atualizar');
$frm->show();

?>


<script>
function chamarAjax()
{
	var id = jQuery('#id_semaforo').val();
	if( ! fwSemaphoreIsOpen( id ) )
	{
		jAlert('Esta a��o j� esta sendo executada');
		return;
	}
	var chamada = fwAjaxRequest({
		'action':'ajax_lento',
		'async':true,
		'dataType':'text',
		'semaphore': id,
		'semaphoreTimeout':10000,
		'containerId':'imagem',
		'msgLoading':fw_img_processando1,
		'callback':function(res) {
			fwAlert('Requisi��o com sem�foro "' + id + '" retornada!\n\nMensagem de retorno:\n' + res);
		}
	});
	fwAlert(chamada !== false? 'Requisi��o Ajax chamada com o sem�foro "' + id + '"': 'Requisi��o Ajax N�O foi chamada pois o sem�foro "' + id + '" est� FECHADO!');
}

function verificarSemaforo() {
	var id = jQuery('#id_semaforo').val();
	var status = fwSemaphoreIsOpen(id);
	fwAlert('Sem�foro "' + id + '" est� ' + (status ? 'ABERTO' : 'FECHADO') );
}
</script>
