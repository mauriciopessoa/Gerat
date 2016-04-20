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
M�dulo de cadastro de modulos
Autor: Luis Eug�nio Barbosa
Data Inicio: 10-12-2009
*/

//include('../../classes/webform/TForm.class.php');
// campos do formulario
$frm =  new TForm('Cadastro de M�dulos',500,620);
$frm->addHiddenField('seq_projeto',PROJETO);
$frm->addHiddenField('seq_modulo');
$frm->addHiddenField('num_pessoa');
$des_titulo = $frm->addTextField('des_titulo'		,'T�tulo'		,100,true,50);
$frm->addTextField('nom_fisico'		,'Nome F�sico'	,200,true,60);
$frm->addSelectField('cod_situacao'	,'Situa��o'		,true);
$frm->addMemoField('des_observacao'	,'Observa��es'	,1000,false,50,2);
$frm->addMemoField('des_pendencia'	,'Pend�ncias' 	,500,false,50,2);
$frm->addHtmlField('gride');
$frm->setAction('Gravar,Novo');

//$des_titulo->setHint('Hint do campo titulo');
//$frm->setHelpOnLine('Cadastro de M�dulos',null,null,'cad_modulo.html');
//$frm->setEnabled(true);
$frm->setHint('Teste do hint do formulario');
// tratamento das acoes do formulario
switch($acao )
{
	//---------------------------------------------------------------------------------
	case 'Novo':
		$frm->clearFields(null,'seq_projeto');
	break;
	//---------------------------------------------------------------------------------
	case 'Gravar':
		if( $frm->validate() )
		{
			$frm->setValue('nom_fisico',strtolower($frm->getValue('nom_fisico')));
			$bvars = $frm->createBvars('seq_modulo,cod_situacao,des_titulo,des_observacao,des_pendencia,nom_fisico');
			$bvars['SEQ_PROJETO'] = PROJETO;
			if( !$frm->addError(executarPacote(ESQUEMA.'.PKG_SEGURANCA.INC_ALT_MODULO',$bvars,-1) ) )
			{
				$frm->setValue('seq_modulo',$_POST['SEQ_MODULO']);

				// criar o arquivo no disco com um form vazio
				if( strpos( $frm->getValue('nom_fisico'),'/')===false && strpos( $frm->getValue('nom_fisico'),'.')===false )
				{
					$strArquivo = 'modulos/'.$frm->getValue('nom_fisico').'.inc';
					if( file_exists('modulos/') && !file_exists($strArquivo))
					{
						$strConteudo='<?php'."\n".'$frm = new TForm(\''.$frm->getValue('des_titulo').'\');'."\n".'$frm->setAction(\'Atualizar\');'."\n".'$frm->show();'."\n?>";
						umask(2);
						@touch ($strArquivo);
						// verificar se est� aberto para escrita
						if ( is_writeable($strArquivo) )
						{
							if (!$handle = fopen($strArquivo, 'w+'))
							{
					    		fclose($handle);
		    					break;
							}
							if (!fwrite($handle, $strConteudo))
	    					{
	    						fclose($handle);
							}
					    }
					    @fclose($handle);
					}
				}
				$frm->clearFields(null,'seq_projeto,seq_modulo');
			}
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_alterar':
		$bvars = $frm->createBvars('seq_modulo');
		if(!$erro = recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO',$bvars,$res,-1))
		{
			$frm->update($res);
		}
	break;
	//-----------------------------------------------------------------------------
	case 'gd_excluir':
		$bvars = $frm->createBvars('seq_modulo');
		if(!$erro = executarPacote(ESQUEMA.'.PKG_SEGURANCA.EXC_MODULO',$bvars,-1))
		{
			$frm->clearFields(null,'seq_projeto');
		}
	break;
}
// criar o gride
$g = new TGrid('gd'
	,''
	,ESQUEMA.'.PKG_SEGURANCA.SEL_MODULO'
	,null
	,'100%'
	,'SEQ_MODULO'
	,'SEQ_MODULO'
	);
$g->addColumn('DES_TITULO','T�tulo');
$g->setCache(-1);
$g->addColumn('NOM_FISICO','Arquivo Php');
$g->setBvars(array('SEQ_PROJETO'=>PROJETO,'SIT_SISTEMA'=>'N'));
/*
$g->addButton('Alterar');
$g->addButton('Excluir');
*/
$frm->setValue('gride',$g->show(false));

// alimentar combo situacao
print_r(recuperarPacote(ESQUEMA.'.PKG_SEGURANCA.SEL_SITUACAO_MODULO',$bvars,$res));
$frm->setOptionsSelect('cod_situacao',$res,'DES_SITUACAO','COD_SITUACAO');
$frm->show();
?>
