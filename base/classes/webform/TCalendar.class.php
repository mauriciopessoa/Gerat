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

class TCalendar extends TControl
{
	private $height;
	private $contentHeight;
	private $aspectRatio;
	private $showHeader;
	private $showTitle;
	private $showNavigatorButtons;
	private $showTodayButton;
	private $showDayButton;
	private $showMonthButton;
	private $showWeekButton;
	private $showWeekends;
	private $basicView;
	private $buttons;
	private $views;
	private $url;

	private $jsOnResize;
	private $jsOnDrag;
	private $jsOnDrop;
	private $jsOnEventClick;
	private $jsOnSelectDay;
	private $jsMouseOver;
	private $jsEventRender;
	private $jsViewDisplay;
	private $defaultView;

	public function __construct($strName, $strUrl=null,  $strHeight=null, $strWidth=null, $defaultView=null, $jsOnResize=null, $jsOnDrag=null, $jsOnDrop=null, $jsOnEventClick=null, $jsOnSelectDay=null, $jsMouseOver=null, $jsEventRender=null, $jsViewDisplay=null)
	{
		//parent::__construct('fieldset',$strName);
		parent::__construct('div', $strName);
		parent::setFieldType('fullcalendar');
		$this->setClass('fwHtml');
		$this->setCss('margin','0');
		$this->setUrl($strUrl);
		$this->setWidth($strWidth);
		$this->setHeight($strHeight);
		$this->setJsOnResize($jsOnResize);
		$this->setJsOnDrag($jsOnDrag);
		$this->setJsOnDrop($jsOnDrop);
		$this->setJsOnEventClick($jsOnEventClick);
		$this->setJsMouseOver($jsMouseOver);
		$this->setDefaultView($defaultView);
		$this->setJsOnSelectDay($jsOnSelectDay);
		$this->setJsEventRender($jsEventRender);
		$this->setJsViewDisplay($jsViewDisplay);
//		$this->setIncludeFile($strIncludeFile);
//		$this->setLoadingMessage($strLoadingMessage);
	}

	//-------------------------------------------------------------------------------------
	public function show($print=true)
	{
		$script=new TElement('<script>');
		$script->add('
		jQuery(document).ready(function() {

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var selecionavel;

		jQuery("#'. $this->getName(). '").fullCalendar({
			'.( ($aux=$this->getAspectRatio()) ? "aspectRatio: {$aux}," : '' ) .'
			'.( ($aux=$this->getHeight()) ? "height: {$aux}," : '' ) .'
			'.( ($aux=$this->getContentHeight()) ? "contentHeight: {$aux}," : '' ) .'
			theme: true,
			monthNames: ["Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho",
						"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
			monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
 								"Jul", "Ago", "Set", "Out", "Nov", "Dec"],
 			dayNames: ["Domingo", "Segunda", "Ter�a", "Quarta", "Quinta", "Sexta", "Sabado"],
 			dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
 			allDayText : "Dia todo",
 			firstHour : 6,
 			buttonText: {
 							today:    "Hoje",
    						month:    "M�s",
    						week:     "Semana",
    						day:      "Dia"
						},
			header: ' .
				($this->getShowHeader() == false ?
					'false' :
					'{
						left: "' .
							($this->getShowNavigatorButtons() ? 'prev,next' : '') .
							($this->getShowTodayButton() ? ',today' : '') .
							'",
						center: "' .
							($this->getShowTitle() ? 'title' : '') .
							'",
						right: "' .
							($this->getShowMonthButton() ? 'month' : '') .
							($this->getShowWeekButton() ? ','.$this->getView().'Week' : '') .
							($this->getShowDayButton() ? ','.$this->getView().'Day' : '') .
							'"
					}') . ',
			loading: function (carregando) {
						selecionavel = !carregando;},
			lazyFetching: false,
			defaultView: "' . ($this->getDefaultView() ? $this->getDefaultView() : "month") . '",
			weekends: ' . ($this->getShowWeekends() ? 'true' : 'false') . ' ,

			eventSources: [ {
	            url: "'.$this->getUrl().'",
	            type: "POST",
	            data: { ajax:1 },
	            error: function() {  alert("Erro ao carregar os eventos da Agenda!");}
	        	}],
			eventResize: '.($this->getJsOnResize() ? $this->getJsOnResize() : 'null').',
			eventDragStart: '.($this->getJsOnDrag() ? $this->getJsOnDrag() : 'null').',
			eventDrop: '.($this->getJsOnDrop() ? $this->getJsOnDrop() : 'null').',
			eventClick: '.($this->getJsOnEventClick() ? $this->getJsOnEventClick() : 'null').',
			eventMouseover: '.($this->getJsMouseOver() ? $this->getJsMouseOver() : 'null').',
			editable: '.($this->getReadOnly() ? 'false' : 'true').',
			eventRender: '.($this->getJsEventRender() ? $this->getJsEventRender() : 'null').',
			selectable: '.($this->getJsOnSelectDay() ? 'true' : 'false').',
			select: '.($this->getJsOnSelectDay() ? $this->getJsOnSelectDay() : 'null').',

			viewDisplay: '.($this->getJsViewDisplay() ? $this->getJsViewDisplay() : 'null').'
			});
		});
		');
		//$this->add();

	 	return parent::show($print).$script->show($print);
	}
/*
select: function (dataInicial, dataFinal) {
if (selecionavel) {
// Executa c�digo
}}*/
	//-------------------------------------------------------------------------------------

	/**
	 * @param integer $newHeight Tamanho da �rea total ocupada pelo calend�rio
	 * @return TCalendar
	 */
	public function setHeight($newHeight=null)
	{
		parent::setHeight($newHeight);
		$this->height = (int) ($newHeight - 10);
        return $this;
	}
	public function getHeight()
	{
		return ( is_integer($this->height) ) ? $this->height : null;
	}

	/**
	 * @param integer $newContentHeight Tamanho do calend�rio
	 * @return TCalendar
	 */
	public function setContentHeight($newContentHeight=null)
	{
		$this->contentHeight = $newContentHeight;
        return $this;
	}
	public function getContentHeight()
	{
		return ( is_integer($this->contentHeight) ) ? $this->contentHeight : null;
	}

	/**
	 * @param float $newAspectRatio Propor��o entra largura e altura do calend�rio
	 * @return TCalendar
	 */
	public function setAspectRatio($newAspectRatio=null)
	{
		$this->aspectRatio = $newAspectRatio;
        return $this;
	}
	public function getAspectRatio()
	{
		return ( is_integer($this->aspectRatio) ) ? $this->aspectRatio : null;
	}

	/**
	 * @param boolean $boolShowHeader Informa se deve exibir o cabe�alho
	 * @return TCalendar
	 */
	public function setShowHeader($boolShowHeader=null)
	{
		$this->showHeader = $boolShowHeader;
        return $this;
	}
	public function getShowHeader()
	{
		return ( $this->showHeader === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowTitle Informa se deve exibir o t�tulo "Ex: Janeiro 2000".
	 * @return TCalendar
	 */
	public function setShowTitle($boolShowTitle=null)
	{
		$this->showTitle = $boolShowTitle;
        return $this;
	}
	public function getShowTitle()
	{
		return ( $this->showTitle === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowNavigatorButtons Informa se deve exibir os bot�es de navega��o (anterior e pr�ximo).
	 * @return TCalendar
	 */
	public function setShowNavigatorButtons($boolShowNavigatorButtons=null)
	{
		$this->showNavigatorButtons = $boolShowNavigatorButtons;
        return $this;
	}
	public function getShowNavigatorButtons()
	{
		return ( $this->showNavigatorButtons === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowTodayButton Informa se deve exibir o bot�o "Hoje".
	 * @return TCalendar
	 */
	public function setShowTodayButton($boolShowTodayButton=null)
	{
		$this->showTodayButton = $boolShowTodayButton;
        return $this;
	}
	public function getShowTodayButton()
	{
		return ( $this->showTodayButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowMonthButton Informa se deve exibir o bot�o "M�s".
	 * @return TCalendar
	 */
	public function setShowMonthButton($boolShowMonthButton=null)
	{
		$this->showMonthButton = $boolShowMonthButton;
        return $this;
	}
	public function getShowMonthButton()
	{
		return ( $this->showMonthButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowDayButton Informa se deve exibir o bot�o "Dia".
	 * @return TCalendar
	 */
	public function setShowDayButton($boolShowDayButton=null)
	{
		$this->showDayButton = $boolShowDayButton;
        return $this;
	}
	public function getShowDayButton()
	{
		return ( $this->showDayButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolShowWeekButton Informa se deve exibir o bot�o "Semana".
	 * @return TCalendar
	 */
	public function setShowWeekButton($boolShowWeekButton=null)
	{
		$this->showWeekButton = $boolShowWeekButton;
        return $this;
	}
	public function getShowWeekButton()
	{
		return ( $this->showWeekButton === false) ? false : true;
	}

	/**
	 * @param boolean $boolBasicView Define tipo de vis�o dos calend�rios "Semana" e "Dia" para b�sica ou completa.
	 * @return TCalendar
	 */
	public function setBasicView($boolBasicView=null)
	{
		$this->basicView = $boolBasicView;
        return $this;
	}
	public function getBasicView()
	{
		return ( $this->basicView === true) ? true : false;
	}
	protected function getView() {
		return ($this->getbasicView() ? 'basic' : 'agenda');
	}

	/**
	 * @param boolean $boolShowWeekends Informa se deve exibir fins de semana no calend�rio (s�bado e domingo).
	 * @return TCalendar
	 */
	public function setShowWeekends($boolShowWeekends=null)
	{
		$this->showWeekends = $boolShowWeekends;
        return $this;
	}
	public function getShowWeekends()
	{
		return ( $this->showWeekends === false) ? false : true;
	}
	/**
	 *  str $strNewvalue Define a url onde os eventos ser�o carregados
	 *  Ex. array(array("title"=>'Titulo do evento', "start"=>'2011-12-03', "end"=>'2011-12-04')
	 *  Evento deve ser retornado pelo: echo json_encode($retorno);
	 * @param $strNewvalue
	 */
	public function setUrl( $strNewvalue = null)
	{
		$this->url = $strNewvalue;
	}
	public function getUrl()
	{
		return $this->url;
	}
	/**
	 *
	 * @param unknown_type $jsOnResize
	 */
	public function setJsOnResize($jsOnResize=null)
	{
		$this->jsOnResize = $jsOnResize;
	}
	public function getJsOnResize()
	{
		return $this->jsOnResize;
	}
	/**
	 *
	 * @param unknown_type $jsOnDrag
	 */
	public function setJsOnDrag($jsOnDrag=null)
	{
		$this->jsOnDrag = $jsOnDrag;
	}
	public function getJsOnDrag()
	{
		return $this->jsOnDrag;
	}
	/**
	 *
	 * @param unknown_type $jsOnDrop
	 */
	public function setJsOnDrop($jsOnDrop=null)
	{
		$this->jsOnDrop = $jsOnDrop;
	}
	public function getJsOnDrop()
	{
		return $this->jsOnDrop;
	}

	/**
	 * @param str $jsOnEventClick Informa qual metodo javascript tratara o evento de clicar sobre um evento
	 *
	 * Deve possuir a assinatura(calEvent, jsEvent, view)
	 * calEvent -> possui os dados do evento. (Padr�o: calEvent.title, calEvent.start, calEvent.end) ou os que definiu ex. calEvent.descricao
	 * jsEvent -> mostrara as coordenadas
	 * view -> a vis�o ativa do calendario
	 *
	 * @return TCalendar
	 */
		public function setJsOnEventClick($jsOnEventClick=null)
		{
			$this->jsOnEventClick = $jsOnEventClick;
		}
		public function getJsOnEventClick()
		{
			return $this->jsOnEventClick;
		}

	/**
	 * @param str $jsMouseOver Informa qual metodo javascript tratara o evento mouseover
	 *
	 * Deve possuir a assinatura ( event, jsEvent, view )
	 * @return TCalendar
	 */
		public function setJsMouseOver($jsMouseOver=null)
		{
			$this->jsMouseOver = $jsMouseOver;
		}
		public function getJsMouseOver()
		{
			return $this->jsMouseOver;
		}

	/**
	 * @param str $defaultView Informa qual deve ser a visualiza��o padr�o do calend�rio, padr�o month. ex:(basicWeek, basicDay, agendaWeek, agendaDay).
	 * @return TCalendar
	 */
		public function setDefaultView($defaultView=null)
		{
			$this->defaultView = $defaultView;
		}
		public function getDefaultView()
		{
			return $this->defaultView;
		}


		public function setJsEventRender($jsEventRender=null)
		{
			$this->jsEventRender = $jsEventRender;
		}
		public function getJsEventRender()
		{
			return $this->jsEventRender;
		}

		public function setJsOnSelectDay($jsOnSelectDay=null)
		{
			$this->jsOnSelectDay = $jsOnSelectDay;
		}
		public function getJsOnSelectDay()
		{
			return $this->jsOnSelectDay;
		}

		public function setJsViewDisplay($jsViewDisplay=null)
		{
			$this->jsViewDisplay = $jsViewDisplay;
		}
		public function getJsViewDisplay()
		{
			return $this->jsViewDisplay;
		}
}
?>