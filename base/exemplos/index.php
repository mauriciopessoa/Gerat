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

define('APLICATIVO','TESTE');
define('FORMDIN',1);
define('DECIMAL_SEPARATOR',',');
//session_start();
//session_destroy();
include('../classes/webform/TApplication.class.php');
$app = new TApplication('Exemplos das Funcionalidades',null,'FORMDIN 4','Centro Nacional de Telem�tica - CNT');
$app->setMenuIconsPath('imagem/');

$app->setWidth(990);
$app->setNorthSize(55);
//$app->getNorthArea()->setCss('border','0px');

$app->setMainMenuFile('menu_principal.php');
$app->setConfigFile(null);
//$app->setLoginFile('includes/tela_login.php');
$app->setOnGetLoginInfo('minhaFuncaoLogin');
//$app->setConnectionFile(null);

//$app->addIncludeFile('config.php');
//$app->setHeaderContent('header.php');
//$app->getLoCenter()->setCss('background-color','blue');
//$app->setBackgroundImage(null);
$app->setBackgroundImage('../css/imagens/app/bg_listrado.jpg');
//$app->setHeaderBgImage('imagem/h2.jpg');
//$app->setHeaderBgImage('imagem/spoa-cabec.gif');
//$app->setMenuTheme('standard');


//$app->setBackgroundImage('../imagens/bg_blackmosaic.png');
/*
//$_SESSION[APLICATIVO]["login"]["username"]='postgres';
//$_SESSION[APLICATIVO]["login"]["password"]='123456';
//$_SESSION[APLICATIVO]["database"]='teste';
$pdo1=TPDOConnection::connect();
print_r($pdo1);
$conn1 = TPDOConnection::getInstance();
$pdo2=TPDOConnection::setDataBaseName('teste');
$conn2 = TPDOConnection::getInstance();

$stmt=$conn1->query('select * from tbteste');
$res = $stmt->fetchAll();
print_r($res);
print '<hr>';
$stmt=$conn2->query('select * from tbteste');
$res = $stmt->fetchAll();
print_r($res);
print '<hr>';
print_r( $pdo1->executeSql('select * from tbteste') );
print '<hr>';
print_r( $pdo2->executeSq1('select * from tbteste') );
print '<hr>';



return;
TPDOConnection::Test(false);
/*
$sql = "SELECT schemaname AS esquema, tablename AS tabela, tableowner AS dono
 						FROM pg_catalog.pg_tables
 						WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
 						ORDER BY schemaname, tablename";

print_r( TPDOConnection::executeSql($sql));

print 'Banco:postgres esquema:public<br>';
TPDOConnection::setDataBaseName('postgres');
print_r( TPDOConnection::executeSql('select * from tbteste ') );
print '<hr>';
print 'Banco:teste esquema:public<br>';
TPDOConnection::setDataBaseName('teste');
TPDOConnection::setDieOnError(false);
print_r( TPDOConnection::executeSql('select * from tbteste ') );
print '<hr>';
print 'Banco:teste esquiema:producao<br>';
//TPDOConnection::setDataBaseName('producao');
print_r( TPDOConnection::executeSql('select * from producao.usuario ') );
die('fim');
*/

// testar prototy�

$app->run();

function minhaFuncaoLogin()
{
    return 'Ol�';
}
?>