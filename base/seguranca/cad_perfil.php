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
Sistema FASIS
M�dulo de cadastro de perfis de acesso do projeto
Autor: Luis Eug�nio Barbosa
Data: 15/12/2009
*/
for ($i=1;$i<51;$i++)
{
	$aNiveisPerfil[$i]=$i;
}
$frm = new TForm('Cadastro de Perfil de Acesso',null,550);
// campos do formulario
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_perfil','');

$frm->addTextField('des_perfil'		, 'Nome do Perfil',50,true);
$frm->addSelectField('num_nivel'	, 'N�vel Hierarquico',true,$aNiveisPerfil);
$frm->addSelectField('sit_publico'	,'P�blico',true,array('N'=>"N�o","S"=>"Sim"));
$frm->addSelectField('sit_cancelado','Cancelado',true,array('N'=>"N�o","S"=>"Sim"));
$frm->addHtmlGride('gride'			,'base/seguranca/gride_perfil.php','gd')->setCss('width',500);

$frm->setAction('Gravar,Novo');

// tratamento das acoes do formulario
switch($acao )
{
	case 'Novo':
		$frm->clearFields();
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( $frm->validate() )
		{
			$bvars = $frm->createBvars('seq_perfil,seq_projeto,des_perfil,num_nivel,sit_publico,sit_cancelado');
			if(!$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_PERFIL',$bvars,-1) ) )
			{
				$frm->clearFields();
			}
		}
	break;
	//---------------------------------------------------------------------------------
	case 'gd_excluir':
		$bvars = $frm->createBvars('seq_perfil');
		if(!$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_PERFIL',$bvars,-1) ) )
		{
			$frm->clearFields();
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('seq_perfil');
		if(!$frm->addError(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_PERFIL_PROJETO',$bvars,$res,-1) ) )
		{
			$frm->update($res);
		}

	break;
}
$frm->setValue('seq_projeto',PROJETO);
$frm->show();
?>
