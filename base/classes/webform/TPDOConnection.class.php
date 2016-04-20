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
//http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html
foreach(PDO::getAvailableDrivers() as $driver)
{
	  echo $driver.'<br />';
}
$result = $dbh->query($sql);
foreach($dbh->errorInfo() as $error)
	{
	echo $error.'<br />';
	}

*/
class TPDOConnection
{
	private static $error = null;
	private static $instance = null;
	private static $banco;
	private static $dns;
	private static $password;
	private static $username;
	private static $lastSql;
	private static $lastParams;
	private static $utfDecode;
	private static $useSessionLogin;
	private static $dieOnError;
	private static $showFormErrors;
	private static $databaseName;
	private static $message;
	private static $schema;
	private static $configFile;

	// construtor
	private function __construct()
	{
	}

	//------------------------------------------------------------------------------------------
	public static function connect( $configFile = null, $boolRequired = true, $boolUtfDecode = null )
	{

		$configErrors = array();
		self::setUtfDecode( $boolUtfDecode );

		if ( self::getDataBaseName() )
		{
			$configFileDb = $configFile;

			if ( is_null( $configFileDb ) || !file_exists( $configFileDb . '_' . self::getDataBaseName() ) )
			{
				$configFileDb = is_null( $configFileDb ) ? 'config_conexao_' . self::getDataBaseName() . '.php' : $configFileDb;

				if ( !file_exists( $configFileDb ) )
				{
					$configFileDb = 'includes/' . $configFileDb;

					if ( !file_exists( $configFileDb ) )
					{
						$root = self::getRoot();
						$configFileDb = $root . $configFileDb;

						if ( file_exists( $configFileDb ) )
						{
							$configFile = $configFileDb;
						}
					}
					else
					{
						$configFile = $configFileDb;
					}
				}
				else
				{
					$configFile = $configFileDb;
				}
			}
			else
			{
				$configFile = $configFileDb;
			}
		}

		if ( is_null( $configFile ) || !file_exists( $configFile ) )
		{
			$configFile = is_null( $configFile ) ? 'config_conexao.php' : $configFile;

			if ( !file_exists( $configFile ) )
			{
				$configFile = 'includes/config_conexao.php';

				if ( !file_exists( $configFile ) )
				{
					$root = self::getRoot();
					$configFile = $root . 'includes/config_conexao.php';
				}
			}
		}

        self::$configFile = $configFile;

		if ( !file_exists( $configFile ) )
		{
			if ( $boolRequired )
			{
				self::showExemplo( 'MYSQL', array( "Classe TPDOConnectio.class.php - Arquivo {$configFile} n�o encontrado!" ));
			}
			return false;
		}
		else
		{
			require_once( $configFile );

			if ( !defined( 'USE_SESSION_LOGIN' ) )
			{
				define( 'USE_SESSION_LOGIN', 0 );
			}

			if ( !defined( 'SENHA' ) )
			{
				define( 'SENHA', NULL );
			}

			if ( !defined( 'USUARIO' ) )
			{
				define( 'USUARIO', NULL );
			}

			if ( !defined( 'HOST' ) )
			{
				$configErrors[] = 'Falta informar o HOST';
			}

			if ( !defined( 'BANCO' ) )
			{
				self::showExemplo( 'MYSQL', array( 'O arquivo ' . $root . 'includes/config_conexao.php n�o est� configurado corretamente!' ));
			}

			if ( is_null( self::$utfDecode ) && defined( 'UTF8_DECODE' ) )
			{
				self::setUtfDecode( UTF8_DECODE );
			}

			self::$banco = strtoupper( BANCO );

			if ( USE_SESSION_LOGIN )
			{
				if ( !isset( $_SESSION[ APLICATIVO ][ 'login' ][ 'password' ] ) )
				{
					die ( 'Para utilizar usu�rio e senha do usu�rio logado,<br>defina as var�aveis de sess�o:<b>$_SESSION[APLICATIVO]["login"]["username"]</b> e <b>$_SESSION[APLICATIVO]["login"]["password"]</b>.' );
				}
				self::$password = $_SESSION[ APLICATIVO ][ 'login' ][ 'password' ];
				self::$username = $_SESSION[ APLICATIVO ][ 'login' ][ 'username' ];
			}
			else
			{
				self::$password = SENHA;
				self::$username = USUARIO;
			}
			switch( self::$banco )
			{
				case 'MYSQL':
					if ( !defined( 'PORT' ) )
					{
						define( 'PORT', '3306' );
					}

					if ( !defined( 'DATABASE' ) )
					{
						$configErrors[] = 'Falta informar o DATABASE';
					}

					if ( count( $configErrors ) > 0 )
					{
						self::showExemplo( 'MYSQL', $configErrors );
					}
					self::$dns = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT;
                                        
                                        //self::$dns = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT .';charset=utf-8';
                                        
					break;

				//-----------------------------------------------------------------------
				case 'POSTGRES':
					if ( !defined( 'PORT' ) )
					{
						define( 'PORT', '5432' );
					}

					if ( !self::getDataBaseName() )
					{
						$configErrors[] = 'Falta informar o nome do DATABASE';
					}
					if ( defined( 'SCHEMA' ) )
					{
						self::setSchema(SCHEMA);
					}

					if ( count( $configErrors ) > 0 )
					{
						self::showExemplo( 'POSTGRES', $configErrors );
					}
					self::$dns = 'pgsql:host=' . HOST . ';dbname=' . self::getDataBaseName() . ';port=' . PORT;
					break;

				//-----------------------------------------------------------------------
				case 'SQLITE':
					$configErrors = null;

					if ( !defined( 'DATABASE' ) )
					{
						$configErrors[] = 'Falta informar o caminho do banco de dados.';
					}

					if ( count( $configErrors ) > 0 )
					{
						self::showExemplo( 'SQLITE', $configErrors );
					}

					if ( !file_exists( DATABASE ) )
					{
						$configErrors[] = 'Arquivo ' . DATABASE . ' n�o encontrado!';
					}
					self::$dns = 'sqlite:' . DATABASE;
					break;

				//-----------------------------------------------------------------------
				case 'ORACLE':
					if ( !defined( 'PORT' ) )
					{
						define( 'PORT', '1521' );
					}

					if ( !defined( 'SERVICE_NAME' ) )
					{
						$configErrors[] = 'Falta informar o SERVICE_NAME';
					}
					self::$dns = "oci:dbname=(DESCRIPTION =(ADDRESS_LIST=(ADDRESS = (PROTOCOL = TCP)(HOST = " . HOST . ")(PORT = " . PORT . ")))(CONNECT_DATA =(SERVICE_NAME = " . SERVICE_NAME . ")))";
					//self::$dns = "oci:dbname=".SERVICE_NAME;
					break;

				//----------------------------------------------------------
				case 'SQLSERVER':
					if ( !defined( 'PORT' ) )
					{
						define( 'PORT', '1433' );
					}

					if ( !defined( 'DATABASE' ) )
					{
						$configErrors[] = 'Falta informar o DATABASE';
					}

					// Dica de Reinaldo A. Barr�to Junior para utilizar o sql server no linux
					if (PHP_OS == "Linux") {
						$driver = 'dblib';
					} else {
						$driver = 'mssql';
					}

					self::$dns = $driver.':host=' . HOST . ';dbname=' . DATABASE . ';port=' . PORT;
					break;
				//----------------------------------------------------------
				case 'FIREBIRD':
					$configErrors = null;
					if ( !defined( 'DATABASE' ) )
					{
						$configErrors[] = 'Falta informar o caminho do banco de dados.';
					}

					if ( count( $configErrors ) > 0 )
					{
						self::showExemplo( 'FIREBIRD', $configErrors );
					}

					if ( !file_exists( DATABASE ) )
					{
						$configErrors[] = 'Arquivo ' . DATABASE . ' n�o encontrado!';
					}
					self::$dns = 'firebird:dbname='.DATABASE;
					break;
				//----------------------------------------------------------
				case 'MSACCESS':
				case 'ACCESS':
					$configErrors = null;
					if ( !defined( 'DATABASE' ) )
					{
						$configErrors[] = 'Falta informar o caminho do banco de dados.';
					}

					if ( count( $configErrors ) > 0 )
					{
						self::showExemplo( 'ACCESS', $configErrors );
					}

					if ( !file_exists( DATABASE ) )
					{
						$configErrors[] = 'Arquivo ' . DATABASE . ' n�o encontrado!';
					}
					self::$dns = 'odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq='.DATABASE.';Uid='.self::$username.';Pwd='.self::$password;
					break;

				//----------------------------------------------------------
				default:
					$configErrors[] = 'Falta informar o BANCO';
					break;
			//----------------------------------------------------------
			}
		}

		try
		{
			if ( count( $configErrors ) > 0 )
			{
				self::showExemplo( self::$banco, $configErrors );
			}
			self::$instance[ self::getDatabaseName()] = new PDO( self::$dns, self::$username, self::$password );
			self::$instance[ self::getDatabaseName()]->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch( PDOException $e )
		{
			self::$error = utf8_encode( 'Erro de conex�o.<br><b>DNS:</b><br>' . self::$dns . '<br><BR><b>Erro retornado:</b><br>'
				. $e->getMessage() );
			return false;
		}

		return true;
	}

	//-------------------------------------------------------------------------------------------
	public static function showError( $error = null )
	{
		if ( !is_null( $error ) )
		{
			self::$error = $error;
		}

		if ( self::$error )
		{
			if ( self::getDieOnError() && ( !isset( $_REQUEST[ 'ajax' ] ) || !$_REQUEST[ 'ajax' ] ) )
			{
				die ( self::getError());
			}
			else
			{
				if ( self::getShowFormErrors() )
				{
					echo self::getError();
				}
			}
		}
		return null;
	}

	//-------------------------------------------------------------------------------------------
	public static function setError( $strNewValue = null )
	{
		self::$error = $strNewValue;
	}

	//-------------------------------------------------------------------------------------------
	public static function getError()
	{
		if ( self::$error )
		{
			return utf8_decode( '<br><b>Erro PDO:</b> ' . self::$error . '<br/><br/><b>Sql: </b>' . self::$lastSql . '<div><br/></div><b>Parametros: </b> ' . print_r( self::$lastParams, true ) );
		}

		if ( self::getMessage() )
		{
			return self::getMessage();
		}
		return null;
	}

	//-------------------------------------------------------------------------------------------
	public static function getInstance()
	{
		if ( self::getDataBaseName() )
		{
			if ( !self::$instance[ self::getDatabaseName()] )
			{
				self::connect( null, false );
				if ( !self::$instance[ self::getDatabaseName()] )
				{
					return false;
				}

				if( self::getSchema() )
				{
					if( self::getDataBaseName() == 'POSTGRES')
					{
						self::executeSQL('set search_path="'.self::getSchema().'"');
					}
				}
			}
			return self::$instance[ self::getDatabaseName()];
		}
		else
		{
			if ( !self::$instance )
			{
				self::connect( null, false );

				if ( !self::$instance )
				{
					return false;
				}
				if( self::getSchema() )
				{
					if( self::$banco == 'POSTGRES')
					{
						self::executeSQL('set search_path="'.self::getSchema().'"');
					}
				}
			}
			return self::$instance;
		}
	}

	//------------------------------------------------------------------------------------------
	private function __clone()
	{
	}

	//------------------------------------------------------------------------------------------
	public static function executeSql( $sql, $arrParams = null, $fetchMode = PDO::FETCH_ASSOC, $boolUtfDecode = null )
	{
		if ( !self::getInstance() )
		{
			self::getError();
			return;
		}
		self::$error = null;

		// ajuste do teste para banco oracle
		if ( $sql == 'select 1 as teste'  && strtolower(BANCO)== 'oracle' )
		{
			$sql .= ' from dual';
		}

		// converter o parametro passado para array
		if ( is_string( $arrParams ) || is_numeric( $arrParams ) )
		{
			$arrParams = array( $arrParams );
		}
		$result = null;

		// n�s chamadas ajax, n�o precisa aplicar utf8
		if ( !isset( $_REQUEST[ 'ajax' ] ) || !isset( $_REQUEST[ 'ajax' ] ) )
		{
			if ( self::getUtfDecode() )
			{
				$sql = utf8_encode( $sql );
				$arrParams = self::encodeArray( $arrParams );
			}
		}

		$arrParams = self::prepareArray( $arrParams );

		// guardar os parametros recebidos
		self::$lastParams = $arrParams;
		self::$lastSql = $sql;

		// verificar se a quantidade de parametros � igual a quantidade de variaveis
		if ( strpos( $sql, '?' ) > 0 && is_array( $arrParams ) && count( $arrParams ) > 0 )
		{
			$qtd1 = substr_count( $sql, '?' );
			$qtd2 = count( $arrParams );

			if ( $qtd1 != $qtd2 )
			{
				self::$error = 'Quantidade de parametros diferente da quantidade utilizada na instru��o sql.';
				self::showError();
				return false;
			}
		}
		else
		{
			$arrParams = array();
		}

		try
		{
			$stmt = self::getInstance()->prepare( $sql );

			if ( !$stmt )
			{
				self::$error = 'Erro no comando sql';
				self::showError();
				return false;
			}
			$result = $stmt->execute( $arrParams );

			if ( $result )
			{
				// em caso select ou insert com returning, processa o resultado
				if ( preg_match( '/^select/i', $sql ) > 0 || preg_match( '/returning/i', $sql ) > 0 || preg_match( '/^with/i', $sql ) > 0 )
				{
					$res = $stmt->fetchAll( $fetchMode );
					$res = self::processResult( $res, $fetchMode, $boolUtfDecode );

					if ( is_array( $res ) || is_object( $res ) )
					{
						return $res;
					}
					else
					{
						return null;
					}
				}
			}
			return $result;
		}
		catch( PDOException $e )
		{
			self::$error = $e->getMessage();
			self::showError();
		}
		return false;
	}

	//--------------------------------------------------------------------------
	public static function prepare( $strSql )
	{
		if ( !self::getInstance() )
		{
			return false;
		}
		return self::getInstance()->prepare( $strSql );
	}

	//---------------------------------------------------------------------------
	public function encodeArray( $arrDados = null )
	{
		$result = array();

		if ( is_array( $arrDados ) )
		{
			if ( is_string( key( $arrDados ) ) )
			{
				foreach( $arrDados as $k => $v )
				{
					if ( $v )
					{
						$arrDados[ $k ] = utf8_encode( $v );

						// inverter campo data
						if ( preg_match( '/^DAT[_,A]/i', $k ) > 0 || ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 ) )
						{
							if ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 )
							{
								$arrDados[ $k ] = self::formatDate( $v, 'ymd' );
							}
						}
						else if( preg_match( '/VAL_|NUM_/i', $k ) > 0 )
						{
							// alterar a virgula por ponto nos campos decimais
							$posPonto = ( int ) strpos( $v, '.' );
							$posVirgula = ( int ) strpos( $v, ',' );

							if ( $posVirgula > $posPonto )
							{
								if ( $posPonto && $posVirgula && $posPonto > $posVirgula )
								{
									$v = preg_replace( '/\,/', '', $v );
								}
								else
								{
									$v = preg_replace( '/,/', ' ', $v );
									$v = preg_replace( '/\./', '', $v );
									$v = preg_replace( '/ /', '.', $v );
								}
							}
							$arrDados[ $k ] = trim( $v );
						}
					}
					else
					{
						$arrDados[ $k ] = null;
					}
					$result[] = $arrDados[ $k ];
				}
			}
			else
			{
				foreach( $arrDados as $k => $v )
				{
					if ( $v )
					{
						// campo data deve ser invertido para gravar no banco de dados.
						if ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 )
						{
							$v = self::formatDate( $v, 'ymd' );
						}
						$arrDados[ $k ] = utf8_encode( $v );
					}
					else
					{
						$arrDados[ $k ] = null;
					}
				}
				$result = $arrDados;
			}
		}
		return $result;
	}

	public static function prepareArray( $arrDados = null )
	{
		$result = array();

		if ( is_array( $arrDados ) )
		{
			if ( is_string( key( $arrDados ) ) )
			{
				foreach( $arrDados as $k => $v )
				{
					if ( $v )
					{
						$arrDados[ $k ] = $v;
						// inverter campo data
						if ( preg_match( '/^DAT[_,A]/i', $k ) > 0 || ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 ) )
						{
							if ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 )
							{
								$arrDados[ $k ] = self::formatDate( $v, 'ymd' );
							}
						}
						else if( preg_match( '/NR_|VAL_|NUM_/i', $k ) > 0 )
						{
							// alterar a virgula por ponto nos campos decimais
							$posPonto = ( int ) strpos( $v, '.' );
							$posVirgula = ( int ) strpos( $v, ',' );

							if ( $posVirgula > $posPonto )
							{
								if ( $posPonto && $posVirgula && $posPonto > $posVirgula )
								{
									$v = preg_replace( '/\,/', '', $v );
								}
								else
								{
									$v = preg_replace( '/,/', ' ', $v );
									$v = preg_replace( '/\./', '', $v );
									$v = preg_replace( '/ /', '.', $v );
								}
							}
							$arrDados[ $k ] = trim( $v );
						}
					}
					else
					{
						$arrDados[ $k ] = null;
					}
					$result[] = $arrDados[ $k ];
				}
			}
			else
			{
				foreach( $arrDados as $k => $v )
				{
					if ( $v )
					{
						// campo data deve ser invertido para gravar no banco de dados.
						if ( strpos( $v, '/' ) == 2 && strpos( $v, '/', 4 ) == 5 )
						{
							$v = self::formatDate( $v, 'ymd' );
						}
						$arrDados[ $k ] = $v;
					}
					else
					{
						$arrDados[ $k ] = null;
					}
				}
				$result = $arrDados;
			}
		}
		return $result;
	}

	//------------------------------------------------------------------------------
	/**
	* Localiza a pasta base da framework
	*
	*/
	private function getRoot()
	{
		$base = '';

		for( $i = 0; $i < 10; $i++ )
		{
			$base = str_repeat( '../', $i ) . 'base/';

			if ( file_exists( $base ) )
			{
				$i = 20;
				break;
			}
		}

		if ( !file_exists( $base ) )
		{
			die ( 'pasta base/ n�o encontrada' );
		}
		$base = str_replace( 'base', '', $base );
		$base = str_replace( '//', '/', $base );
		$root = ( $base == '/' ) ? './' : $base;
		return $root;
	}

	//------------------------------------------------------------------------------------------
	public static function showExemplo( $banco, $arrErros = null )
	{
		$msgErro = '';

		if ( is_array( $arrErros ) )
		{
			$msgErro = implode( '<br>', $arrErros );
		}
		$html = '<div style="padding:5px;border:1px solid red;background-color:lightyellow;width:400px;color:blue;">';
		$html .= '<div style="border-bottom:1px solid blue;color:red;text-align:center;"><blink>' . $msgErro . '</blink></div>';

		switch( $banco )
		{
			case 'ORACLE':
				$html .= "<center>Exemplo de configura��o para conex�o com banco ORACLE</center><br>
					define('BANCO','ORACLE');<br>
					define('HOST','192.168.0.132');<br>
					define('PORT','1521');<br>
					define('SERVICE_NAME','xe');<br>
					define('USUARIO','root');<br>
					define('SENHA','root');<br><br>";

				break;

			case 'MYSQL':
				$html .= "<center>Exemplo de configura��o para conex�o com banco MYSQL</center><br>
					 define('BANCO','MYSQL');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','3306');<br>
					 define('DATABASE','exemplo');<br>
					 define('USUARIO','root');<br>
					 define('SENHA','root');<br><br>";
				break;

			case 'POSTGRES':
				$html .= "<center>Exemplo de configura��o para conex�o com banco POSTGRES</center><br>
					 define('BANCO','POSTGRES');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','5432');<br>
					 define('DATABASE','exemplo');<br>
					 define('SCHEMA','public');<br>
					 define('USUARIO','postgres');<br>
					 define('SENHA','123456');<br><br>";
				break;

			case 'SQLITE':
				$html .= "<center>Exemplo de configura��o para conex�o com banco SQLITE</center><br>
					 define('DATABASE','includes/exemplo.s3db');<br>";
				break;

			case 'FIREBIRD':
				$html .= "<center>Exemplo de configura��o para conex�o com banco FIREBIRD</center><br>
					 define('DATABASE','C://bd//DBTESTE.FDB');<br>";
				break;

			case 'SQLSERVER':
				$html .= "<center>Exemplo de configura��o para conex�o com banco SQLSERVER</center><br>
					 define('BANCO','SQLSERVER');<br>
					 define('HOST','192.168.0.132');<br>
					 define('PORT','1433');<br>
					 define('DATABASE','exemplo');<br>
					 define('USUARIO','sa');<br>
					 define('SENHA','123456');<br><br>";
				break;

			case 'ACCESS':
				$html .= "<center>Exemplo de configura��o para conex�o com banco ACCES</center><br>
					 define('DATABASE','C://bd//DBTESTE.MDB');<br>
					 define('USUARIO','admin');<br>
					 define('SENHA','123456');<br><br>";
				break;

		}
		//---------------------
		$html . '</div>';
		die ( $html );
	}

	//---------------------------------------------------
	public static function test( $boolDie = null )
	{
        $res = self::executeSql( 'select 1 as teste' );
		if ( $res )
		{
			echo '<H2>FORMDIN - Teste de conex�o com banco de dados.<br>Arquivo de Configura��o utilizado: '.self::$configFile.'<br></h2><h3>DNS:'.self::$dns.'</h3><h1>Conex�o com ' . BANCO . ' est� Ok!!!!</h1>';
		}
		else
		{
			echo '<H2>FORMDIN - Teste de conex�o com banco de dados.<br>Arquivo de Configura��o utilizado: '.self::$configFile.'<br></h2></h3>';
            echo '<br><h3>Falha na conex�o.<br/><br/>' . self::getError().'</h3>';
		}

		if ( is_null( $boolDie ) || $boolDie )
		{
			die ( '<hr>' );
		}
	}

	//----------------------------------------------------
	public static function beginTransaction()
	{
		if ( self::getInstance() )
		{
			return self::getInstance()->beginTransaction();
		}
		return false;
	}

	//---------------------------------------------------
	public static function commit()
	{
		if ( self::getInstance() )
		{
			return self::getInstance()->commit();
		}
		return false;
	}

	//---------------------------------------------------
	public static function rollBack()
	{
		if ( self::getInstance() )
		{
			return self::getInstance()->rollBack();
		}
		return false;
	}

	//---------------------------------------------------
	public static function getLastId( $strTable, $strKeyField )
	{
		$res = self::executeSql( "select max( {$strKeyField} ) as last_id from {$strTable}" );
		return $res[ 'LAST_ID' ][ 0 ];
	}

	//-----------------------------------------------------
	public static function formatDate( $date = null, $format = 'dmy' )
	{
		if ( $date )
		{
			$format = is_null( $format ) ? 'dmy' : strtolower( $format );

			if ( $format != 'dmy' && $format != 'ymd' )
			{
				$format = 'dmy';
			}
			if ( preg_match( '/\//', $date ) > 0 )
			{
				$delim = '/';
			}
			else if( preg_match( '/-/', $date ) > 0 )
			{
				$delim = '-';
			}
			$aDataHora = explode( ' ', $date );
			$aDMY = explode( $delim, $aDataHora[ 0 ] );

			// esta no formaty ymd
			if ( preg_match( '/^[0-9]{4}/', $date ) )
			{
				if ( $format == 'ymd' )
				{
					return $date;
				}
			}
			else
			{
				if ( $format == 'dmy' )
				{
					return $date;
				}
			}
			$delim = '-';
			$date = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
		}
		return $date;
	}

	//-----------------------------------------------------
	public static function dmy( $date = null )
	{
		if ( $date )
		{
			// verificar se n�o est� invertida
			if ( !preg_match( '/^[0-9]{4}/', $date ) )
			{
				// inverter campo data
				if ( preg_match( '/\//', $date ) > 0 )
				{
					$delim = '/';
				}
				else if( preg_match( '/-/', $date ) > 0 )
				{
					$delim = '-';
				}
				$aDataHora = explode( ' ', $date );
				$aDMY = explode( $delim, $aDataHora[ 0 ] );
				$date = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
			}
		}
		return $date;
	}

	//-----------------------------------------------------
	public static function processResult( $result, $fetchMode, $boolUtfDecode = null )
	{
		$boolUtfDecode = ( $boolUtfDecode === null ? self::getUtfDecode() : $boolUtfDecode );

		// formato vo
		if ( $result && $fetchMode == PDO::FETCH_OBJ )
		{
			if ( count( $result ) == 1 )
			{
				return $result[ 0 ];
			}
			return $result;
		}
		$res = null;

		if ( is_array( $result ) )
		{
			foreach( $result as $key => $val )
			{
				foreach( $val as $k => $v )
				{
					if ( $boolUtfDecode )
					{
						$k = strtoupper( utf8_decode( $k ) );
					}
					else
					{
						$k = strtoupper( $k );
					}

					// transformar tags"< >" em codigo html para n�o serem interpretadas
					if ( is_string( $v ) )
					{
						if ( $boolUtfDecode )
						{
							$res[ $k ][ $key ] = utf8_decode( $v );
						}
						else
						{
							$res[ $k ][ $key ] = $v;
						}

						//$res[ $k ][ $key ] = utf8_decode($v);
						// consertar ordem do campo data
						if ( preg_match( '/DAT/i', $k ) > 0 )
						{
							$delim = null;

							if ( preg_match( '/\//', $v ) > 0 )
							{
								$delim = '/';
							}
							else if( preg_match( '/-/', $v ) > 0 )
							{
								$delim = '-';
							}

							if ( $delim )
							{
								$aDataHora = explode( ' ', $v );
								$aDMY = explode( $delim, $aDataHora[ 0 ] );
								// verificar se est� invertida
								$delim = '/';

								if ( preg_match( '/^[0-9]{4}/', $v ) )
								{
									$res[ $k ][ $key ] = $aDMY[ 2 ] . $delim . $aDMY[ 1 ] . $delim . $aDMY[ 0 ] . ( isset( $aDataHora[ 1 ] ) ? ' ' . $aDataHora[ 1 ] : '' );
								}
							}
						}
					}
					else
					{
						$res[ $k ][ $key ] = $v;
					}
				}
			}
		}
		return $res;
	}

	public static function setUtfDecode( $boolNewValue = null )
	{
		self::$utfDecode = $boolNewValue;
	}

	public static function getUtfDecode()
	{
		return is_null( self::$utfDecode ) ? true : self::$utfDecode;
	}

	public static function pgsqlLOBOpen( $oid = null, $mode = null )
	{
		return self::getInstance()->pgsqlLOBOpen( $oid, $mode );
	}

	public static function pgsqlLOBCreate()
	{
		return self::getInstance()->pgsqlLOBCreate();
	}

	public static function setDieOnError( $boolNewValue = null )
	{
		self::$dieOnError = $boolNewValue;
	}

	public static function getDieOnError()
	{
		return is_null( self::$dieOnError ) ? true : self::$dieOnError;
	}

	public static function setShowFormErrors( $boolNewValue = null )
	{
		self::$showFormErrors = $boolNewValue;
	}

	public static function getShowFormErrors()
	{
		return is_null( self::$showFormErrors ) ? true : self::$showFormErrors;
	}

	public static function setDataBaseName( $strNewValue = null )
	{
		self::$databaseName = $strNewValue;
	}

	public static function getDataBaseName()
	{
		if ( !isset( self::$databaseName ) && !defined( 'DATABASE' ) )
		{
			return '';
		}
		return is_null( self::$databaseName ) ? DATABASE : self::$databaseName;
	}

	public static function setMessage( $strNewValue = null )
	{
		self::$message = $strNewValue;
	}

	public static function getMessage()
	{
		return self::$message;
	}
	public static function setSchema($newSchema=null)
	{
		self::$schema = $newSchema;
	}
	public static function getSchema()
	{
		return self::$schema;
	}
}
?>