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


//error_reporting(~E_NOTICE);
if( $_REQUEST['formDinAcao'] == 'gerar_pdf' )
{
   	gerar_pdf();
   	return;
}
$frm = new TForm('Exemplo de Gera��o de PDF',240);
$frm->addHtmlField('msg','<b><h3>Exemplo de utiliza��o da classe TPDF, utilizando o metodo Row() para criar uma listagem simpes de Nome e Cpf</h3></b>
<br>Utilizei o m�todo setOnDrawCell para definir uma fun��o de callback para alterar as propriedade da celula do cpf quando for o usu�rio de teste.');
$frm->addTextField('des_marcadagua','Marca d�agua:',30,null,null,'RELAT�RIO EXEMPLO I');
$frm->addButton('Gerar Pdf',null,'btnPdf','exibir_pdf()');
$frm->show();

function gerar_pdf()
{
	$rel = new TPDF('P','mm','A4');

	/*
    $rel->AddPage();
    for($i=1;$i<100;$i++)
    {
	    $rel->cell(0,5,'Linha:'.$i,1,1);
    }
    $rel->show();
	die;
	*/
	$rel->setWaterMark($_REQUEST['des_marcadagua']);
	$rel->setOnDrawCell('myOdc');
  	// cria��o do relat�rio em colunas utilizando row
  	$dados=null;
  	// CPF diferente do loop
	$dados['NUM_CPF'][] 	= '111.111.111-11'; 	$dados['NOM_PESSOA'][]	= 'Usu�rio de teste';

	for($i=0;$i<100;$i++)
	{
		$dados['NUM_CPF'][] 	= '123.456.789-09'; 	$dados['NOM_PESSOA'][]	= 'Usu�rio de teste';
	}
	$rel->setData( $dados );
	$rel->addColumn('Nome'	,100,'L', 'NOM_PESSOA'	,'','I',8,'black','times');
	$rel->addColumn('Cpf'	,50 ,'C', 'NUM_CPF'		,'','B',6,'black','arial');
	$rel->printRows();
	$rel->ln(5);
	$rel->cell(0,5,'Imprimir o gride novamente',1,1,'c');
	$rel->ln(5);
	$rel->printRows();
	$rel->show();
}

function myOdc( TPDFColumn $oCol=null,$value=null,$colIndex=null)
{
	if( $oCol->getFieldName() == 'NUM_CPF' && $value=='111.111.111-11')
	{
		$oCol->setFontColor('red');
		$oCol->setFillColor('yellow');
		$value = 'OPA!! NOVO NOME';
	}
	else
	{
		$oCol->setFontColor('black');
		$oCol->setFillColor('white');

	}
}
// fun��o chamada automaticamente pela classe TPDF quando existir
function cabecalho(TPDF $pdf)
{
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'Cabecalho do Relat�rio','b',1,'C');
	$pdf->ln(3);
	$pdf->SetFont('Times','',10);
}
// fun��o chamada automaticamente pela classe TPDF quando existir
function rodape(TPDF $pdf)
{

		$fs=$pdf->FontSizePt;
        $pdf->SetY(-15);
        $pdf->SetFont('','',8);
	    $pdf->Cell(0,5,'Rodap� do Relat�rio','T',0,'L');
	    $pdf->setx(0);
	    $pdf->Cell(0,5,'P�g '.$pdf->PageNo().'/{nb}',0,0,'C');
	    $pdf->setx(0);
        $pdf->cell(0,5,'Emitido em:'.date('d/m/Y H:i:s'),0,0,'R');
        $pdf->setfont('','',$fs);

}
?>
<script>
function exibir_pdf()
{
	//fwFaceBox(  pastaBase+'js/jquery/facebox/stairs.jpg');
	fwShowPdf({"modulo" : pastaBase + "exemplos/exe_pdf_1.php","des_marcadagua":jQuery("#des_marcadagua").val()});
}
</script>

