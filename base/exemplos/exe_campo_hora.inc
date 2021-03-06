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
  $frm = new FormDin3(null,'Teste Campo Hora',$_POST);
  $frm->adicionarCampoHora('hor_inicial','Hora:',false,null,null,5,5,null,null);
  $frm->adicionarCampoInteiro('qtd_total','Qtd:',true,null,null,8,10,null,null,null,null,null,null,null);
  $frm->adicionarCampoDecimal('val_total','Valor:',true,null,null,2,10,12);

  $frm->botaoAcao[''] = array( 'Gravar');
  $frm->validar();
  print $frm->criarForm();
  /*print 'Total:'.$frm->get('qtd_total');
  print ' e '.$frm->getFormated('qtd_total');
  */
  //print_r($_POST);

include("../classes/webform/TForm.class.php");
$frm = new TForm('Exemplo Campo Hora');
$frm->addTextField('nom_pessoa','Nome:',50,false)->setEnabled(false);
$fld = $frm->addTimeField('hor_entrada','Hora Entrada:',true,'05:00','23:00','99:99');
$frm->addTimeField('hor_inicio2','Hora:',false,'12:00:00','15:00:00','HMS');
$frm->addButton('Validar','validar','btnValidar');
if( $acao=='validar' )
{
	$frm->validate();
}
$frm->show();
?>
