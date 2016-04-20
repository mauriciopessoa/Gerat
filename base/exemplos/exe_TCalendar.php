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

 // criar 2 eventos no calend�rio
if( $_REQUEST['ajax'] )
{

	// ver todos os atributos do evento em : http://arshaw.com/fullcalendar/docs/event_data/Event_Object/
	echo json_encode(array(

		array(
			'id' => 111,
			'title' => utf8_encode("Reuni�o as 13:00"),
			'start' => date('Y-m-d'),
			'url' => "http://yahoo.com/"
		),

		array(
			'id' => 222,
			'title' => utf8_encode("Viagem a servi�o"),
			'start' => "2012-04-20",
			'end' => "2012-04-21",
			'url' => "http://yahoo.com/"
		)

	));
	die();

}

$frm = new TForm('Exemplo Agenda');
$f = $frm->addCalendarField('agenda','exe_TCalendar.php',400,null,null,null,null,null,'onEventClick','onSelectDay');
$frm->setAction('Atualizar');
$frm->show();
?>
<script>
function onEventClick( event, jsEvent, view )
{
	// ajuda em: http://arshaw.com/fullcalendar/docs/mouse/eventClick/
	alert( 'Event Clicado');
}
function onSelectDay(  date, allDay, jsEvent, view )
{
	// ajuda em : http://arshaw.com/fullcalendar/docs/mouse/dayClick/
	alert( 'Dia selecionado');
}
</script>