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

//d($_REQUEST);
$frm= new TForm('Exemplo de Criação de Gride',600,800);
// html dentro do form
$frm->addHtmlField('campo_gride');

// criação do array de dados
for( $i=0; $i<30; $i++ )
{
	$res['SEQ_GRIDE'][] = ($i+1);
	$res['NOM_LINHA'][] = 'Linha nº '. (10-$i+1);
	$res['DES_LINHA'][] = $i.' - '.str_repeat('Linha ',20);
	$res['VAL_PAGO'][]  = str_pad($i,5,'0',STR_PAD_LEFT);
	$res['SIT_CANCELADO'][] = $i;
	$res['DES_AJUDA'][] = 'Ajuda - Este é o "texto" <B>que</B> será exibido quando o usuário posicionar o mouse sobre a imagem, referente a linha '.($i+1);

}

$gride = new TGrid( 'idGride' // id do gride
					,'Título do Gride' // titulo do gride
					,$res 		// array de dados
					,250		// altura do gride
					,null		// largura do gride
					,'SEQ_GRIDE'
					,null
					,10
					,'exe_gride_1.php'
					,null
					);
$gride->setOnDrawCell('confGride');
$gride->setOnDrawActionButton('confButton');
$gride->addColumn('nom_linha'	,'Nome',100);
$gride->addColumn('des_linha'	,'Descrição',800);
$gride->addColumn('val_pago'	,'Valor',1000);
$gride->setDisabledButtonImage('fwDisabled.png');


//$gride->addMemoColumn('memox', 'Observações','DES_LINHA', 2000, 50, 5,false)->addEvent( 'onBlur','opa()');
//$gride->addTextColumn('textx', 'Nome', 'NOM_LINHA', 20, 20)->addEvent( 'onBlur','opa()');
//$gride->addNumberColumn('val_pago','Valor Pago','VAL_PAGO',10,2,false)->addEvent( 'onchange','opa()');;
//$gride->addCheckColumn('chkTeste', 'Válido','sit_cancelado');
//error_reporting(E_ALL);
//$gride->addCheckColumn('chk_num_pessoa','','SEQ_GRIDE','NOM_LINHA');
//$gride->addSelectColumn('seq_tipo','','SEQ_TIPO','1=Um,2=Dois');
//$gride->addCheckColumn('chkTeste', 'Válido','sit_cancelado');

//$gride->addCheckColumn('colX','?','SEQ_GRIDE','NOM_LINHA')->addEvent('onclick','alert(this.id)');
//$gride->autoCreateColumns(); // cria as colunas de acordo com o array de dados
//$gride->setNoWrap(false);

// quando for uma chamada ajax, devolver apenas o conteudo do gride, sem o formulário
if( isset($_REQUEST['ajax'] ) )
{
	$gride->show();
	exit(0);
}
//error_reporting(E_ALL);
$frm->set('campo_gride',$gride); // adiciona o objeto gride ao campo html
$frm->setAction('Atualizar');
$frm->show();

function confButton($rowNum,$button,$objColumn,$aData)
{
  if( $rowNum==2)
  {
  	$button->setEnabled(false);
  }
}

function confGride(  $rowNum,$cell,$objColumn,$aData, $edit)
{

		if( $aData['VAL_PAGO']==100)
		{
			if( $edit )
			{
				//NOM_LINHA,VAL_PAGO,sit_cancelado,
				//print $objColumn->getFieldName().',';
				if( $objColumn->getFieldName()=='sit_cancelado')
				{
					$edit->setProperty('disabled','true');
				}
			}
		}
		/*if( $objColumn->getFieldName()=='des_linha')
		{
			$img = '<img src="../imagens/ajuda.gif" toolTip="true" style="cursor:pointer;" title="'.htmlentities($aData['DES_AJUDA']).'">';
			$cell->add($img);
		}
		*/
		if( $objColumn->getFieldName()=='des_linha')
		{
			$img = new TElement('img');
			$img->setcss('cursor','pointer');
			$img->setAttribute('toolTip','true'); // para utiliza o hint modificado pelo jQuery
			$img->setAttribute('src',$img->getBase().'imagens/ajuda.gif');
			$img->setAttribute('title',htmlentities($aData['DES_AJUDA']));
			$cell->add($img);
		}
}

?>
<script>
	function opa(e,rownum)
	{
		alert(e.id+'\nLinha:'+rownum+'\nseq_linha:'+e.getAttribute('seq_gride'));
	}
</script>