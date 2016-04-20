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

// $Header: /home/cvsroot/base/exemplos/boleto.php,v 1.6 2011/07/14 11:32:58 LUIS_EUGENIO_BARBOSA Exp $
session_cache_limiter("none");
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
session_start();
define('FPDF_FONTPATH','../base/classes/fpdf/fonts/');
require('../includes/config.inc');
if (!defined('PASTA_BASE') )
	define('PASTA_BASE','base/');
require(PASTA_BASE.'classes/BoletoFpdf.class.php');

$pdf=new boleto();

if (is_array($_SESSION['BOLETOPDF']['DAT_VENCIMENTO'])){

	for ($i=0; $i<count($_SESSION['BOLETOPDF']['DAT_VENCIMENTO']);$i++){
$pdf->set_boleto($_SESSION['BOLETOPDF']['DAT_VENCIMENTO'][$i]
				,$_SESSION['BOLETOPDF']['AGENCIA_CONTA_CEDENTE'][$i]
				,$_SESSION['BOLETOPDF']['COD_NOSSO_NUMERO'][$i] //$nosso_numero
				,$_SESSION['BOLETOPDF']['VAL_COBRADO'][$i] //$valor_documento
				,$_SESSION['BOLETOPDF']['VAL_DESCONTO'][$i] //$valor_desconto
				,$_SESSION['BOLETOPDF']['VAL_OUTRAS_DEDUCOES'][$i] //$valor_outras_deducoes
				,$_SESSION['BOLETOPDF']['VAL_MORA_MULTA'][$i] //$valor_mora_multa
				,$_SESSION['BOLETOPDF']['VAL_OUTROS_ACRESIMOS'][$i]  //$valor_outros_acrescimos
				,$_SESSION['BOLETOPDF']['VAL_COBRADO'][$i] //$valor_cobrado
				,$_SESSION['BOLETOPDF']['DAT_DOCUMENTO'][$i]// //$data_documento
				,$_SESSION['BOLETOPDF']['SEQ_OPERACAO'][$i] //$num_documento
				,'' //$especie_doc
				,'' //$aceite
				,$_SESSION['BOLETOPDF']['DAT_DOCUMENTO'][$i] //$data_processamento
				,'' //$num_conta_responsavel
				,'' //$num_quantidade
				,$_SESSION['BOLETOPDF']['INSTRUCOES_SACADO1'][$i] //txt_instrucoes_sacado
				,$_SESSION['BOLETOPDF']['INSTRUCOES_SACADO2'][$i]//$txt_instrucoes_sacado2
				,$_SESSION['BOLETOPDF']['INSTRUCOES_SACADO3'][$i]//$txt_instrucoes_sacado3
				,$_SESSION['BOLETOPDF']['INSTRUCOES_SACADO4'][$i]//$txt_instrucoes_sacado4
				,$_SESSION['BOLETOPDF']['SACADO_LINHA1'][$i] //$txt_sacado1
				,$_SESSION['BOLETOPDF']['SACADO_LINHA2'][$i] //$txt_sacado2
				,$_SESSION['BOLETOPDF']['SACADO_LINHA3'][$i] //$txt_sacado3
				,$_SESSION['BOLETOPDF']['SACADO_LINHA4'][$i] // $txt_sacado4
				,$_SESSION['BOLETOPDF']['LINHA_DIGITAVEL'][$i]
				,$_SESSION['BOLETOPDF']['COD_BARRA'][$i]
				,$_SESSION['BOLETOPDF']['INSTRUCOES_CAIXA1'][$i]//$txt_instrucoes_caixa1
				,$_SESSION['BOLETOPDF']['INSTRUCOES_CAIXA2'][$i]//$txt_instrucoes_caixa2
				,$_SESSION['BOLETOPDF']['INSTRUCOES_CAIXA3'][$i]//$txt_instrucoes_caixa3
				,$_SESSION['BOLETOPDF']['INSTRUCOES_CAIXA4'][$i]//$txt_instrucoes_caixa4);
				);
	}
}

$pdf->mostrar_pdf();

?>

