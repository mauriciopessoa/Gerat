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

//d($_REQUEST);
$frm= new TForm('Exemplo de Cria��o de Gride');
// html dentro do form
$frm->addHtmlField('campo_gride');

// quando for uma chamada ajax, devolver apenas o conteudo do gride, sem o formul�rio
if( $_REQUEST['action'] == 'atualizar_gride' )
{
	// cria��o do array de dados
	for( $i=0; $i<30; $i++ )
	{
		$res['SEQ_GRIDE'][] = ($i+1);
		$res['NOM_LINHA'][] = 'Linha n� '. (10-$i+1);
		$res['DES_LINHA'][] = $i.' - '.str_repeat('Linha ',20);
		$res['VAL_PAGO'][]  = str_pad($i,5,'0',STR_PAD_LEFT);
		$res['SIT_CANCELADO'][] = $i;
		$res['DES_AJUDA'][] = 'Ajuda - Este � o "texto" <B>que</B> ser� exibido quando o usu�rio posicionar o mouse sobre a imagem, referente a linha '.($i+1);

	}
	$gride = new TGrid( 'idGride' // id do gride
						,'T�tulo do Gride' // titulo do gride
						,$res 		// array de dados
						,250		// altura do gride
						,null		// largura do gride
						,'SEQ_GRIDE'
						,null
						);
	$gride->addColumn('nom_linha'	,'Nome',100);
	$gride->addColumn('des_linha'	,'Descri��o',800);
	$gride->addColumn('val_pago'	,'Valor',1000);
	$gride->show();
	exit(0);
}
//error_reporting(E_ALL);
$frm->set('campo_gride',''); // adiciona o objeto gride ao campo html
$frm->addButton('Ler Gride',null,'btnx','atualizar_gride()');
$frm->show();


?>
<script>
function atualizar_gride()
{
	fwGetGrid('exe_gride_4.php','campo_gride',{"action":"atualizar_gride"},true);
}
</script>