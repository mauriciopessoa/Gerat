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

 // marcar os campos obrigat�rios com Asterisco na frente
define('REQUIRED_FIELD_MARK','*');

$frm = new TForm('Exemplo do Campo Texto');

$frm->addTextField('nome','Nome da pessoa sem quebra:',60,false,60,null,null,null,null,null,true);
$frm->addTextField('municipio','Municipio',60,true,60);

// definir consulta din�mica no campo munic�pio
$frm->setOnlineSearch('municipio'
    ,'tb_municipio' // tabela de munic�pios
	,'nom_municipio|Munic�pio:||||||like'  // campos para sele��o do munic�pio. Ordem dos parametros: name|label|length|size|required|$type|decimalPlaces|partialKey|searchFormated
	,false
	,false
	,true // se for encontrada apenas 1 op��o fazer a sele��o automaticamente
	,'cod_municipio|C�digo,nom_municipio|Munic�pio'
	,'NOM_MUNICIPIO|municipio'
	,null
	,null,null,null,null,null,null
	,'osCallBack()'
	,null //10
    ,null,null,null,null,null,null,null
	,false // caseSensitive
	);


$frm->addTextField('nome2','Nome Desabilitado:',80,null,null,'Desabilitado',true,null,null,true)->setEnabled(false);
$frm->addTextField('nome3','Nome Somente Leitura:',80,true,null,'Somente leitura',true,null,null,true)->setReadOnly(true);

// bot�es de a��o
$frm->setAction('Atualizar');
$frm->addButton('Validar',null,null,'fwValidateFields()');
$frm->addButton('Limpar',null,'btnLimpar','fwClearChildFields()');

// fun��o chamada no carregamento da p�gina
$frm->addJavascript('init()');

// criar o html do formul�rio
$frm->show();
?>
<script>
function init()
{
	fwAlert('Formul�rio foi carregado!')
}

// Online Search callback
function osCallBack(fields,doc)
{
	alert('Call back Chamado\n'+fields+'\n'+doc);

}
</script>