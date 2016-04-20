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
* Substituir a fu��o alert() do javascript;
*/

$frm = new TForm('Exemplo de Di�logo de Confirma��o',300,600);
$frm->addHtmlField('html','<br><center><b>Exemplo de utiliza��o da fun��o fwConfirm() para substituir a fun��o alert() do javascript</b></center>');
$frm->addTextField('nome','Nome:',100,true,50);
$frm->addDateField('nasc','Nascimento:',true);
$frm->addNumberField('salario','Sal�rio',10,false,2);

$frm->addButton('Salvar',null,'btnSalvar1','btnGravarClick()');

$_POST['formDinAcao'] = isset($_POST['formDinAcao']) ? $_POST['formDinAcao'] : '';
switch($_POST['formDinAcao'])
{
	case 'Gravar':
		if( $frm->validate() )
		{
			$frm->setMessage('A��o salvar executada com SUCESSO!!!');
		}
	break;
}
$frm->setAction('Atualizar');
$frm->show();
?>
<script>
function btnGravarClick(status)
{
	//fwConfirm('Confirma Grava��o do Regirtro ?', function(){alert('ok')},function(){alert('n�o') }, 'Sim', 'N�o', 'Salvar dados');
	fwConfirm('Confirma Grava��o do Regirtro ?', cb,null, 'Sim', 'N�o', 'Salvar dados');

}
function cb(p)
{
	if( p )
	{
		alert( 'Confirmado!' );
	}
	else
	{
		alert( 'Cancelado');
	}
}
</script>
