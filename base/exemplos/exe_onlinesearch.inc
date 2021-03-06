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

$frm = new TForm('Consulta Din�mica');
$frm->setColumns(array(200));
$frm->addTextField('id','id:',10);

$frm->addCpfField('num_cpf1','CPF:',null,null,false)->setExampleText('Informe o cpf e tecle &lt;enter&gt;')->setEnabled(false);;
$frm->addTextField('nom_pessoa1','Nome 1:',50,false);
$frm->addTextField('nom_pessoa','Nome:',50,false);
$frm->addTextField('end_pessoa_eugenio','Endere�o:',50,false);
$frm->addTextField('des_bairro','Bairro:',50,false);
$frm->addTextField('cod_matricula_eugenio','Matricula:',10,false);
$frm->addTextField('num_cep','Cep:',10,false);
$frm->addTextField('dat_nasc','Nacimento:',10,false);

$frm->addCpfField('campo_teste1','Teste Evento Before Execute:');
$frm->addCpfField('campo_teste2','Teste com Multi Select:',null,null,false);
$frm->addTextField('nom_fruta','Fruta:',20)->setExampleText('Com cadastro on-line de frutas se a pesquisa retornar vazia');
$frm->addTextField('num_pessoa','Pessoas Selecionadas:',50)->setEnabled(false);
$frm->addMemoField('obs','Observa��o:',2000,false);
$_POST['fw_back_to'] = 'modulos/teste.php';
$frm->set('fw_back_to','modulos/teste.php');


$a = array(1=>'sim',2=>'nao');
//$frm->clearFields();
$frm->setOnlineSearch('num_cpf1'
	, 'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	, 'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50,COD_NELSON|Chefe||||SELECT'
	, 'NUM_CPF1,NOM_PESSOA1'
	, true
	, null
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA,COD_MATRICULA|cod_matricula_eugenio,END_PESSOA|end_pessoa_eugenio,DES_BAIRRO,NUM_CEP,DAT_NASC,NUM_CPF'
	,'Consulta Pessoa F�sica'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,'fwFazerAcao("Nova Acao")'
	,10 // m�ximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,array('COD_NELSON'=>$a)
	,null
	,false
	,'base/exemplos/exe_select.inc'
	);

$frm->setOnlineSearch('campo_teste1'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA'
	,'Consulta Pessoa F�sica'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,'id'
	,'retorno()'
	,10 // m�ximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,null
	,'chkForm()'
	);
$frm->setOnlineSearch('campo_teste2'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NUM_PESSOA|id,NOM_PESSOA'
	,'Consulta Pessoa F�sica'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,null// 'retorno()'
	,10 // m�ximo de registros retorno
	,null
	,'NUM_PESSOA' // campo que receber� as linhas selecinadas na consulta dinamica
	,'NOM_PESSOA'
	,null
	,null
	,null
	);
$frm->setOnlineSearch('nom_fruta'
	,'TESTE.PKG_FRUTA.SEL'
	,'NOM_FRUTA|Fruta:|50'
	, 'NOM_FRUTA'
	, true
	, true
	,'NOM_FRUTA|Fruta'
	,'NOM_FRUTA'
	,'Consulta Frutas'
	,'Registros Encontrados'
	,null
	,400
	,900
	,"Consultar"
	,null
	,null// 'retorno()'
	,10 // m�ximo de registros retorno
	,'$res["NOM_FRUTA"][$k]!="Banana"'
	,null
	,null
	,null
	,null
	,null
	,'base/exemplos/cad_fruta.inc'
	);


$frm->setOnlineSearch('obs'
	,'TESTE.PKG_SEGURANCA.SEL_DADOS_PESSOA'
	,'NUM_CPF|CPF:||||cpf,NOM_PESSOA|Nome:|50'
	, null // 'NUM_CPF'
	, true
	, true
	,'NUM_CPF|Cpf,NOM_PESSOA|Nome'
	,'NOM_PESSOA|obs'
	,'Consulta Pessoa F�sica'
	,'Registros Encontrados'
	,'des_endereco'
	,400
	,900
	,"Consultar"
	,null
	,null
	,10 // m�ximo de registros retorno
	,null
	,null
	,'NOM_PESSOA'
	,null
	,null
	);


$frm->disableFields('nom_pessoa,id');
$frm->setAction('Atualizar');

//print 'Acao:'.$acao;
$frm->show();
?>
<script>
function retorno()
{
	fwModalBox('Teste','http://www.bb.com.br',800,600);
}
function chkForm()
{
	if(!fwGetObj('num_cpf').value)
	{
		alert('Preencha o cpf primeiro');
		return false;
	}
	return confirm('Confirma consulta on-line?');
}
</script>
