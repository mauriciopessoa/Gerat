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
M�dulo utilizado para gerar o xml de carregamento on-line da classe TreeView
Exemplo de chamada para teste do resultado:
https://10.1.4.65/~45427380191/appbase/?modulo=base/callbacks/treeView.php&ajax=1&parentField=SEQ_TAXONOMIA_PAI&childField=SEQ_TAXONOMIA&descField=DES_TAXONOMIA&tableName=TESTE.PKG_TAXONOMIA_TREE.SEL_TAXON
https://10.1.4.65/~45427380191/appbase/?modulo=base/callbacks/treeView.php&ajax=1&parentField=COD_SUBORDINADO&childField=COD_UNIDADE_IBAMA&descField=NOM_UNIDADE_IBAMA&tableName=SIGER.PKG_UNIDADE_IBAMA.SEL_ARVORE_UNIDADE&_w_cod_unidade_inicial=10000
 */
error_reporting(0);
header("Content-type:text/xml");
echo '<?xml version="1.0" encoding="iso-8859-1"?>';

$debug=false;
if( $debug )
{
	print	'<tree id="0">';
	print	'	<item text="Tabela: '.$_REQUEST['tableName'].'" id="1"/>';
	print	'	<item text="Coluna Pai: '.$_REQUEST['parentField'].'" id="2"/>';
	print	'	<item text="Coluna Filha: '.$_REQUEST['childField'].'" id="3"/>';
	print	'	<item text="Coluna Descri��o: '.$_REQUEST['descField'].'" id="4"/>';
	print	'	<item text="id request = '.$_REQUEST['id'].'" id="5"/>';
	print 	'</tree>';
	die();
}
// parametro recebido pela chamada ajax
if( isset( $_GET['id'] ) && ! is_null( $_GET['id'] ) && $_GET['id'] > '0' )
{
	//sleep(1);
	$bvars = array( $_REQUEST['parentField'] => $_GET['id'] );
	//sleep(2);
}
else
{
	$_GET['id'] = '0';
	$bvars = null;
	//sleep(4);

	foreach($_REQUEST as $k=>$v)
	{
		if(substr($k,0,3)=="_w_")
		{
			if( $_REQUEST['parentField'] != strtoupper(substr($k,3)) )
			{
				$bvars[strtoupper(substr($k,3))]= $v;
			}
		}
	}
}
// cria a inst�ncia do objeto treeData
$tree = new TTreeViewData($_GET['id'],'');

// recuperar os dados do banco de dados
$res=null;
if( preg_match('/\.PK\a?/i',$_REQUEST['tableName']) > 0 )
{
	$erro = recuperarPacote($_REQUEST['tableName'],$bvars,$res);
	if( $erro )
	{
		$tree->addItem(new TTreeViewData($_GET['id'],$erro[ 0 ] ) );
	}
}
else
{
	// pdo
	$where = '';
	if( is_array($bvars) )
	{
		foreach($bvars as $k=>$v)
		{
			$where .= ($where =='' ? ' where ' :' and ').$k."='".$v."'";
		}
	}
	else
	{
		if( isset($_REQUEST['initialParentKey']))
		{
			//$where =' where ('.$_REQUEST['parentField']." = '".$_REQUEST['initialParentKey']."' or ".$_REQUEST['childField']." = '".$_REQUEST['initialParentKey']."')";
			$where =' where ('.$_REQUEST['childField']." = '".$_REQUEST['initialParentKey']."')";
		}
		else
		{
			$where =' where '.$_REQUEST['parentField'].' is null';
		}
	}
	$sql = "select ".$_REQUEST['parentField'].','.$_REQUEST['childField'].",".$_REQUEST['descField']. " from ".$_REQUEST['tableName'].' '.$where;
	//$tree->addItem(new TTreeViewData($_GET['id'],$sql ) );
	$res = TPDOConnection::executeSql($sql);
	//$res=null;
}
if( $res )
{
	foreach($res[ $_REQUEST['childField'] ] as $k=>$v)
	{
		// criar o array com userdata
		$aUserData=null;
		if( $_REQUEST['userDataFields'])
		{
			$aUserDataFields = explode(',',$_REQUEST['userDataFields']);
			foreach( $aUserDataFields as $u => $f )
			{
				if( $res[ $f ][$k] )
				{
					$aUserData[$f]=$res[ $f ][$k];
				}
				else if( $res[ strtoupper( $f ) ][$k] )
				{
					$aUserData[$f]=$res[ strtoupper( $f ) ][$k];
				}
			}
		}
		$tree->addItem(new TTreeViewData(
			$res[$_REQUEST['childField']][$k]
			,(is_null($res[$_REQUEST['descField']][$k]) ? '':$res[$_REQUEST['descField']][$k] )
			,null
			,null
			,$aUserData));
	}
}
echo $tree->getXml();
?>