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

$frm = new TForm('Exemplo Pagina��o do Gride',null,600);
$frm->addHtmlField('mensagem',"<h3>Este exemplo utiliza a tabela tb_paginacao do banco de dados bdApoio.s3db (sqlite).</h3>");

if( $_REQUEST['ajax'] )
{
				$res = TPDOConnection::executeSql("select * from tb_paginacao");
				$g = new TGrid('gd','Gride com Pagina��o',$res,200,null,'ID','descricao',10,'exe_gride_paginacao.php');
				$g->addColumn('id','Id',50,'center');
				$g->addColumn('descricao','Descri��o',1200,'left');
				$g->addButton('Alterar','alterar','btnAlterar','alterar()',null,'editar.gif');
				$g->addButton('Excluir','excluir','btnExcluir',null,null,'lixeira.gif');
				$g->show();
				die();
}
//print_r( $_REQUEST);
$frm->addHtmlField('html_gride');
$frm->setAction("Refresh");
$frm->addJavascript('init()');
$frm->show();
?>
<script>
function init()
{
				fwGetGrid("exe_gride_paginacao.php",'html_gride');
}
// recebe fields e values do grid
function alterar(f,v)
{
	var dados = fwFV2O(f,v);
	fwModalBox('Altera��o','index.php?modulo=exe_gride_form_edicao.php',300,800,null,dados);
}
</script>



