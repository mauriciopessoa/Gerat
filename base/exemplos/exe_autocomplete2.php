<?php
TPDOConnection::test(false);
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

$frm = new TForm( 'Exemplo Campo Texto com Autocompletar II',220 );
$frm->addHtmlField('msg','<h3>Este exemplo est� utilizando o banco de dados bdApoio.s3db ( sqlite) do diret�rio exemplos.<br>
A tabela de consulta � a tb_municipio.<br>
A consulta esta configurada para disparar quando for digitado o terceiro caractere do nome.<br>Se o campo Estado tiver preenchido o codigo da uf ser� utilizado no filtro.<br></h3>');


$frm->addSelectField( 'cod_uf', 'Estado:')->addEvent('onChange','jQuery("#nom_municipio").val("");fwAutoCompleteClearCache("nom_municipio")');
$frm->addTextField( 'nom_municipio', 'Cidade:', 60 )->setExampleText( 'Digite os 3 primeiros caracteres.');
$frm->addHiddenField('cod_municipio','');
$frm->setAutoComplete( 'nom_municipio'
			, 'tb_municipio'	// tabela de municipios
			, 'nom_municipio'	// campo de pesquisa
			, 'cod_municipio'	// campo que ser� atualizado ao selecionar o nome do munic�pio
			, null
			,'cod_uf'			// campo do formul�rio que ser� adicionado como filtro
			,null
			,3					// numero de caracteres minimos para disparar a pesquisa
			,1000				// tempo ap�s a digita��o para disparar a consulta
			,50					// m�ximo de registros que dever� ser retornado
			);
$frm->show();
?>