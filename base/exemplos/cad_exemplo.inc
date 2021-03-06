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

  $frm = new TForm('Cadastro Exemplo',300);
  $frm->setColumns(array(150,200,300));
  
  $frm->addHiddenField('seq_fruta');
  $frm->addTextField('nom_fruta','Nome:',50,true,50);
  $frm->addNumberField('val_fruta','Pre�o:',10,true,2);
  $frm->addDateField('dat_compra','Aquisi��o:',true);
  
  $frm->addSelectField('sit_cancelado','Cancelado:',true);
  $frm->addMemoField('obs_fruta','Observa��o:',200,false,50,5);
  
  
  $frm->setAction('Gravar,Limpar');
 switch($acao)
  {
  	  case 'Limpar':
  	  	$frm->clearFields();
  	  break;
  	  //-----------------------------------------------------------------------
  	  case 'Gravar':
		if( $frm->validate())
		{
			$bvars = $frm->createBvars('seq_fruta,nom_fruta,val_fruta,seq_moeda,dat_compra,sit_cancelado,obs_fruta');
			if( !$frm->addError( executarPacote('TESTE.PKG_FRUTA.INC_ALT', $bvars ) ) )
			{
				$frm->setMessage('Grava��o ok');
				//$frm->clearFields();
				$frm->setValue('seq_fruta',$bvars['SEQ_FRUTA']);
			}
		}
  	  //-----------------------------------------------------------------------
  	  case 'Excluir':
 			$bvars = $frm->createBvars('seq_fruta');
			$frm->addError( executarPacote('TESTE.PKG_FRUTA.EXC', $bvars));
			$frm->clearFields();
  	  break;
  	  //------------------------------------------------------------------------
  	  case 'Alterar':
  			$bvars = $frm->createBvars('seq_fruta');
			$frm->addError( recuperarPacote('TESTE.PKG_FRUTA.SEL', $bvars,$res,-1));
			$frm->update($res);
  	  break;
  	  //------------------------------------------------------------------------
		
  }
  $frm->show();
?>
