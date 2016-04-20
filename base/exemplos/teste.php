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

/**
 * @name grides/gride_condominio_offline.php
 * @author  Altamiro Rodrigues <altamiro27 at gmail dot com>
 * @since   2011-10-19
 * @version $Id: teste.php,v 1.3 2012/01/27 14:04:51 LUIS_EUGENIO_BARBOSA Exp $
 */

// arquivo de interno de configuracao do car(externo)
//require_once 'modulos/car_externo/config.php';

$frm = new TForm('Teste Geral');
$frm->setFocusField( 'nom_condomino' );
$frm->addTextField( 'nom_condominio' , 'Nome' , 50 , TRUE );
$frm->addCpfCnpjField( 'cpf_cnpj_condominio' ,'CPF', 80 )
	->setAttribute( 'grid_algin' , 'center' );
$frm->addNumberField( 'num_percentual' , 'Percentual', 10 , TRUE )
	->setAttribute( 'grid_algin' , 'center' );

$arrDados = array();
//$arrDados = null;
$frm->addJavascript('teste()');
$frm->show();
?>
<script>
function teste()
{
	var obj = jQuery.parseJSON('{"name":"John"}');
	alert( obj.name === "John" );
}
</script>
