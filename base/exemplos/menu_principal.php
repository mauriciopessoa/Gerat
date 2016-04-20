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

// url para teste: http://index.php?modulo=menu_principal.php&ajax=1&content-type=xml
$menu =  new TMenuDhtmlx();
$menu->add('1',null,'Campos',null,null,'user916.gif');
$menu->add('11','1','Campo Texto',null,'Declara��o de texto');
$menu->add('11.1','11','Campo Texto','exe_TextField.php');
$menu->add('11.2','11','Autocompletar','exe_autocomplete.php');
$menu->add('11.3','11','Autocompletar II','exe_autocomplete2.php');
$menu->add('11.4','11','Consulta On-line I','exe_onlinesearch1.php');


$menu->add('12','1','Campo HTML','exe_HtmlField.php');
$menu->add('13','1','Campo Coord GMS','exe_CoordGmsField.php');
$menu->add('14','1','Campo Select','exe_SelectField.php');
$menu->add('15','1','Campo Radio','exe_RadioField.php');
$menu->add('16','1','Campo Check','exe_CheckField.php');
$menu->add('17','1','Campo Arquivo');
  $menu->add('171','17','Assincrono','exe_FileAsync.php');
  $menu->add('172','17','Normal','exe_TFile.php');
$menu->add('18','1','Campo Num�rico','exe_NumberField.php');
$menu->add('19','1','Campo CEP'	,'exe_CepField.php');
$menu->add('20','1','Campo Telefone'	,'exe_FoneField.php');
$menu->add('21','1','Campo Cpf/Cnpj'	,'exe_campo_cpf_cnpj.php');

$menu->add('110','1','Campo Data'	,'exe_DateField.php');
$menu->add('111','1','Campo Select Diretorio/Pasta'	,'exe_OpenDirField.php');
$menu->add('112','1','Campo Fuso Hor�rio'	,'exe_TTimeZoneField.php');
$menu->add('113','1','Campo Editor'	,'exe_TTextEditor.php');
$menu->add('114','1','Campo Memo'	,'exe_TMemo.php');
$menu->add('115','1','Campo Senha'	,'exe_TPasswordField.php');
$menu->add('116','1','Campo Agenda'	,'exe_TCalendar.php');
$menu->add('117','1','Campo Captcha'	,'exe_TCaptchaField.php');
$menu->add('118','1','Campo Blob'	);
$menu->add('1181','118','Campo Blob Salvo no Banco'		,'exe_fwShowBlob.php');
$menu->add('1182','118','Campo Blob Salvo no Disco'		,'exe_fwShowBlobDisco.php');
$menu->add('119','1','Campo Cor'		,'exe_TColorPicker.php');
$menu->add('120','1','Tecla de Atalho'		,'exe_Shortcut.php');




$menu->add('2',null,'Containers');
$menu->add('22','2','Grupo');
	$menu->add('221','22','Grupo Normal','exe_GroupField.php');
	$menu->add('222','22','Grupo Combinados ( Efeito Sanfona )','exe_GroupField_2.php');

$menu->add('23','2','Aba'		,'exe_aba_1.php');
$menu->add('24','2','TreeView');
$menu->add('241','24','Dentro do Formul�rio' ,'exe_tree_view_1.php');
$menu->add('242','24','Fora do Formul�rio'	,'exe_tree_view_2.php');
$menu->add('243','24','User Data - Array'	,'exe_tree_view_3.php');
$menu->add('244','24','Uf x Munic�pios'		,'exe_tree_view_4.php');
$menu->add('245','24','Uf x Munic�pios com SetXmlFile()' ,'exe_tree_view_5.php');

$menu->add('4',null,'Ajuda On-line (sqlite)','exe_documentacao_online.inc','Confe��o do texto de ajuda gravando no banco de dados sqlite');


$menu->add('5',null,'Ajax');
$menu->add('51','5','Exemplo 1','exe_ajax_1.php');
$menu->add('52','5','Atualizar Campos','exe_ajax_2.php');
$menu->add('53','5','Bot�o Ajax','exe_TButtonAjax.php');
$menu->add('54','5','Ajax com Sem�foro','exe_ajax_semaphore.php');

$menu->add('6',null,'PDF');
$menu->add('61','6','Exemplo 1','exe_pdf_1.php');
$menu->add('62','6','Exemplo 2','exe_pdf_2.php');

$menu->add('7',null,'Mensagens');
$menu->add('71','7','Exemplo 1','exe_mensagem.php');
$menu->add('72','7','Caixa de Confirma��o','exe_confirmDialog.php');

$menu->add('8',null,'Gride');
$menu->add('81','8','Exemplo 1','exe_gride_1.php');
$menu->add('82','8','Exemplo 2 - Anexos - Ajax','exe_gride_2.php');
$menu->add('83','8','Grid Offline','exe_gride_3.php');
$menu->add('84','8','Grid Offline com fwGetGrid()','exe_gride_4.php');
$menu->add('85','8','Pagina��o','exe_gride_paginacao.php');
$menu->add('86','8','Fun��o getGrid()','exe_gride_4.php');
$menu->add('87','8','Gride com Campos','exe_gride_10.php');

$menu->add('9',null,'PDO');
$menu->add('91','9','Exemplo Mysql','exe_pdo_1.php');
$menu->add('92','9','Exemplo Sqlite e Mysql','exe_pdo_2.php');
$menu->add('93','9','Exemplo Postgres');
 $menu->add('931','93','DAO e VO','exe_pg_dao_vo_1.php');
$menu->add('94','9','Exemplo Firebird');
 $menu->add('941','94','Conex�o','exe_firebird_1.php');
$menu->add('99','9','Gerador VO/DAO','../includes/gerador_vo_dao.php');
$menu->add('95','9','Testar Conex�o','exe_teste_conexao.php');


$menu->add('101',null,'Hints');
$menu->add('1011','101','Exemplo I','exe_hint.php');

$menu->add('102',null,'Teste','teste.php');
$menu->add('103',null,'Formul�rio');
	$menu->add('1031','103','Normal','exe_TForm.php');
	$menu->add('1032','103','Subcadastro','exe_TForm2.php');
	$menu->add('1033','103','Boxes','exe_TBox.php');
	$menu->add('1034','103','Mestre Detalhe com Ajax','cad_mestre_detalhe/cad_mestre_detalhe.php');
	$menu->add('1035','103','Imagem de Fundo','exe_TFormImage.php');
	$menu->add('1036','103','Customizado com CSS','exe_TForm3.php');
	$menu->add('1037','103','Recurso de Autosize','exe_TForm_autosize.php');


$menu->add('104',null,'TZip','exe_TZip.php');

$menu->add('199',null,'Temas do Menu','exe_menu_tema.php');


//$menu->add('520','5','Exemplo Select Combinado','exe_select_combinado_ajax.php');
$menu->getXml();
?>