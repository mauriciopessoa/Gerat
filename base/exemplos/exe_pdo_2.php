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


$frm = new TForm('Exemplo PDO Acessando MYSQL e SQLITE',420,650);
$frm->setOverflowX(false);
$frm->setOverflowY(false);
$frm->addHtmlField('mensagem1','Dados da conex�o:<br>Banco:MYSQL<BR>Host:127.0.0.1<br>Port:3306<br>Database:text<br>Usu�rio:root<br>Senha:',null,null,100,300)->setCss('border','1px solid green');
$frm->addHtmlField('mensagem2','Dados da conex�o:<br>Banco:SQLITE<BR>Database:bdApoio.s3db',NULL,NULL,100,300,false)->setCss('border','1px solid blue');
$frm->addHtmlField('resultado1','',null,null,220,300)->setCss('border','1px solid green');
$frm->addHtmlField('resultado2','',NULL,NULL,220,300,false)->setCss('border','1px solid blue');
$frm->addHtmlField('status');
error_reporting(E_ALL);
if( $acao == 'Testar' )
{
	try
	{
		TDb::setDbType('mysql');
		$res = TDb::sql('select * from engines');
		$frm->set('resultado1','<b><blink>MySql - Table: ENGINES</blink></b><hr><pre>'.print_r(converteArray($res),true).'</pre>');
	}
	catch (Exception $e)
	{
		$frm->set('resultado1',$e->getMessage());
	}

	try
	{
		TDb::setDbType('sqlite');
		$res = TDb::sql('select * from tb_test');
		$frm->set('resultado2','<b><blink>Sqlite - Table: tb_test</blink></b><hr><pre>'.print_r(converteArray($res),true).'</pre>');
	}
	catch (Exception $e)
	{
		$frm->set('resultado2',$e->getMessage());
	}


}
function converteArray($dados)
{
	$res=null;
	foreach($dados as $k=>$a)
	{
		foreach($a as $k1=>$v1)
		{
			$res[strtoupper($k1)][$k]=$v1;
		}
	}
	return $res;
}
$frm->setAction('Testar,Refresh');
$frm->show();
?>
