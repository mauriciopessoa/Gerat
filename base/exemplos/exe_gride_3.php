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


/*$x = '(abacate,pera)';
echo '='.preg_match('/\(a\)/i',$x);
die();
*/
//echo '<pre>'; print_r($_SESSION);  echo '</pre>';
/*session_start();
session_destroy();
session_start();
*/

$frm = new TForm('Exemplo do Gride Offline',500,600);

$frm->addDateField('dat_nascimento','Data:',true);
$frm->addMemoField('obs'		,'Obs:',1000,true,20,3,true);

// subformul�rio com campos "offline" 1-N
$frm->addHtmlGride('campo_moeda','exe_gride_3_dados.php','gdx');

$frm->setAction('Gravar,Novo');

$frm->show();


if($acao == 'Novo')
{
	$frm->clearFields();
}
else if($acao == 'Gravar')
{
    print_r($_POST);
	$res = $frm->createBvars('campo_moeda,dat_nascimento');
	foreach($res as $k=>$v)
	{
		d($k,'$k');
		d($v,'$v');
	}
}
?>
<script>

function gridCallBack(res)
{
	var msg='';
	if( res && res.action )
	{
		for(key in res )
		{
			msg +='<b>'+key+'</b>='+res[key]+'\n';
		}
		jAlert('A fun��o <b>callback</b> do gride offline foi chamada recebendo o <b>$_REQUEST</b>\n\nDefini��o: gridCallBack(REQUEST)\nValores:\n'+msg);
	}

}
/*
function btnGravarOnClick()
{
	fwValidateForm({"ignoreFields":"dat_nascimento"});
}
*/
</script>
