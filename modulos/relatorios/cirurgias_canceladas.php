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

//error_reporting(~E_NOTICE);
if( $_REQUEST['formDinAcao'] == 'gerar_pdf' )
{
   	gerar_pdf();
   	return;
}
$frm = new TForm('Exemplo de Geração de PDF',240);
$frm->addHtmlField('msg','<b><h3>Exemplo de utilização da classe TPDF, utilizando o metodo Row() para criar uma listagem simpes de Nome e Cpf</h3></b>
<br>Utilizei o método setOnDrawCell para definir uma função de callback para alterar as propriedade da celula do cpf quando for o usuário de teste.');
$frm->addTextField('des_marcadagua','Marca d´agua:',30,null,null,'RELATÓRIO EXEMPLO I');
$frm->addButton('Gerar Pdf',null,'btnPdf','exibir_pdf()');
$frm->show();

function gerar_pdf()
{
	//$rel = new TPDF('L','mm','A4'); //landscape
	
        $rel = new TPDF('P','mm','A4'); //landscape
        
	$rel->setWaterMark($_REQUEST['des_marcadagua']);
	$rel->setOnDrawCell('myOdc');
  	// criação do relatório em colunas utilizando row
  	
        
//        $dados=null;
//	for($i=0;$i<100;$i++)
//	{
//		$dados['NUM_CPF'][] 	= '454.273.801-91'; 	$dados['NOM_PESSOA'][]	= 'Luis Eugênio Barbosa '.$i;
//		//$dados['NUM_CPF'][] 	= '123.456.789-09'; 	$dados['NOM_PESSOA'][]	= 'Usuário Teste do Ibama';
//	}
        
        $dados = Tb_agendamentoDAO::selecionarCirurgias('%');
        
	$rel->setData( $dados );
        
        
	$rel->addColumn('Nome'	,60,'L', 'NOME_PACIENTE'	,'','I',8,'black','times');
	$rel->addColumn('Data'	,15 ,'C', 'DATA_CIRURGIA'		,'','B',6,'black','arial');
	$rel->printRows();
//	$rel->ln(5);
//	$rel->cell(0,5,'Imprimir o gride novamente',1,1,'c');
//	$rel->ln(5);
//	$rel->printRows();
	$rel->show();
}
function myOdc( TPDFColumn $oCol=null,$value=null,$colIndex=null)
{
	if( $oCol->getFieldName() == 'NUM_CPF' && $value=='123.456.789-09')
	{
		$oCol->setFontColor('red');
		$oCol->setFillColor('yellow');
		$value = 'LUIS BARBOSA';
	}
}

?>
<script>
function exibir_pdf()
{
	//fwFaceBox(  pastaBase+'js/jquery/facebox/stairs.jpg');
	fwShowPdf({"modulo" : "relatorios/cirurgias_canceladas.php","des_marcadagua":jQuery("#des_marcadagua").val()});
}
</script>

