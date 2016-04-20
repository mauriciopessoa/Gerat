<?php
error_reporting(E_ALL);
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
error_reporting(E_ALL);

$frm = new TForm('Exemplo de Com Campos Editáveis');
$frm->addTextField('nome','Nome:',30,true);

$dados = null;
$dados['ID_TABELA'][] = 1;
$dados['NM_TABELA'][] = 'Linha1';
$dados['ST_TABELA'][] = 'S';
$dados['ST_PERFIL'][] = 'S';
$dados['SIT_OPCOES'][] = '1=>Um,2=>Dois';
$dados['VAL_OPCAO'][] = '';

$dados['ID_TABELA'][] = 2;
$dados['NM_TABELA'][] = 'Linha2';
$dados['ST_TABELA'][] = 'S';
$dados['ST_PERFIL'][] = 'S';
$dados['SIT_OPCOES'][] = '3=Tres,4=>Quatro';
$dados['VAL_OPCAO'][] = '3';

$dados['ID_TABELA'][] = 3;
$dados['NM_TABELA'][] = 'Linha3';
$dados['ST_TABELA'][] = 'N';
$dados['ST_PERFIL'][] = 'S';
$dados['SIT_OPCOES'][] = '5=Cinco,6=Seis';
$dados['VAL_OPCAO'][] = '6';

$dados['ID_TABELA'][] = 4;
$dados['NM_TABELA'][] = 'Linha4';
$dados['ST_TABELA'][] = 'S';
$dados['ST_PERFIL'][] = 'S';
$dados['SIT_OPCOES'][] = 'ipe=>ipe';
$dados['VAL_OPCAO'][] = 'ipe';



$gride = new TGrid( 'gdxy' // id do gride
					,'Título do Gride' // titulo do gride
					,$dados 	// array de dados
					,250		// altura do gride
					,null		// largura do gride
					,'ID_TABELA'
					,'NM_TABELA|nome'
					);

$gride->addRadioColumn('st_perfil','Perfil','ST_PERFIL','NM_TABELA');
$gride->addColumn('nm_tabela'	,'Tabela',20,20);
$gride->addCheckColumn('st_tabela','Aprovado','ST_TABELA','NM_TABELA')->setEvent('onClick','chkClic()');
$gride->addTextColumn('id_tabela','ID','ID_TABELA',20,20);
//$gride->addTextColumn('nm_tabela','Nome da Tabela','NM_TABELA',60,80);
$gride->addColumn('link','Link',200,'center');
//$gride->addSelectColumn('sit_opcoes','Opções','SIT_OPCOES','1=Amarelo,2=Verde');
$gride->addSelectColumn('sit_opcoes','Opções','SIT_OPCOES',null,null,null,null,null,null,null,'VAL_OPCAO');


//$gride->setOnDrawCell('gdAoDesenharCelula');
//$gride->setOnDrawHeaderCell('gdAoDesenharCab');

$frm->addHtmlField('gride',$gride);
$frm->setAction('Atualizar');

$frm->show();

function gdAoDesenharCab($th,$objColumn,$objHeader )
{
	//echo $objHeader->getId().',';
	//echo $objColumn->getFieldName().',';

	if( $objColumn->getFieldName() == 'ST_TABELA')
	{
			$btn = new TButton('btn',null,null,null,null,'lixeira.gif',null,'Exemplo - texto da Dica');
			$btn->setProperty('tooltip','true');
			$objHeader->clearChildren();
			$objHeader->add($btn);
	}

}
function gdAoDesenharCelula($rowNum,$cell,$objColumn,$aData,$edit)
{
	if( $objColumn->getFieldName() == 'ST_TABELA')
	{
		if( $edit )
		{
			$edit->setProperty( 'title','teste');
			$edit->setProperty( 'tooltip','true');
		}
	}
	else if( $objColumn->getFieldName() == 'link')
	{
		$link = new TElement('a');
		$link->setId('link'.$rowNum);
		$link->setProperty('href','#');
		$link->add('Clique Aqui');
		$link->addEvent('onclick','alert("Link '.$rowNum.' foi clicado!")');
		$cell->setValue($link);
	}
}
?>
<script>
function chkClic(e, linha)
{
	// criar o campo texto
    if( jQuery(e).is(':checked') )
    {
    	jQuery(e).parent().append('<input class="fwField" style="border:1px solid #c0c0c0" id="'+e.id+'_texto" type="text" size="30" value="">');
    }
    else // remover o campo texto
    {
    	jQuery("#"+e.id+'_texto').remove();
    }
}
</script>