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
F.A.S.I.S
Projeto......:CADASTRO T�CNICO FEDERAL
M�dulo.......: Cadastro de Tabelas Auxiliares
Data Inicio..:
Data T�rmino.:
*/

// campos do formulario
$arrCampos['form_status']						= new CampoHtml('form_status','');
$arrCampos['gpTipoDado']							= new CampoGrupo('Tipo de Dado');
$arrCampos['seq_tipo_dados_apoio']			= new CampoSelect('seq_tipo_dados_apoio','Tipo Dado',false,null,null,array("onChange"=>"submit()"),true,null,null,null,null,null,null,null,'&lt;Registrar tipo de dado novo&gt;');
$arrCampos['des_tipo_dados_apoio']			= new CampoTexto('des_tipo_dados_apoio','Descri��o',true,'',null,100,80);
$arrCampos['sig_tipo_dados_apoio']			= new CampoTexto('sig_tipo_dados_apoio','Sigla',true,'',null,25,25);
$arrCampos['sit_cancela_tipo_dados_apoio']	= new CampoSelect('sit_cancela_tipo_dados_apoio','Inativo',true,null,array('N'=>'N�o','S'=>'Sim'),null,true);
$arrCampos['gpTipoDadoFim']						= new CampoGrupo();
$arrCampos['gpDado']								= new CampoGrupo('Dados');
$arrCampos['gride']								= new CampoHtml('gride','');
$arrCampos['num_registros_novos']				= new CampoSelect('num_registros_novos','N� de registros novos no grid at�',false,2,array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10"),array("onChange"=>"submit()"),true);
$arrCampos['gpDadofim']							= new CampoGrupo();;

// criar instancia do formul�rio din�mico
$frm = new FormDin3($arrCampos,'Dados de Apoio',$_POST);
$frm->setAltura(0);
$frm->botaoAcao[''] = array('Gravar','Novo');
$frm->setCampoFocoInicial('seq_tipo_dados_apoio');

if ( !$frm->get('num_registros_novos') ) {
	$frm->set('num_registros_novos',2);
}

if ( !$frm->get('seq_tipo_dados_apoio') ) {
	$frm->campos['sit_cancela_tipo_dados_apoio'] = null;
	$frm->campos['gride'] = null;
	$frm->campos['gpDado'] = null;
	$frm->campos['num_registros_novos'] = null;
}
// tratamento das acoes do formulario
$formDinAcao = $formDinAcao ? $formDinAcao : $_SESSION[APLICATIVO]["acao"];
switch($formDinAcao) {
	//---------------------------------------------------------------------------------
	case 'btngrideExcluir':
			if(!$frm->msgerros = executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.EXC_DADOS_APOIO',$_POST,-1))
			{
				$frm->limparCampos();
				$frm->mensagem='Registro exclu�do com sucesso!!!';
			}
	break;
   	//---------------------------------------------------------------------------------
	case 'Novo':
		$frm->limparCampos();
		$frm->campos['sit_cancela_tipo_dados_apoio'] = null;
		$frm->campos['gride'] = null;
		$frm->campos['gpDado'] = null;
		$frm->campos['num_registros_novos'] = null;
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if ( isset($_SESSION['form_token']) and $_SESSION['form_token']==md5(serialize($_POST)) ) {
			$frm->msgerros[]='Resultado ja foi gravado';
			$frm->limparCampos();
		} elseif ( !$frm->validar() ) {
			$_SESSION['form_token'] = md5(serialize($_POST));
			if(!$frm->msgerros = executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_TIPO_DADO',$_POST,-1)) {
				if((integer)$frm->get('seq_tipo_dados_apoio')==0) {
					$frm->mensagem='Tipo dado inclu�do com sucesso!!!';
					$frm->limparCampos();
				}
				else {
					$bvars = $frm->criarBvars('seq_tipo_dados_apoio');
					foreach ($_POST['TEXT_DES_DADOS_APOIO'] as $k=>$v) {
						if(	($k<0  and strlen($_POST['TEXT_DES_DADOS_APOIO'][$k]) >0)
							or  $_POST['TEXT_DES_DADOS_APOIO'][$k] != $_POST['TEXT_DES_DADOS_APOIO_ATUAL'][$k] 
							or $_POST['TEXT_SIT_CANCELADO'][$k] != $_POST['TEXT_SIT_CANCELADO_ATUAL'][$k] ) {
							$bvars['SEQ_DADOS_APOIO'][] = $k;
							$bvars['DES_DADOS_APOIO'][] = $_POST['TEXT_DES_DADOS_APOIO'][$k];
							$bvars['SIT_CANCELADO'][] = $_POST['TEXT_SIT_CANCELADO'][$k];
						}
					}
					if( !is_array($frm->msgerros=executarPacote(ESQUEMA.'.PKG_DADOS_APOIO.INC_ALT_DADO_APOIO',$bvars)) ){
						$frm->mensagem='Tipo dado alterado com sucesso!!!';
					}
				}
			}
		}
	break;
	//-----------------------------------------------------------------------------
	case 'btngrideAlterar':
		$bvars = $frm->criarBvars('seq_dados_apoio');
		if(!$frm->msgerros = recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_DADOS_APOIO',$bvars,$res,-1))
		{
			$res=$bvars['CURSOR_PAI'];
			$frm->atualizarCampos($res);
		}
	break;
}
// inicializar os campos em branco com valor padr�o
$bvars = null;
print_r(recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_TIPO_DADOS',$bvars,$res_tipo_dados,-1));
$frm->setOpcoes('seq_tipo_dados_apoio',$res_tipo_dados,'CODIGO','DESCRICAO');

if ( $frm->get('seq_tipo_dados_apoio') ) {
	//$frm->set('form_status',STATUS_ALTERANDO);
	$bvars = $frm->criarBvars('seq_tipo_dados_apoio');
	print_r(recuperarPacote(ESQUEMA.'.PKG_DADOS_APOIO.SEL_DADOS_APOIO',$bvars,$res_tipo_dado,-1));
	$res_tipo_dado=$bvars['CURSOR_PAI'];
	$frm->atualizarCampos($res_tipo_dado);
	for ($i=1; $i<=$frm->get('num_registros_novos');$i++){
		$bvars['CURSOR']['SEQ_DADOS_APOIO'][] = -$i;
		$bvars['CURSOR']['DES_DADOS_APOIO'][] = '';
		$bvars['CURSOR']['SIT_CANCELADO'][] = 'N';
	}

	// cria��o do gride
	$frm->set('gride',criarGride('gride'
								,null
								,$bvars['CURSOR']
								,null
								,''
								,'SEQ_DADOS_APOIO'
								,'text_sit_cancelado_atual/0/text/SIT_CANCELADO|
								`text_des_dados_apoio_atual/0/text/DES_DADOS_APOIO|
								`text_sit_cancelado/100/sel/SIT_CANCELADO/N/N=>N�o,S=>Sim|Inativo
								`text_des_dados_apoio/100:80/text/DES_DADOS_APOIO/N/|Descri��o
								`SEQ_DADOS_APOIO|SEQ'
								,null
								,null
								,null	
								,null
								,null
								,null
								,null
								,'Nenhum registro cadastrado'
								,null
								,'COR_FUNDO||$nl%2!=0|#efefef
								 ,ALINHAMENTO_TEXTO|SIT_CANCELADO||CENTER
								 ,VALOR|SIT_CANCELADO|$res["SIT_CANCELADO"][$k]=="S"|N�o|Sim
								,COR_FUNDO|SEQ_DADOS_APOIO|$res["SIT_CANCELADO"][$k]=="S"|#F7BBBB|#CFFFB4
								,ALINHAMENTO_TEXTO|SEQ_DADOS_APOIO||CENTER'
								,null,null,null,null,null,null,null,30,null,null,null,false
								)
							);

		$frm->setSoLeitura('sig_tipo_dados_apoio',true);
}

// true->mostrar conte�do do $_POST.  false->n�o mostra;
$frm->modoDepuracao=false;
// exibir o formul�rio
print $frm->criarForm($formDinAcao);
?>
