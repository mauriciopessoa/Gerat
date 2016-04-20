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

/*
	quando estiver dando erro no retorno do xml, verificar
	se todos os arquivos n�o possuem linhas em branco no inicio e no final apos a tag "?>"
*/
function Teste($arg)
{
	error_reporting(E_ALL);
	//$bvars = array('SEQ_PROJETO'=>38);
	//print_r(recuperarPacote('FASIS.PKG_MENU.SEL_MENU',$bvars,$res));
    $objResponse = new xajaxResponse();
   	$objResponse->alert("Requisi��o xajax funcionou");
    //$btn = new TButton('btnTeste','Teste',null);
    //$objResponse->assign("campo_html","innerHTML",$btn->show(false));
   	
    //$objResponse->alert("funcionou");
	//$objResponse->clear('answer', 'innerHTML');
    //$objResponse->addEvent('nom_pessoa', "onclick", 'alert("oi")');
    $objResponse->assign("nom_pessoa","value", 'Xajax OK');
    //$objResponse->assign("campo_html","innerHTML", 'aqui<br>Entra<br>o<br>gride');
    $res['NUM_CPF'][] = '12345678909';
    $res['NOM_PESSOA'][] = 'Usuario de Teste';
    $gride = new TGrid('gd','Gride XAJAX',$res);
    $gride->autoCreateColumns();
    $gride = $gride->show(false);
   	$objResponse->assign("campo_html","innerHTML",utf8_decode($gride));
    //sleep(1);
   	$objResponse->call("fncRetorno", "arg1", 9432.12, array("myKey" => "some value", "key2" => 'TESTE'));
    return $objResponse;
}
?>
