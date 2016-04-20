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

/**
 * @name grides/gride_condominio_offline.php
 * @author  Altamiro Rodrigues <altamiro27 at gmail dot com>
 * @since   2011-10-19
 * @version $Id: teste.php,v 1.3 2012/01/27 14:04:51 LUIS_EUGENIO_BARBOSA Exp $
 */

// arquivo de interno de configuracao do car(externo)
//require_once 'modulos/car_externo/config.php';

$frm = new TForm('Formul�rio de Cadastro de Clientes');
$frm->addHtmlField('msg','Exemplo de como alterar a inteface do formul�rio utilizando um arquvo css externo');
// adicionar o arquivo css ao formul�rio
$frm->addCssFile('css/css_form.css');


// exibir bordas simples
$frm->setFlat(true);

// remover o bot�o fechar original
$frm->hideCloseButton();

// adionar o conte�do do cabe�alho com no novo bot�o fechar
$frm->getHeaderButtonCell()->add('<table border="0" width="100%" height="100%" cellpadding="0px" cellspacing="0px" style="padding-right:2px;padding-top:2px;"><tr align="right"valign="bottom"><td></td></tr><tr align="right" valign="top"><td><img style="cursor:pointer;" src="imagem/btnFecharVermelho.jpg" alt="Fechar" width="18px" height="18px"  title="Fechar" onclick="fwConfirmCloseForm(\'formdin_area\',null,null,null);"></td></tr></table>');

// adicionar campo grupo para exemplo
$frm->addGroupField('bg1','Grupo de teste');
	$frm->addTextField('nome','Nome:',60);
$frm->closeGroup();

// exibir o formul�rio
$frm->show();
?>