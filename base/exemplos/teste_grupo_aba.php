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

$frm= new TForm('Exemplo de Cria��o de Gride',600);
//$frm->setOverflowY(false);
//$frm->setOverflowY(true);
$frm->setFlat(true);


// html dentro do form
$frm->addHtmlField('campo_gridex',null,null,null,100)->setCss('border','1px solid green'); // cria o campo para exibi��o do gride

//grupo dentro do form
$frm->addGroupField('gp','Luis',150,null,null,null,true)->setOverflowY(false);
	$frm->addHtmlField('campo_gride2',null,null,null,100)->setCss('border','1px solid green'); // cria o campo para exibi��o do gride
$frm->closeGroup();

// aba dentro do form
$pc = $frm->addPageControl('pc',150);
$pc->addPage('Cadastro',true,true);
   	$frm->addHtmlField('campo_gride',null,null,null,500)->setcss('border','1px solid green'); // cria o campo para exibi��o do gride
$frm->closeGroup();

//**************************************************************************
// aba dentro de aba
$pc = $frm->addPageControl('pc1',150);
	$pc->addPage('Cadastro',true,true);
	$pc2 = $frm->addPageControl('pc2');
	$pc2->addPage('Subcadastro',true,true);
    $frm->closeGroup();
 $frm->closeGroup();



// grupo dentro de aba
$pc = $frm->addPageControl('pc1',150);
	$pc->addPage('Cadastro',true,true);
		$g=$frm->addGroupField('gp2rew','Eugenio',400,null,null,null,true,null,null,null,null,null,true);
		$frm->closeGroup();
    $frm->closeGroup();
 $frm->closeGroup();
$frm->closeGroup();

// grupo dentro de grupo
$frm->addGroupField('gp2dg','Eugenio',null,null,null,null,true,null,null,null,null,null,true);
	$frm->addGroupField('gp2dg2','Barbosa',null,null,null,null,true,null,null,null,null,null,true);
		$frm->addGroupField('gp2dg21','Barbosa',100,null,null,null,true,null,null,null,null,null,true);

		$frm->closeGroup();
	$frm->closeGroup();
$frm->closeGroup();

// aba dento de aba
$pc = $frm->addPageControl('pcADA',150);
	$pc->addPage('Cadastro',true,true);
	$frm->addDateField('data1','Data1:');
	$pc2 = $frm->addPageControl('pcada2');
	$pc2->addPage('Subaba',true,true);
		$frm->addDateField('data2','Data2');
		$pc3 = $frm->addPageControl('pcada21');
		$pc3->addPage('Subaba2',true,true);
		$frm->addDateField('data3','Data3:');

    $frm->closeGroup();
 $frm->closeGroup();
$frm->closeGroup();




// cria��o do array de dados
for( $i=0; $i<100; $i++ )
{
	$res['SEQ_GRIDE'][] = ($i+1);
	$res['NOM_LINHA'][] = 'Linha n� '. ($i+1);
	$res['DES_LINHA'][] = str_repeat('Linha ',40);
}

$gride = new TGrid( 'idGride' // id do gride
					,'T�tulo do Gride' // titulo do gride
					,$res 		// array de dados
					,250		// altura do gride
					,'100%'		// largura do gride
					,'SEQ_GRIDE'
					,null
					,10
					,'exe_gride_1.php'
					,null
					);
$gride->addColumn('nom_linha','Nome',100);
$gride->addColumn('des_linha','Descricao',1200);

//$gride->autoCreateColumns(); // cria as colunas de acordo com o array de dados
$gride->setNoWrap(false);

// quando for uma chamada ajax, devolver apenas o conteudo do gride, sem o formul�rio
if( isset($_REQUEST['ajax'] ) )
{
	$gride->show();
	exit(0);
}
//error_reporting(E_ALL);
$frm->set('campo_gride',$gride); // adiciona o objeto gride ao campo html
$frm->setAction('Atualizar');
$frm->show();
?>
