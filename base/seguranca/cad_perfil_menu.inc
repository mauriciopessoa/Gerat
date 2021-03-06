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
Sistema FASIS
M�dulo de defini��o de acesso do perfil
Autor: Luis Eug�nio Barbosa
*/

// campos do formulario
$arrCampos['seq_projeto']			= new CampoOculto('seq_projeto',PROJETO);
$arrCampos['seq_perfil_menu']		= new CampoOculto('seq_perfil_menu','');

$arrCampos['seq_perfil']			= new CampoSelect('seq_perfil','Perfil',true,null,null,array('onChange'=>'formDinFazer("Atualizar");'));
$arrCampos['gride_perfil_menu']		= new CampoHtml('gride_perfil_menu','');

// criar instancia do formul�rio din�mico
$frm = new FormDin3($arrCampos,'DEFINI��O DE ACESSO DO PERFIL',$_POST);
$frm->criarVariavel('modulo',PASTA_BASE.'seguranca/cad_perfil_menu.inc');
$frm->setAltura(0);
$frm->setCampoFocoInicial('seq_perfil');
$frm->botaoAcao[''] = array('Gravar');

// preencher campo select com os perfis
$bvars=array('SEQ_PROJETO'=>PROJETO
            ,'SIT_CANCELADO'=>'N'
            ,'NUM_NIVEL'=>$_SESSION[APLICATIVO]['login']['maior_nivel']);
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res));
$frm->setOpcoes('seq_perfil',$res,'SEQ_PERFIL','DES_PERFIL');

// tratamento das acoes do formulario
if( (string) $_SESSION[APLICATIVO]['acao'] == '' ) 
{
   $_SESSION[APLICATIVO]['acao']=$formDinAcao;
}
switch($_SESSION[APLICATIVO]['acao']) {
	//---------------------------------------------------------------------------------
	case 'Atualizar':
	 	$_POST['checkbox_seq_menu']=null;
	 	unset($_POST['checkbox_seq_menu']);
	break;
	case 'Gravar':
		$bvars=$frm->criarBvars('SEQ_PERFIL');
		// cancelar todos os diretos do perfil primeiro
		if( $frm->msgerro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars))
			{
				$frm->mensagem = null;
				break;
			}
		$frm->mensagem = 'Dados gravados corretamente';
		foreach($_POST['checkbox_seq_menu'] as $k=>$v)
		{
			$bvars=$frm->criarBvars('SEQ_PERFIL');
			$bvars['SEQ_MENU']=$v;
			if( $frm->msgerro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars))
			{
				$frm->mensagem = null;
				break;
			}
			//$bvars['SEQ_MENU'][] = $v;
		}
		// gravar no hist�rico e depois excluir os registrs da tabela perfil_menu 
		$bvars				= $frm->criarBvars('SEQ_PERFIL');
		$bvars['SEQ_MENU'] 	= -1;
		if( $frm->msgerro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO_INDIVIDUAL',$bvars))
		{
			$frm->mensagem = null;
			break;
		}
//		if(!$frm->msgerro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERMISSAO',$bvars))
//		{
//			$frm->mensagem = 'Dados gravados corretamente';
//		}
	break;
}

if( (integer) $frm->get('seq_perfil') > 0 )
{
	// se n�o tiver postado, ler do banco
	if( !isset($_POST['checkbox_seq_menu']))
	{
		$bvars = null;
		$bvars['SEQ_PERFIL']	= $frm->get('seq_perfil');
		$bvars['SIT_CANCELADO']	= 'N';
		print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PERFIL',$bvars,$res,-1));
		if(is_array($res))
		{
			foreach($res['SEQ_MENU'] as $k=>$v)
			{
				$_POST['checkbox_seq_menu'][] = $v;
			}
		}
	}

	// criar o gride com os itens do menu cadastrados
	$frm->set('gride_perfil_menu',criarGride('gride_perfil_menu'
										,NULL
										,ESQUEMA.'.PKG_SEGURANCA.SEL_MENU_PROJETO'
										,array('SEQ_PROJETO'=>PROJETO)
										,''
										,'SEQ_MENU'
										,'checkbox_seq_menu/SEQ_MENU|[<A onClick="grideMarcarColunaCheck(\'checkbox_seq_menu\');" style="cursor:pointer;text-decoration:underline;color:blue;" title="Marcar/Desmarcar Todas">X</a>]
										  ,DES_ROTULO_IDENTADO|MENU'
										,500
										,null
										,null
										,14
										,null
										,null
										,null
										,'Nenhuma item de menu cadastrado'
										,null
										,'COR_FUNDO||$nl%2!=0|#efefef
										`LARGURA|checkbox_seq_menu||30
										`LARGURA|DES_ROTULO_FORMATADO_IDENTADO||450
										`COR_FUNDO||array_search($res["SEQ_MENU"][$k],$_POST["checkbox_seq_menu"])>-1|#FFFFDB
										`ALINHAMENTO_TEXTO|checkbox_seq_menu||center'
										,null,null,false,null,null,null,null,null,null,null,null,false
										)
									);
}
//$frm->modoDepuracao=true;
// exibir o formul�rio
print $frm->criarForm($_SESSION[APLICATIVO]['acao'].$formDinAcao);
?>

