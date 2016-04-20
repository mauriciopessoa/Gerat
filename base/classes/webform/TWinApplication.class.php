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

include( 'autoload_formdin.php');
class TWinApplication   extends THtmlPage
{
	public function __construct()
	{
		parent::__construct();
		$this->addJsCssFile('prototype/themes/default.css');
		$this->addJsCssFile('prototype/themes/lighting.css');
		$this->addJsCssFile('prototype/themes/mac_os_x.css');
		$this->addJsCssFile('prototype/themes/alphacube.css');
		$this->addJsCssFile('app_prototype.css');
		$this->addJsCssFile('dhtmlx/codebase/skins/dhtmlxmenu_clear_silver.css');
		$this->addJsCssFile('prototype/prototype.js');
		$this->addJsCssFile('prototype/effects.js');
		$this->addJsCssFile('prototype/window.js');
		$this->addJsCssFile('prototype/window_ext.js');
		$this->addJsCssFile('prototype/window_effects.js');
		$this->addJsCssFile('prototype/javascripts/debug.js');
		$this->addJsCssFile('dhtmlx/codebase/dhtmlxcommon.js');
		$this->addJsCssFile('dhtmlx/codebase/dhtmlxmenu_cas.js');
		$this->addJsCssFile('app_prototype.js');

		$divTitle = new TElement('div');
		$divTitle->setId('app_header_title');
		$divTitle->setProperty('align','center');
		$this->addInBody($divTitle);
		//div menu principal
		$div = new TElement('div');
		$div->setId('div_main_menu');
		$div->setProperty('align','center');
		$this->addInBody($div);
		// area de trabalho
		$div = new TElement('div');
		$div->setId('dock');
		$this->addInBody($div);

		$divTheme = new TElement('div');
		$divTheme->setId('theme');
		$divTheme->add('Tema:');
		$divTheme->add(new TSelect('appTheme','0=Cinza Claro,1=Mac Os X,2=Azul Claro,3=Verde Claro',null,null,null,nulll,nulll,''));
		$div->add($divTheme);
	}
}
?>