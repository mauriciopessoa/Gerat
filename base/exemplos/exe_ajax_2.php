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

$frm = new TForm('Exemplo de Ajax para Atualizar Campos');
$frm->addTextField('nr_cpf','Cpf:',11,true);
$frm->addTextField('nm_pessoa','Nome:',60);

$frm->addButton('Alimentar Campos Ajax',null,'btnAlimentar','alimentarAjax()');
//$frm->addButton('Alimentar Campos Post','alterar','btnAlimentarPost');
//$frm->addButton('Limpar Campos',null,'btnAlimentarLimpar','fwClearChildFields()');
$frm->addButton('Validar Campos',null,'btnAlimentarValidar','fwValidateFields()');


if( $acao == 'alterar')
{
	//$res = TPDOConnection::executeSql('select * from pessoa');
	//$frm->setReturnAjaxData($res);
    $res['NR_CPF'][0]='12345678909';
    $res['NM_PESSOA'][0]='Nome Teste';
	prepareReturnAjax(1,$res,'Dados alterados com sucesso');
	$frm->update($res);
}
$frm->show();
?>
<script>
function alimentarAjax()
{

	fwAjaxRequest({
		'action':'alterar',
		//'dataType':'text',
		'beforeSend':fwValidateFields(),
		'callback':function(res)
		{
			fwUpdateFieldsJson(res);
            if(res.message)
            {
                alert( res.message);
            }
		}
	})
}

</script>
