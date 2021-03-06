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

$frm = new TForm('Exemplo Campo Select e Ajax',200,500);
$frm->addSelectField('select_estado','Estado:');
$frm->addSelectField('select_municipio','Cidade:');
$frm->addButton('Preencher Municipio',null,'btn2','btn2Click()');
$frm->setAction('Atualizar');
$frm->getField('select_estado')->setEvent('onChange','btn2Click()');
$frm->addJavascript('btn1Click()');
$frm->show();
?>
<script>
function btn1Click()
{
	// exemplo utilizando nome da tabela e campos
	//fwFillSelectAjax("select_estado","uf","cod_uf","nom_uf||'-'||sig_uf","53","btn2Click","-- Estados --","-1","","","",0);
	// exemplo utilizando pacote - oracle
	fwFillSelectAjax("select_estado","TESTE.PKG_TESTE.SEL_UF","COD_UF","NOM_UF","53","btn2Click","-- Estados --","-1","","","",0);
}
function btn2Click()
{
	// prencher os municipios utilizando o codigo da uf
	// exemplo utilizando nome da tabela e campos
	//fwFillSelectAjax("select_municipio","municipio","cod_municipio","nom_municipio","","","-- Cidades --","-1","select_estado|COD_UF","Lendo...","",0);
	// exemplo utilizando pacote - oracle
	fwFillSelectAjax("select_municipio","TESTE.PKG_TESTE.SEL_MUNICIPIO","COD_MUNICIPIO","NOM_MUNICIPIO","","","-- Cidades --","-1","select_estado|COD_UF","Lendo...","",0);
}
</script>

