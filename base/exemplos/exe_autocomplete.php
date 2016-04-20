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

$frm = new TForm( 'Exemplo Campo Texto com Autocompletar',220 );
$frm->addHtmlField('msg','<h3>Este exemplo est� utilizando o banco de dados bdApoio.s3db ( sqlite) do diret�rio exemplos.<br>
A tabela de consulta � a tb_municipio.<br>
A consulta esta configurada para disparar quando for digitado o terceiro caractere do nome.<br>
O campo Cod Uf ser� preenchido automaticamente quando a cidade for encontrada ou selecionada</h3>');


$frm->addTextField( 'nom_municipio', 'Cidade:', 60 )->setExampleText( 'Digite os 3 primeiros caracteres.')->addEvent('onblur','validarMunicipio(this)');
$frm->addTextField('cod_uf','C�d Uf:',false);
$frm->setAutoComplete( 'nom_municipio', 'tb_municipio', 'nom_municipio', 'cod_municipio,cod_uf', true,null, 'callback_autocomplete_municipio()', 3, 1000, 50, null, null, null, null, true );

$frm->setAction( 'Refresh' );
$frm->show();
?>

<script>
	/**
	 * callback_autocomplete_especies
	 *
	 *
	 * @return
	 *
	 * @see
	 */

	function callback_autocomplete_municipio()
		{
			fwAlert('callback autocompelte foi chamada.');
		}
	function validarMunicipio(e)
	{
		if( !fwAutoCompleteValidade(e))
		{
			e.value = '';
		}
	}
</script>
