<?php

/*
 * Formdin Framework
 * Copyright (C) 2012 Ministério do Planejamento
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
 * Este arquivo é parte do Framework Formdin.
 * 
 * O Framework Formdin é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da GNU LGPL versão 3 como publicada pela Fundação
 * do Software Livre (FSF).
 * 
 * Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA
 * GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou
 * APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/LGPL em português
 * para maiores detalhes.
 * 
 * Você deve ter recebido uma cópia da GNU LGPL versão 3, sob o título
 * "LICENCA.txt", junto com esse programa. Se não, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Fundação do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

/*
Módulo de cadastro de usuários
Autor: Luis Eugênio Barbosa
Data Inicio: 07-08-2009
*/

if(!defined('MULTI_PERFIL'))
{
	define('MULTI_PERFIL','S');
}
$frm = new TForm('Habilitar Acesso de Usuário',450);
$frm->setColumns(array(50));
/*
$frm->setPopUpMessage('Teste da mensagem',0,'ATTENTION','search.gif');
$frm->setPopUpMessage('Teste da mensagem',0,'ERROR','search.gif');
$frm->setPopUpMessage('Teste da mensagem',0,'SUCESS','search.gif');
*/
// criar os campos do formulário
switch($acao)
{
	case "":
	case "Listagem":
	{
		$frm->addHiddenField('num_cpf');
		$frm->addHiddenField('num_pessoa');
		$frm->setValue('num_pessoa','');
		$frm->addGroupField('gpFiltro','Consultar Usuários Habilitados')->setColumns(array(40));
			$frm->addTextField('nom_pessoa_filtro'	,'Nome:',20,false);//->setHint('Dica - informe qualquer parte do nome.');
			$frm->addSelectField('cod_uf_filtro'	,'Estado:',false,null,false);
			$frm->addButton('Pesquisar','Listagem','btnPesquisar',null,null,null,false);
		$frm->closeGroup();
		$frm->addHtmlField('html_gride',getUsuarios(),null,null,null,null,true);
		$frm->setAction('Novo');
		// selecionar a uf do usuário logado como padrão
		if(!$acao)
		{
			$frm->setValue('cod_uf_filtro',$_SESSION[APLICATIVO]['login']['cod_uf']);
		}
	}
	break;
	//------------------------------------------------------------------------------
	default:
		$frm->setColumns(array(120));
		$frm->addHiddenField('num_pessoa');
		$frm->addHiddenField('cod_unidade_ibama');
		$frm->addHiddenField('cod_uf_filtro');
		$frm->addHiddenField('nom_pessoa_filtro');
		$frm->addCpfCnpjField('num_cpf'			,'CPF/CNPJ'	,true);
		//$frm->addTextField('tecla'			,'Tecla'		,60,false,null,null);
		$frm->addTextField('nom_pessoa'			,'Nome'		,60,true,null,null);
		$frm->addTextField('end_pessoa'			,'Endereço'	,100,null,60);
		$frm->addTextField('des_bairro'			,'Bairro'	,60,false);
		$frm->addCepField('num_cep'				,'C.E.P.',false);
		$frm->addTextField('nom_municipio'		,'Município/Uf',60);
		$frm->addTextField('num_fone'			,'Telefone',60);
		$frm->addTextField('des_email'			,'E-mail',60);
		$frm->addTextField('nom_unidade_ibama'	,'Unidade de Controle',100,false,60);
		$frm->addHtmlField('html_gride',null,null,null,null,null,true);
		// botões
		$frm->setAction('Gravar,Novo,Listagem');
		// desabilitar todos os campos exceto o cpf
		$frm->disableFields(null);
}

// tratar a ação
switch($acao)
{
	//---------------------------------------------------------------------------------
	case "Novo":
		$frm->clearFields();
		// habilitar o campo num_cpf
		$frm->disableFields('num_cpf',null,false);
		// adicionar autocompletar no campo cpf
		//$frm->setAutoComplete('num_cpf','TESTE.PKG_SEGURANCA.SEL_DADOS_FUNCIONARIO','NUM_CPF','NUM_PESSOA,NOM_PESSOA,COD_UNIDADE_IBAMA,END_PESSOA,DES_BAIRRO,NUM_CEP,NUM_FONE,DES_EMAIL,NOM_MUNICIPIO,NOM_UNIDADE_IBAMA,HTML_GRIDE',true,null,"atualizar",14,800,null,null,true);
		$frm->setAutoComplete('num_cpf',ESQUEMA.'.PKG_SEGURANCA.SEL_DADOS_FUNCIONARIO','NUM_CPF','NUM_PESSOA,NOM_PESSOA,COD_UNIDADE_IBAMA,END_PESSOA,DES_BAIRRO,NUM_CEP,NUM_FONE,DES_EMAIL,NOM_MUNICIPIO,NOM_UNIDADE_IBAMA,HTML_GRIDE',true,null,"fwFazerAcao('atualizar')",14,400,2,null,true);
		//$frm->setOnlineSearch('num_cpf',ESQUEMA.'.PKG_SEGURANCA.SEL_DADOS_FUNCIONARIO','NUM_CPF',false,false,false,'NUM_CPF|CPF,NOM_PESSOA|Nome','NOM_PESSOA','Consulta Funcionário');
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( $frm->validate() )
		{
			$bvars=$frm->createBvars('num_pessoa,cod_unidade_ibama');
			$bvars['SEQ_PROJETO']		= PROJETO;
			$bvars['DES_ROLE'] 			= ROLE;
			$bvars['NUM_CPF'] 			= $frm->getValue('num_cpf');
			$bvars['SEQ_PERFIL'] 		= $_POST['seq_perfil'];
			// evitar que o próprio usuário retire todos os seus perfis
			if( !is_array( $_POST['seq_perfil'] ) && $_SESSION[APLICATIVO]['login']['maior_nivel'] != '999' )
			{
				if( preg_replace('/[^0-9]/','',$_SESSION[APLICATIVO]['login']['num_cpf'])==preg_replace('/[^0-9]/','',$frm->getValue('num_cpf')) )
				{
					$frm->setMessage('Selecione um perfil selecionado!');
				}
			}
    		if( !$frm->msgerros = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_USUARIO',$bvars))
    		{
				$frm->setPopUpMessage('Dados gravados com sucesso');
			}
		}
	break;
	//--------------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('num_pessoa');
		$res=null;
		print_r( recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_DADOS_FUNCIONARIO',$bvars,$res,-1));
		$frm->update($res);
		// recuperar os perfis do usuário
		$bvars=array('NUM_PESSOA'=>(integer)$frm->getValue('num_pessoa')
		            ,'SEQ_PROJETO'=>PROJETO);
		$res=null;
		$frm->addError(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PESSOA',$bvars,$res,-1));
		// marcar os campos checks/radio do gride
		$_POST['seq_perfil'] = $res['SEQ_PERFIL'];
	break;
	//------------------------------------------------------------------------------
	case 'btngride_perfilCancelar':
	case 'btngride_perfilRecuperar':
		$bvars = $frm->createBvars('seq_perfil_cancelar_recuperar|SEQ_PERFIL,num_pessoa');
		$frm->msgerros=executarPacote(ESQUEMA.'.PKG_SEGURANCA.ALTERAR_CANCELAMENTO_PERFIL',$bvars);
	break;

}
//print 'Num_pessoa:'.$frm->getValue('num_pessoa');

if($frm->getValue('num_pessoa'))
{
	//$frm->setValue('html_gride','criar o gride');
	$frm->setValue('html_gride',getPerfil());
}
$frm->show();
//-------------------------------------------------------------------------------------------------------------
function getUsuarios()
{
	if(!$_POST['nom_pessoa_filtro'] && !$_POST['cod_uf_filtro'])
	{
		return '<center><br><b>Informe o NOME e/ou a UF para visualizar a lista de usuários cadastrados.<br/><br/>Para habilitar um usuário a utilizar este sistema, clique <a href="javascript:Void(0);" onClick=\'fwFazerAcao("Novo")\'>Aqui</a> ou no botão Novo,<br>localizado no rodapé deste formulário.</b></center>';
	}

	$g = new TGrid('gd'
				,null
				,ESQUEMA.'.PKG_SEGURANCA.SEL_USUARIO'
				,null
				,null
				,'NUM_PESSOA'
				,'NUM_CPF,NUM_PESSOA'
				);
				$g->setCache(-1);
				$g->setBvars( array('SEQ_PROJETO'=>PROJETO,'NOM_PESSOA'=>$_POST['nom_pessoa_filtro'],'COD_UF'=>$_POST['cod_uf_filtro']));
				$g->addColumn('NOM_PESSOA'			,'Nome',400);
				$g->addColumn('NUM_CPF'				,'CPF',100,'CENTER');
				$g->addColumn('SIG_UF'				,'UF',50,'CENTER');
				$g->addColumn('SIG_UNIDADE_IBAMA'	,'UNIDADE',100,'CENTER');
				$g->addColumn('DES_PERFIS'			,'PERFIL',100);
	$g->setOnDrawCell('gdOnDrawCell');
	return $g->show(false);
}
//--------------------------------------------------------------------------------------
function getPerfil()
{
	// gride de perfis do projeto
	$bvars = array(	'SEQ_PROJETO'	=>PROJETO
  					,'NUM_PESSOA'	=>$_REQUEST['num_pessoa']
  					,'NUM_NIVEL'	=>$_SESSION[APLICATIVO]['login']['maior_nivel']  );

	print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL',$bvars,$res_perfil,-1));

	if(!is_array($res_perfil))
	{
		return 'Necessário cadastrar pelo menos um perfil';
	}
	$bvars=array('NUM_PESSOA'=>$_REQUEST['num_pessoa']
	            ,'SEQ_PROJETO'=>PROJETO);
	$g = new TGrid('gd_perfil',null,$res_perfil,null,'100%','SEQ_PERFIL');
	$g->enableDefaultButtons(false);
	if(!defined('MULTI_PERFIL') || strtoupper(MULTI_PERFIL) != 'N')
	{
		$g->addCheckColumn('seq_perfil','Selecione o(s) Perfil(is)','SEQ_PERFIL','DES_PERFIL');
	}
	else
	{
		$g->addRadioColumn('seq_perfil','Selecione o Perfi','SEQ_PERFIL','DES_PERFIL');
	}
	return '<br>'.$g->show(false);
}
//--------------------------------------------------------------------------------------
function gdOnDrawCell($rowNum,$cell,$objColumn,$aData,$edit)
{
	if($objColumn->getFieldName() == 'DES_PERFIL')
	{
		$cell->setProperty('title','Perfil concedido por '.$aData['NOM_PESSOA_ALTEROU']." em ".$aData['DAT_ALTERACAO']);
		$cell->setCss('cursor','pointer');
	}
}
?>
