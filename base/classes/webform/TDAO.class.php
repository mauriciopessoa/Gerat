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

include( 'autoload_formdin.php');
class TDAO
{
	private $dbType      = null;
	private $username    = null;
	private $password    = null;
	private $database    = null;
	private $host        = null;
	private $port        = null;
	private $schema      = null;
	private $utf8        = null;
	private $error		= null;
	private $conn		= null;
	private $tableName	= null;
	private $fields		= null;
	private $specialChars = array();
	private $charset = null;
	private $metadataDir = null;
	private $primaryKeys = null;
	private $autoincFieldName = null;
	private $lastId      = null;
	private $autoCommit  = null;
	private $hasActiveTransaction = false;
	private $sqlCmd		= null;
	private $sqlParams	= null;
	private $cursor		= null;
	private $eof		= null;

	/**
	* Classe de conex�o com banco de dados e execu��o de comandos sql
	* Permite conectar com v�rios tipos de banco de dados ao mesmo tempo
	*
	* Por padr�o utilizar� o arquivo conn_default.php ou includes/con_default.php
	* caso n�o seja informado o parametro dbType. Quando o parametro dbType for
	* informado, ser� ent�o utlizado o arquivo "conn_????.php" referente.
	* Exemplo: $dao = new TDAO(null,'postgres');
	* ser� utilizado o arquivo conn_postgres.php
	*
	* Os arquivos de configura��es devem possuir as seguintes defini��es:
	*
    * Exemplo Postgres
	* $dbType = "postgres";
	* $host = "192.168.1.140";
	* $port = "5432";
	* $database = "dbteste";
	* $username = "postgres";
	* $password = "123456";
	* $utf8=1;
	*
    * Exemplo Mysql
	* $dbType = "mysql";
	* $host = "192.168.1.140";
	* $port = "5432";
	* $database = "dbteste";
	* $username = "root";
	* $password = "123456";
	* $utf8=1;
	*
	* Exemplo Oracle
	* $dbType = 'oracle';
	* $host = '192.168.1.140';
	* $port = '1521';
	* $database = 'xe';
	* $username = 'root';
	* $password = '123456';
	* $utf8=0;
	*
	* Exemplo Firebird/Interbase
	* $dbType = "firebird";
	* $host = '192.168.1.140';
	* $port = null;
	* $database = 'f:/fiirebird/DBTESTE.GDB';
	* $username = "SYSDBA";
	* $password = "masterkey";
	* $utf8=1;
	* return;
	*
	* Exemplo Sqlite
	* $dbType = "sqlite";
	* $database = "bdApoio.s3db";
	* $utf8=0;
	*/

	/**
	* @param string $strTableName
	* @param string $strDbType
	* @param string $strUsername
	* @param string $strPassword
	* @param string $strDatabase
	* @param string $strHost
	* @param string $strPort
	* @param string $strSchema
	* @param boolean$boolUtf8
	* @param string $strCharset
	* @param boolean $boolAutoCommit
	* @param string $strMetadataDir
	* @return object TDAO
	*/
	public function __construct( $strTableName = null, $strDbType = null, $strUsername = null, $strPassword = null, $strDatabase = null, $strHost = null, $strPort = null, $strSchema = null, $boolUtf8 = null, $strCharset = null, $boolAutoCommit = null, $strMetadataDir = null  )
	{
		$this->setTableName( $strTableName );
		$this->setMetadataDir( $strMetadataDir );
		$this->setDbType( $strDbType );
		$this->setUserName( $strUsername );
		$this->setPassword( $strPassword );
		$this->setDataBase( $strDatabase );
		$this->setHost( $strHost );
		$this->setPort( $strPort );
		$this->setSchema( $strSchema );
		$this->setUtf8( $boolUtf8 );
		$this->setCharset( $strCharset );
		$this->setAutoCommit( $boolAutoCommit );
	}

	//----------------------------------------------------------------------------------
	/**
	* Define o tipo do banco de dados que ser� acessado.
	* Os tipos de banco de dados suportados atualmente s�o:
	* 1) mysql 2) postgres 3) firebird 4) sqlserver 5) oracle 6) sqlite3
	*
	* Obs: todos utilizam a extens�o PDO exceto o Oracle que utiliza as fun��es OCI diretamente
	*
	* @param string $strNewValue
	*/
	public function setDbType( $strNewValue = null )
	{
		$this->dbType=$strNewValue;
	}

	/**
	* Retorna o tipo do banco de dados que ser� acessado
	*
	* @return string;
	*/
	public function getDbType()
	{
		if( $this->conn )
		{
			//return $this->getConnDbType();
		}
		return $this->dbType;
	}

	/**
	* Define o nome do usu�rio que ser� utilizado para fazer a conex�o com o banco de dados
	*
	* @param string $strNewValue
	*/
	public function setUsername( $strNewValue = null )
	{
		$this->username=$strNewValue;
	}

   	/**
	* Retorna o nome do usu�rio definido para fazer a conex�o com o banco de dados.
	*
	* @return string $strNewValue
	*/

	public function getUsername()
	{
		return $this->username;
	}
	/**
	* Define a senha de acesso do banco de dados
	*
	* @param string $strNewValue
	*/
	public function setPassword( $strNewValue = null )
	{
		$this->password=$strNewValue;
	}

	/**
	* Retorna  a senha de acesso do banco de dados
	*
	*/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	* Define o banco de dados onde est�o as tabelas. No caso do oracle deve ser especificado
	* o TNS, no caso do oracleXE seria XE
	*
	* @param string $strNewValue
	*/
	public function setDatabase( $strNewValue = null )
	{
		$this->database=$strNewValue;
	}
    /**
    * Retorna o nome do banco de dados onde est�o as tabelas
    *
    * @return string
    */
	public function getDatabase()
	{
		return $this->database;
	}

	/**
	* Define o nome ou endere�o IP do computador onde est� instalado o banco de dados
	*
	* @param mixed $strNewValue
	*/
	public function setHost( $strNewValue = null )
	{
		$this->host=$strNewValue;
	}
    /**
    * Retorna o nome ou endere�o IP do computador onde est� instalado o banco de dados
    *
    * @return null
    */
	public function getHost()
	{
		return $this->host;
	}

	/**
	* Define a porta de comunica��o utilizada pelo banco de dados
	* Quando n�o informada ser� utilzada as portas padr�o de cada banco
	*
	* @param string $strNewValue
	*/
	public function setPort( $strNewValue = null )
	{
		$this->port=$strNewValue;
	}
    /**
    * Retorna a porta de comunica��o utilizada pelo banco de dados
    *
    */
	public function getPort()
	{
		if ( is_null( $this->port ) )
		{
			switch( strtolower( $this->getDbType() ) )
				{
				case 'postgres':
					$this->port='5432';

					break;

				case 'mysql':
					$this->port='3306';

					break;

				case 'sqlserver':
					$this->port='1433';

					break;

				case 'oracle':
					$this->port='1521';

					break;
				}
		}

		return $this->port;
	}

	/**
	* Define o nome do esquema dentro do banco de dados que dever� ser utilizado.
	* Este m�todo aplica somente ao banco de dados postgres
	* Quando informado ser� adicionado ao path do banco de dados
	*
	* @param string $strNewValue
	*/
	public function setSchema( $strNewValue = null )
	{
		$this->schema=$strNewValue;
	}

	/**
	* Retorna o nome do esquema do banco de dados que ser� utilizado. Aplica-se somente
	* ao banco de dados postgres.
	*
	* Quando informado ser� adicionado ao path do banco de dados
	*
	* @return string
	*/
	public function getSchema()
	{
		if( $this->conn )
		{
			return $this->getConnSchema();
		}
		return $this->schema;
	}

	/**
	* Define se o banco de dados est� utilizando codifica��o UTF-8
	*
	* @param boolean $boolNewValue
	*/
	public function setUtf8( $boolNewValue = null )
	{
		$this->utf8=$boolNewValue;
	}
    /**
    * Retorna true ou false se o banco de dados est� utilizando codifica��o UTF-8
    *
    */
	public function getUtf8()
	{
		if( $this->conn )
		{
			return $this->getConnUtf8();
		}
		return ( ( $this->utf8 === false ) ? false : true );
	}

	/**
	* Tenta fazer a conex�o com o banco de dados retornando verdadeiro o falso
	*
	* @return boolean
	*/
	public function connect()
	{
		try
		{
			//$this->conn = TConnection::connect( $this->getDbType(), $this->getUsername(), $this->getPassword(), $this->getDatabase(), $this->getHost(), $this->getPort(), $this->getSchema(), $this->getUtf8() );
			if( ! $this->conn )
			{
				$this->conn = TConnectionPool::connect( $this->getDbType(), $this->getUsername(), $this->getPassword(), $this->getDatabase(), $this->getHost(), $this->getPort(), $this->getSchema(), $this->getUtf8() );
			}
		}
		catch( Exception $e )
		{
			$this->setError( $e->getMessage() );
			return false;
		}

        if( $this->getMetadataDir())
        {
			if ( !is_array( $this->getFields() ) )
			{
				if ( !$this->unserializeFields() )
				{
					$this->loadFieldsFromDatabase();
				}
			}
			if( is_array($this->primaryKeys ) )
			{
				foreach($this->primaryKeys as $fieldName=>$boolTemp)
				{
					$this->getField($fieldName)->primaryKey = 1;
				}
			}
		}

		return true;
	}

	/**
	* Executa o comando sql recebido retornando o cursor ou verdadeiro o falso se a opera��o
	* foi bem sucedida.
	*
	* @param string $sql
	* @param mixed $params
	* @param string $fetchMode
	*/
	public function query( $sql = null, $params = null, $fetchMode = null )
	{
		$data=false;
		$hasUserTransaction = $this->getHasActiveTransaction();
		if ( !$this->getConn() )
		{
			return false;
		}
		try
		{
			if ( !is_null($params) && !is_array( $params ) )
			{
				$params = array($params);
			}
			$sql=trim( $sql );              // remover espa�os do in�cio e final
			$sql=$this->utf8Decode( $sql ); // remover codifica��o utf8

			if ( $this->getConnUtf8() )
			{
				$sql = $this->utf8Encode( $sql ); // aplicar codifica��o utf8
			}
			$params=$this->prepareParams( $params ); // aplicar/remover utf8 nos par�metros
		}
		catch( Exception $e )
		{
			$this->setError( $e->getMessage() );
			return false;
		}

		if ( $this->isPdo() )
		{
			if ( is_null( $fetchMode ) || ( $fetchMode != PDO::FETCH_ASSOC && $fetchMode != PDO::FETCH_CLASS ) )
			{
				$fetchMode = PDO::FETCH_ASSOC;
			}

			try
			{
				// trocar os "?" por ":p" para fazer o bind_by_name
				if( is_array($params) && preg_match('/\?/',$sql)==1 )
				{
					$keys = array_keys($params);
					foreach($keys as $v)
					{
						$sql = preg_replace('/\?/',':'.$v,$sql,1);
					}
				}
				$this->sqlCmd 		= $sql;
				$this->sqlParams 	= $params;

				$stmt=$this->getConn()->prepare( $sql );
				if ( !$stmt )
				{
					throw new Exception( 'Error preparing Sql.' );
				}

                if( preg_match( '/^select/i', $sql ) == 0 )
                {
					$this->beginTransaction();
				}
				// fazer BINDS
				if( is_array($params) )
				{
					// formato de bindParam
					/*
					$paramIndex=1;
					forEach( $params  as $fieldName=>$fieldValue )
					{
						echo $fieldName.': ';
						$objField = $this->getField($fieldName);
						if( $objField )
						{
							$fieldType = $this->getValidFieldType($objField->fieldType);
							echo $fieldName.' = '.$fieldType.' Valor: '.$params[$fieldName].'<br>';
							switch( $fieldType )
							{
									case 'binary':
										$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_LOB);
									break;
									//------------------------------------------------------------
									case 'number':
										$stmt->bindParam($paramIndex, $params[$fieldName]);
									break;
									//------------------------------------------------------------
									default;
									$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_STR);
        					}
						}
						else
						{
							$stmt->bindParam($paramIndex, $params[$fieldName], PDO::PARAM_STR);
						}
						$paramIndex++;
					}
					*/
			        // formato bindValues
					foreach( $params  as $fieldName=>$fieldValue )
					{
						$objField = $this->getField($fieldName);
						if( $objField )
						{
							$fieldType = $this->getValidFieldType($objField->fieldType);
							switch( $fieldType )
							{
									case 'binary':
										// ler o conteudo do arquivo se para o camp blob for informado o nome do arquivo
										if( @file_exists($params[$fieldName] ) )
										{
											$params[$fieldName] = file_get_contents($params[$fieldName]);
										}
										$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_LOB);
									break;
									//------------------------------------------------------------
									case 'number':
										$stmt->bindValue(':'.$fieldName, $params[$fieldName]);
									break;
									//------------------------------------------------------------
									default;
									$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_STR);
        					}
						}
						else
						{
							if( is_integer($params[$fieldName] ))
							{
									$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_INT);
							}
							else if( is_numeric($params[$fieldName] ) )
							{
								$stmt->bindValue(':'.$fieldName, $params[$fieldName]);
							}
							else
							{
								$stmt->bindValue(':'.$fieldName, $params[$fieldName], PDO::PARAM_STR);
							}
						}
					}
					$params=null;
				}
				$result=$stmt->execute( $params );
				if ( !$result )
				{
					throw new Exception( 'Error executing Sql!' );
				}
			}
			catch( Exception $e )
			{
				$this->setError( $e->getMessage() );
				return false;
			//throw $e;
			}
			if( $this->getAutoCommit() && ! $hasUserTransaction )
			{
				$this->commit();
			}
			$data=true;
			try
			{
				if ( preg_match( '/^select/i', $sql ) > 0 || preg_match( '/returning /i', $sql ) > 0 || preg_match( '/^with /i', $sql ) > 0 )
				{
					$data = $stmt->fetchAll( $fetchMode );
				}
			}
			catch( Exception $e )
			{
				$data=false;
				$this->setError( $e->getMessage() );
			}

			$stmt->closeCursor();
		}
		else
		{
			$conn=$this->getConn()->connection;

			if ( $this->getDbType() == 'oracle' )
			{
				if ( is_null( $fetchMode ) || ( $fetchMode != 'FETCH_ASSOC' && $fetchMode != 'FETCH_CLASS' ) )
				{
					$fetchMode = 'FETCH_ASSOC'; //OCI_FETCHSTATEMENT_BY_ROW;
				}

				try
				{
                    // trocar os "?" por ":p" para fazer o bind_by_name
					if( is_array($params) && preg_match('/\?/',$sql)==1 )
					{
						$keys = array_keys($params);
						foreach($keys as $v)
						{
							$sql = preg_replace('/\?/',':'.$v,$sql,1);
						}
					}
					$stmt = oci_parse( $conn, $sql );
					$descriptors=null;

					if ( is_array( $params ) )
					{
						foreach( $params as $fieldName => $fieldValue )
						{
							$objField = $this->getField( $fieldName );
							if ( $objField )
							{
								$bindType=$this->getBindType( $objField->fieldType );
								oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
							}
							else
							{
								oci_bind_by_name( $stmt, ':' . $fieldName, $params[$fieldName] );
							}
						}
					}

					if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) ) // OCI_DEFAULT = n�o commit
					{
						$e=oci_error( $stmt );

						throw new Exception( 'Sql error ' . $e[ 'message' ] );
					}

					if ( preg_match( '/^select/i', $sql ) > 0 )
					{
						if ( $fetchMode == 'FETCH_ASSOC' )
						{
							oci_fetch_all( $stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_RETURN_NULLS );
						}
						else if( $fetchMode == 'FETCH_CLASS' )
						{
							$data=array();

							while( $row = oci_fetch_object( $stmt ) )
							{
								array_push( $data, $row );
							}
						}
					}
				}
				catch( Exception $e )
				{
					$data=false;
					$this->setError( $e->getMessage() );
				}

				oci_free_statement( $stmt );
			//oci_close($conn);
			}
		}

		if ( $data && is_array( $data ) )
		{
			$data = $this->parseFetchResult( $data );
		}

		return $data;
	}

	/**
	* Retorna a inst�ncia do objeto da conex�o com o banco de dados
	*
	* @return object
	*/
	public function getConn()
	{
		if ( is_null( $this->conn ) )
		{
			if ( !$this->connect() )
			{
				return false;
			}
		}

		return $this->conn;
	}

	/**
	* Adiciona campos da tabela ao array de campos que ser�o utilizados
	* nos binds e nos m�todos save, insert e delete da classe
	*
	* @param string $strFieldName
	* @param string $strFieldType
	* @param integer $intSize
	* @param integer $intPrecision
	* @param string $strDefaultValue
	* @param boolean $boolNullable
	* @param boolean $boolAutoincrement
	* @param boolean $boolPrimaryKey
	*/
	public function addField( $strFieldName, $strFieldType = null, $intSize = null, $intPrecision = null, $strDefaultValue = null, $boolNullable = null, $boolAutoincrement = null, $boolPrimaryKey = null )
	{
		$strFieldType 		=( is_null( $strFieldType ) ? 'varchar':$strFieldType);
		$boolAutoincrement	=( is_null( $boolAutoincrement ) ? 0 : $boolAutoincrement );
		$boolNullable       =( is_null( $boolNullable ) ? 1 : $boolNullable );
		$boolPrimaryKey     =( is_null( $boolPrimaryKey ) ? 0 : $boolPrimaryKey );
		$this->fields[ strtoupper( $strFieldName )]=(object)array
			(
			'fieldName'     => $strFieldName,
			'fieldType'     => $strFieldType,
			'size'          => $intSize,
			'precision'     => $intPrecision,
			'defaultValue'  => $strDefaultValue,
			'nullable'      => $boolNullable,
			'autoincrement' => $boolAutoincrement,
			'primaryKey'    => $boolPrimaryKey,
			'value'			=> null
			);
	}

	/**
	* Retorna o objeto do campo solictado
	* Se o campo n�o existier retorna null
	*
	* @param string $strFieldName
	*/
	public function getField( $strFieldName )
	{
		$strFieldName=strtoupper( $strFieldName );

		if ( isset( $this->fields[ $strFieldName ] ) )
		{
			return $this->fields[ $strFieldName ];
		}

		return null;
	}

	/**
	* Retorna o array de objetos dos campos da tabela
	*
	*/
	public function getFields()
	{
		return $this->fields;
	}
	/**
	* Defina a mensagem de erro
	*
	* @param string $strError
	*/
	public function setError( $strError = null )
	{
		$this->error=$strError;
	}
	/**
	* Retorna a mensagem de erro atual
	*
	*/
	public function getError()
	{
		return $this->error;
	}

	/**
	* Retorna a string dsn utilizada na conex�o PDO
	*
	* @return string
	*/
	public function getConnDsn()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->dsn;
		}

		return null;
	}

	/**
	* Retorna se o banco de dados est� utilizando a codifica��o UTF-8
	*
	*/
	public function getConnUtf8()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->utf8;
		}

		return true;
	}
	/**
	* Retorna o tipo de banco de dados que est� sendo utilizado.
	* Ex: mysql, postgres, oracle...
	*
	* @return string
	*/
	public function getConnDbType()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->dbType;
		}

		return null;
	}

	/**
	* Retorna o nome do esquema utilizado pela conex�o postgres somente
	* @return string
	*/
	public function getConnSchema()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->schema;
		}

		return null;
	}

	/**
	* Retorna os caracteres considerados especias
	*
	* @return array
	*/
	public function getSpecialChars()
	{
		if ( count( $this->specialChars ) == 0 )
		{
			$this->specialChars=array
				(
				'�',
				'�'
				);

			for( $i = 127; $i < 256; $i++ )
			{
				$char = chr( $i );

				if ( !preg_match( '/�|�/', $char ) )
				{
					$this->specialChars[] = $char;
				}
			}
		}

		return $this->specialChars;
	}

	/**
	* Transforma os caracteres epeciais em seus carateres utf8 relacionados
	*
	* @param string $str
	*/
	public function utf8Encode( $str = null )
	{
		if ( is_null( $str ) || $str == '' )
		{
			return $str;
		}

		$result='';
		$this->utf8Decode( $str );

		for( $i = 0; $i < strlen( $str ); $i++ )
		{
			$result .= utf8_encode( substr( $str, $i, 1 ) );
		}

		return $result;
	}

	/**
	* Transforma o caracteres codificados em utf-8 no caractere especial relacionado
	*
	* @param string $str
	*/
	public function utf8Decode( $str = null )
	{
		foreach( $this->getSpecialChars()as $char )
		{
			$str = preg_replace( '/' . utf8_encode( $char ) . '/', $char, $str );
		}

		return $str;
	}

	/**
	* Processa o array de parametros aplicando/removendo codifica��o utf8, convertendo
	* datae n�meros no formado correto de acordo com o banco de dados.
	*
	* Se $boolBind for true ( padr�o) o retorno ser� o array associativo (key=>value ) quando
	* este for recebido neste formato,  se false o resultdo ser� convertido em um array indexado de 0 a N
	*
	* @param mixed $mixParams
	* @param boolean $boolBind
	*/
	public function prepareParams( $mixParams = null, $boolBind = true )
	{
		if ( is_numeric( $mixParams ) )
		{
			return $this->parseNumber( $mixParams );
		}
		else if( is_string( $mixParams ) )
		{
			if ( $this->getConnUtf8() )
			{
				$mixParams=trim( $mixParams );
				$mixParams=$this->utf8Decode( $mixParams ); // remover utf8
				return $this->utf8Encode( $mixParams );
			}

			return $this->utf8Decode( $mixParams );
		}
		else if( is_array( $mixParams ) )
		{
			$result=array();

			foreach( $mixParams as $k => $item )
			{
				if ( is_numeric( $item ) )
				{
					if ( !$boolBind )
					{
						array_push( $result, $this->prepareParams( $item, $boolBind ) );
					}
					else
					{
						$result[ $k ] = $this->prepareParams( $item, $boolBind );
					}
				}
				else
				{
					$objField=$this->getField( $k );
					$fieldType=null;
					if ( ! is_null( $objField ) )
					{
						$fieldType=$this->getValidFieldType( $objField->fieldType );
						if ( $fieldType == 'date' )
						{
							if ( $this->getDbType() == 'oracle' )
							{
								$item = $this->parseDMY( $item );
							}
							else
							{
								$item = $this->parseYMD( $item );
							}
						}
						elseif( $fieldType == 'number' )
						{
							$item = $this->parseNumber( $item );
						}
					}

					if ( ! $boolBind )
					{
						if ( $fieldType != 'binary' )
						{
							$item = $this->prepareParams( $item, $boolBind );
						}
						array_push( $result, $item );
					}
					else
					{
						if ( $fieldType != 'binary' )
						{
							$item = $this->prepareParams( $item, $boolBind );
						}
						$result[ $k ]=$item;
					}
				}
			}
			return $result;
		}
		return $mixParams;
	}
    /**
    * Retorna a data invertida no formato Ano, M�s e Dia.
    *
    * @param string $date
    */
	public function parseYMD( $strDate = null )
	{
		if ( is_null( $strDate ) )
		{
			return $strDate;
		}

		$strDate =preg_replace( '/\//', '-', $strDate ); // trocar barra para hifem
		$aTemp=explode( ' ', $strDate );              // separar horas
		$strDate =$aTemp[ 0 ];
		$time =( isset( $aTemp[ 1 ] ) ? $aTemp[ 1 ] : null );
		$aTemp=explode( '-', $strDate );

		if ( !preg_match( '/^[0-9]{4}/', $strDate ) )
		{
			$strDate = $aTemp[ 2 ] . '-' . $aTemp[ 1 ] . '-' . $aTemp[ 0 ];
		}

		return $strDate . ( is_null( $time ) ? '' : ' ' . $time );
	}
    /**
    * Retorna a data no formato normal de Dia, M�s e Ano
    *
    * @param string $date
    */
	public function parseDMY( $strDate = null )
	{
		if ( is_null( $strDate ) )
		{
			return $strDate;
		}

		$strDate =preg_replace( '/\//', '-', $strDate ); // trocar barra para hifem
		$aTemp=explode( ' ', $strDate );              // separar horas
		$strDate =$aTemp[ 0 ];
		$time =( isset( $aTemp[ 1 ] ) ? $aTemp[ 1 ] : null );
		$aTemp=explode( '-', $strDate );

		if ( preg_match( '/^[0-9]{4}/', $strDate ) )
		{
			$strDate = $aTemp[ 2 ] . '-' . $aTemp[ 1 ] . '-' . $aTemp[ 0 ];
		}

		return $strDate . ( is_null( $time ) ? '' : ' ' . $time );
	}

	/**
	* Corrige o valor formatdo para numero decimal v�lido, colocando o ponto no lugar
	* da virgula
	*
	* @param string $value
	*/
	public function parseNumber( $strValue = null)
	{
		if ( preg_match( '/\,/', $strValue ) == 1 )
		{
			$posComma=strpos( $strValue, ',' );
			$qtdComma=substr_count( $strValue, ',' );
			$posPoint=strpos( $strValue, '.' );

			if ( $posPoint === false && $qtdComma > 1 )
			{
				$strValue = preg_replace( '/\,/', '', $strValue );
			}
			else if( $posPoint == 0 && $posComma > 0 )
			{
				$strValue = preg_replace( '/\,/', '.', $strValue );
			}
			else if( $posComma > $posPoint )
			{
				$strValue=preg_replace( '/\./', '', $strValue );
				$strValue=preg_replace( '/\,/', '.', $strValue );
			}
			else if( $posComma < $posPoint )
			{
				$strValue = preg_replace( '/\,/', '', $strValue );
			}
		}

		if ( $this->getDbType() == 'oracle' )
		{
			$strValue = preg_replace( '/\./', ',', $strValue );
		}

		return $strValue;
	}

	/**
	* Processa o resultado da consulta sql aplivando/removendo utf-8, ajustando n�meros e datas
	* de acordo com o tipo da coluna
	*
	* @param mixed $data
	*/
	public function parseFetchResult( $data = null )
	{
		//return $data;
		if ( is_null( $data ) )
		{
			return $data;
		}

		if ( !is_array( $data ) )
		{
			return $data;
		}

		if ( isset( $data[ 0 ] ) )
		{
			if ( is_object( $data[ 0 ] ) )
			{
				if ( $this->getFields() )
				{
					foreach( $data as $k => $obj )
					{
						foreach( $this->getFields()as $fieldName => $objField )
						{
							$f         = $objField->fieldName;
							$fieldValue=null;

							if ( !isset( $obj->$f ) )
							{
								$f=strtolower( $f );

								if ( !isset( $obj->$f ) )
								{
									$f = null;
								}
							}

							if ( !is_null( $f ) )
							{
								$fieldType=$this->getValidFieldType( $objField->fieldType );

								if ( $fieldType == 'date' )
								{
									$fieldValue = $this->parseDMY( $obj->$f );
								}
								else if( $fieldType == 'text' )
								{
									$fieldValue = $this->parseString( $obj->$f );
								}

								if ( !is_null( $fieldValue ) )
								{
									$obj->$f = $fieldValue;
								}
							}
						}
					}
				}
			}
			else if( is_array( $data[ 0 ] ) )
			{
				foreach( $data as $k => $arr )
				{
					foreach( $arr as $fieldName => $value )
					{
						if ( $this->getField( $fieldName ) )
						{
							$objField =$this->getField( $fieldName );
							$fieldType=$this->getValidFieldType( $objField->fieldType );
							if ( $fieldType == 'date' )
							{
								$data[ $k ][ $fieldName ] = $this->parseDMY( $value );
							}
							else if( $fieldType == 'string' )
							{
								$data[ $k ][ $fieldName ] = $this->parseString( $value );
							}
						}
						else
						{
							$data[ $k ][ $fieldName ] = $this->parseString( $value );
						}
					}
				}
			}
		}
		return $data;
	}
	/**
	* Define o tipo de codifica��o que est� sendo utilizada no browser. Padr�o � utf-8
	* Pode ser definido de maneira global utilizando a constante CHARSET
	* Exemplo: setCharset('utf-8'); ou setCharset('iso-8859');
	*
	* @example setCharset('utf-8'),setCharset('iso-8859');
	* @param string $strNewValue
	*/
	public function setCharset( $strNewValue = null )
	{
		$this->charset=$strNewValue;
	}
    /**
    * REtorna o tipo de codifica��o que est� sendo utilizada no browser
    *
    * @return string
    */
	public function getCharset()
	{
		if ( is_null( $this->charset ) )
		{
			if ( defined( 'CHARSET' ) )
			{
				$this->charset = CHARSET;
			}
			else
			{
				$this->charset = 'iso-8859';
			}
		}

		if ( strtolower( $this->charset ) == 'utf8' )
		{
			$this->charset = 'utf-8';
		}

		if ( defined( 'CHARSET' ) )
		{
			define('CHARSET',$this->charset);
		}
		return strtolower( $this->charset );
	}

	/**
	* Retorna true/false se string estiver na codifica��o UTF-8
	*
	* @param string $strValue
	* @return boolean
	*/
	public function detectUTF8( $strValue = null )
	{
		if ( is_numeric( $strValue ) || !is_string( $strValue ) )
		{
			return false;
		}

		$result=false;

		foreach( $this->getSpecialChars()as $k => $v )
		{
			if ( preg_match( '/' . utf8_encode( $v ) . '/', $strValue ) )
			{
				$result=true;
				break;
			}
		}

		return $result;
	}
	/**
	* M�todo para verificar se existe algum caractere especial na string
	*
	* @param mixed $strValue
	* @return boolean
	*/
	public function detectSpecialChar( $strValue = null )
	{
		if ( is_numeric( $strValue ) || !is_string( $strValue ) )
		{
			return false;
		}

		// se tiver na codifica��o utf-8 retornar false
		if ( $this->detectUTF8( $strValue ) )
		{
			return false;
		}

		$result=false;

		foreach( $this->getSpecialChars()as $k => $v )
		{
			if ( preg_match( '/' . $v . '/', $strValue ) )
			{
				$result=true;
				break;
			}
		}

		return $result;
	}

	/**
	* M�todo para converter a string para utf-8 ou ascii dependendo
	* das configura��es do banco de dados e do charset definido
	*
	* @param string $strValue
	*/
	public function parseString( $strValue = null )
	{
		if ( !is_string( $strValue ) || is_numeric( $strValue ) )
		{
			return $strValue;
		}

		if ( $this->getCharset() == 'utf-8' )
		{
			if ( $this->detectSpecialChar( $strValue ) )
			{
				$strValue = $this->utf8Encode( $strValue );
			}
		}
		else
		{
			if ( $this->detectUTF8( $strValue ) )
			{
				$strValue = $this->utf8Decode( $strValue );
			}
		}

		return $strValue;
	}

	/**
	* Define o nome da tabela do banco de dados que ser� utizizada nos
	* comando insert, save, delete ...
	*
	* @param string $strNewValue
	*/
	public function setTableName( $strNewValue = null )
	{
		$this->tableName=$strNewValue;
	}
    /**
    * Retorna o nome da tabela que est� sendo utilizada nos comandos
    * insert, delete, save ...
    *
    */
	public function getTableName()
	{
		return $this->tableName;
	}

	/**
	* Converte o tipo de campo da coluna da tabela para um tipo de campo padr�o da classe
	*
	* @param string $strFieldType
	* @return string
	*/
	public function getValidFieldType( $strFieldType = null )
	{
		list( $strFieldValue )=explode( ' ', $strFieldType );

		if ( is_null( $strFieldType ) )
		{
			return null;
		}

		if ( preg_match( '/long|clob|char|varchar|varchar2|text|charactervarying/i', $strFieldType ) )
		{
			return 'string';
		}

		if ( preg_match( '/decimal|real|float|numeric|number|int|int64|integer|double|smallint|bigint/i', $strFieldType ) )
		{
			return 'number';
		}

		if ( preg_match( '/date|datetime|timestamp/i', $strFieldType ) )
		{
			return 'date';
		}

		if ( preg_match( '/blob|bytea/i', $strFieldType ) )
		{
			return 'binary';
		}

		return $strFieldType;
	}

	/**
	* Retorna o diret�rio/pasta onde ser� armazenada as informa��es dos campos
	* extra�dos das tabela
	*
	* @param string $strNewValue
	*/
	public function setMetadataDir( $strNewValue = null )
	{
		$this->metadataDir=trim( $strNewValue ) . '/';
		$this->metadataDir=preg_replace( '/\/\//', '', $this->metadataDir ) . '/';

		if ( !is_null( $strNewValue ) && !file_exists( $strNewValue ) )
		{
			$oldumask=umask( 0 );
			@mkdir( $strNewValue, 0755, true );
			umask( $oldumask );
		}
	}
    /**
    * Retorna o nome do diret�rio/pasta onde ser�o armazendas as informa��es dos campos
    * das tabelas
    *
    * @return string;
    */
	public function getMetadataDir()
	{
		if ( !is_null( $this->metadataDir ) && file_exists( $this->metadataDir ) )
		{
			return preg_replace( '/\/\//', '/', $this->metadataDir . '/' );
		}

		return null;
	}

	/**
	* Serialize e salva os campos no diret�rio/pasta de metadados
	*
	* @return null
	*/
	public function serializeFields()
	{
		if ( $this->getMetadataDir() && $this->getTableName() )
		{
			file_put_contents( $this->getMetadataDir() . $this->getConnDbType() . '-' . $this->getTableName() . '.ser', serialize( $this->getFields() ) );
		}
	}
    /**
    * Desserializa as defini��es dos campos de uma tabela que foram salvos no diret�rio/pasta
    * de metadados e carrega o array fields da classe
    *
    * @return boolean
    */
	public function unserializeFields()
	{
		$result=false;

		if ( $this->getMetadataDir() && $this->getTableName() )
		{
			$fileName=$this->getMetadataDir() . $this->getConnDbType() . '-' . $this->getTableName() . '.ser';

			if ( file_exists( $fileName ) )
			{
				$this->fields=unserialize( file_get_contents( $fileName ) );

				if ( is_array( $this->fields ) )
				{
					$result = true;
				}
			}
		}

		return $result;
	}

	/**
	* Recupera as informa��es dos campos da tabela defida na classe diretamente do banco de dados
	* @return null
	*/
	public function loadFieldsFromDatabase()
	{
		if ( !$this->getTableName() )
		{
			return null;
		}
		$sql   =null;
		$params=null;

		// ler os campos do banco de dados
		if ( $this->getConnDbType() == 'mysql' )
		{
			// http://dev.mysql.com/doc/refman/5.0/en/tables-table.html
			$sql="select column_name COLUMN_NAME
				, COLUMN_DEFAULT
				, case when lower(EXTRA) = 'auto_increment' then 1 else 0 end  AUTOINCREMENT
				, case when upper(IS_NULLABLE) = 'NO' then 0 else 1 end NULLABLE
				, data_type DATA_TYPE
				, character_maximum_length DATA_LENGTH
				, numeric_precision DATA_PRECISION
				, numeric_scale DATA_SCALE
				from information_schema.columns
				where upper(table_name) = upper(?)
				order by ordinal_position";

			$params=array($this->getTableName());
		}
		else if( $this->getConnDbType() == 'oracle' )
		{
			$sql="select a.column_name COLUMN_NAME
					, a.data_type DATA_TYPE
					, data_default as COLUMN_DEFAULT
					, 0 AUTOINCREMENT
					, decode(nullable,'Y',1,0) as NULLABLE
					, a.data_length DATA_LENGTH
					, a.data_precision DATA_PRECISION
					, a.data_scale DATA_SCALE
    				from all_tab_columns a
    				where upper(a.table_name) = upper(:0)";

			$params=array($this->getTableName());
		}
		else if( $this->getConnDbType() == 'postgres' )
		{
			$schema=( is_null( $this->getConnSchema() ) ? 'public' : $this->getConnSchema());
			$sql   ="SELECT column_name \"COLUMN_NAME\"
					,column_default \"COLUMN_DEFAULT\"
					,position('nextval(' in column_default)=1 as \"AUTOINCREMENT\"
					,is_nullable  \"NULLABLE\"
					,data_type \"DATA_TYPE\"
					,character_maximum_length \"DATA_LENGTH\"
					,coalesce(numeric_precision, datetime_precision) as \"DATA_PRECISION\"
					,numeric_scale as \"DATA_SCALE\"
					FROM information_schema.columns
					WHERE upper(table_schema) =  upper(?)
					AND upper(table_name) =upper(?)
					ORDER BY ordinal_position";

			$params=array
				(
				$schema,
				$this->getTableName()
				);
		}
		else if( $this->getConnDbType() == 'firebird' )
		{
			$sql='SELECT
					RDB$RELATION_FIELDS.RDB$FIELD_NAME COLUMN_NAME,
					\'\' as COLUMN_DEFAULT,
					0 AUTOINCREMENT,
					0 NULLABLE,
					RDB$TYPES.RDB$TYPE_NAME DATA_TYPE,
					RDB$FIELDS.RDB$CHARACTER_LENGTH DATA_LENGTH,
					RDB$FIELDS.RDB$FIELD_PRECISION DATA_PRECISION,
					RDB$FIELDS.RDB$FIELD_SCALE DATA_SCALE
					FROM RDB$RELATIONS
					INNER JOIN RDB$RELATION_FIELDS ON RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME
					LEFT JOIN RDB$FIELDS ON RDB$RELATION_FIELDS.RDB$FIELD_SOURCE = RDB$FIELDS.RDB$FIELD_NAME
					LEFT JOIN RDB$TYPES ON RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE
					LEFT JOIN RDB$FIELD_DIMENSIONS  on RDB$FIELD_DIMENSIONS.RDB$FIELD_NAME = RDB$FIELDS.RDB$FIELD_NAME
					WHERE UPPER(RDB$RELATIONS.RDB$RELATION_NAME) = upper(?)
					AND RDB$RELATIONS.RDB$SYSTEM_FLAG = 0
					AND RDB$TYPES.RDB$FIELD_NAME=\'RDB$FIELD_TYPE\'
					ORDER BY RDB$RELATION_FIELDS.RDB$FIELD_POSITION';

			$params=array($this->getTableName());
		}
		else if( $this->getConnDbType() == 'sqlite')
		{
			$stmt = $this->getConn()->query( "PRAGMA table_info(".$this->getTableName().")");
			$res =  $stmt->fetchAll();
			$data = null;
			$sql = null;
			foreach($res as $rownum => $row)
			{
				$data[$rownum]['COLUMN_NAME'] 	= $row['NAME'];
				$data[$rownum]['COLUMN_DEFAULT']= $row['DFLT_VALUE'];
				$data[$rownum]['AUTOINCREMENT'] = $row['PK'];
				$data[$rownum]['NULLABLE'] 		= ( $row['NOTNULL'] == 0 ? 1 : 0 );
  				$data[$rownum]['DATA_TYPE'] 	= $row['TYPE'];
				$data[$rownum]['DATA_LENGTH'] 	= null;
				$data[$rownum]['DATA_PRECISION']= 0;
				$data[$rownum]['DATA_SCALE']	= 0;
				$data[$rownum]['PRIMARYKEY']	= $row['PK'];
			    if( preg_match('/\(/',$row['TYPE']) == 1 )
			    {
    				$aTemp = explode('(',$row['TYPE']);
    				$data[$rownum]['DATA_TYPE'] = $aTemp[0];
					$type= substr($row['TYPE'],strpos($row['TYPE'],'('));
					$type = preg_replace('/(\(|\))/','',$type);
					@list($length,$precision) = explode(',',$type);
					if( preg_match('/varchar/i',$aTemp[0]==1) )
					{
		   				$data[$rownum]['DATA_LENGTH'] = $length;
					}
					else
					{
	   					$data[$rownum]['DATA_LENGTH'] 		= 0;
						$data[$rownum]['DATA_PRECISION'] 	= $length;
						$data[$rownum]['DATA_SCALE'] 		= $precision;
					}
			    }
			}
		}
		if ( !is_null( $sql ) )
		{
			$data =  $this->query( $sql, $params );
		}
		if ( is_array( $data ) )
		{
			foreach( $data as $k => $row )
			{
				$this->addField( trim( $row[ 'COLUMN_NAME' ] )
				, trim( strtolower($row[ 'DATA_TYPE' ]) )
				, ( (int) $row[ 'DATA_PRECISION' ] > 0 ? $row[ 'DATA_PRECISION' ] : $row[ 'DATA_LENGTH' ] )
				, $row[ 'DATA_SCALE' ]
				, $row[ 'COLUMN_DEFAULT' ]
				, $row[ 'NULLABLE' ]
				, $row[ 'AUTOINCREMENT' ]
				, $row[ 'PRIMARYKEY']);
			}
			if ( is_array( $this->getfields() ) )
			{
				$this->serializeFields();
			}
		}
	}

	/**
	* Define o nome do campo autoincremento da tabela
	*
	* @param string $strNewValue
	*/
	public function setAutoincFieldName( $strNewValue = null )
	{
		$this->autoincFieldName=$strNewValue;
	}
    /**
    * Retorna o nome do campo autoincremento da tabela
    *
    */
	public function getAutoincFieldName()
	{
		if ( is_null( $this->autoincFieldName ) )
		{
			if ( $this->getFields() )
			{
				foreach( $this->getFields()as $fieldName => $objField )
				{
					if ( $objField->autoincrement == 1 )
					{
						$this->setAutoincFieldName( $objField->fieldName );
						break;
					}
				}
			}
		}

		return trim( $this->autoincFieldName );
	}

	/**
	* Retorna o valor da propriedade lastId
	*
	* @return integer
	*/
	public function getLastId()
	{
		return $this->lastId;
	}
    /**
    * Recupera do banco de dados o valor campo autoincremento referente ao �ltimo insert ocorrido
    *
    */
	public function getLastInsertId()
	{
		$sql   =null;
		$params=null;
		$dbType = $this->getConnDbType();
		if ( $dbType == 'mysql' )
		{
			$sql = 'SELECT LAST_INSERT_ID() as ID';
		}
		else if( $dbType == 'postgres' )
		{
			if ( $this->getAutoincFieldName() )
			{
				$sql="SELECT currval(pg_get_serial_sequence(?,?) ) as ID";

				$params=array
					(
					$this->getTableName(),
					$this->getAutoincFieldName()
					);
			}
		}
		else if( $dbType == 'oracle' )
		{
			if ( $this->getAutoincFieldName() )
			{
				return $this->lastId;
			}
		}
		else if( $dbType == 'sqlite' )
		{
			if ( $this->getAutoincFieldName() )
			{
				$sql = "select last_insert_rowid() as ID";
				$params=null;
			}
		}
		if ( $sql )
		{
			$res = self::query($sql,$params);
			if ( isset( $res[ 0 ][ 'ID' ] ) )
			{
				return $res[ 0 ][ 'ID' ];
			}
			else if( isset( $res[ 0 ][ 'id' ] ) )
			{
				return $res[ 0 ][ 'id' ];
			}
		}

		return null;
	}
    /**
    * Retorna se a conex�o est� utilizando a extens�o PDO para conex�o com o
    * banco de dados
    * Obs: para o banco de dados oracle ser�o utilizadas as fun��es oci do php
    *
    */
	public function isPDO()
	{
		if ( $this->getConn() )
		{
			return $this->getConn()->isPDO;
		}
		return null;
	}
    /**
    * Recebe o tipo de dados da coluna e retorna o tipo bind relacionado
    *
    * @param mixed $strFieldType
    */
	public function getBindType( $strFieldType = null )
	{
		$bindTypes[ 'oracle' ][ 'char' ]        =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'varchar' ]     =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'varchar2' ]    =SQLT_CHR;
		$bindTypes[ 'oracle' ][ 'integer' ]     =SQLT_INT;
		$bindTypes[ 'oracle' ][ 'number' ]      =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'blob' ]        =SQLT_BLOB;
		$bindTypes[ 'oracle' ][ 'clob' ]        =SQLT_CLOB;
		$bindTypes[ 'oracle' ][ 'long' ]        =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'long raw' ]    =SQLT_LBI;
		$bindTypes[ 'oracle' ][ 'date' ]        =SQLT_LNG;
		$bindTypes[ 'oracle' ][ 'timestamp(6)' ]=SQLT_LNG;
		$strFieldType                           =strtolower( $strFieldType );
		$dbType                                 =strtolower( $this->getDbType() );
		$result                                 =null;

		if ( isset( $bindTypes[ $dbType ][ $strFieldType ] ) )
		{
			$result = $bindTypes[ $dbType ][ $strFieldType ];
		}

		return $result;
	}
    /**
    * Ativa / Desativia o commit autom�tico ap�s a execu��o do m�todo query()
    *
    * @param boolean $boolNewValue
    */
	public function setAutoCommit( $boolNewValue = null )
	{
		$this->autoCommit=$boolNewValue;
	}
    /**
    * Retorna se autocomit est� ativo ou n�o.
    *
    */
	public function getAutoCommit()
	{
		return ( ( $this->autoCommit === false ) ? false : true );
	}
    /**
    * Inicializa uma transa��o no banco de dados
    *
    */
	public function beginTransaction()
	{
		if( $this->getHasActiveTransaction() )
		{
			return true;
		}
		if ( $this->getConn() )
		{
			if ( $this->isPDO() )
			{
				$this->getConn()->beginTransaction();
				$this->hasActiveTransaction=true;
				return true;
			}
		}
		return false;
	}
    /**
    * Termina a transa��o atual e faz com que todas as mudan�as sejam permanentes.
    *
    */
	public function commit()
	{
		if( ! $this->getHasActiveTransaction() )
		{
			return;
		}
		$this->hasActiveTransaction=false;
		if ( $this->getConn() )
		{
			if ( $this->getDbType() == 'oracle' )
			{
				oci_commit( $this->getConn()->connection );
			}
			else
			{
				$this->getConn()->commit();
			}
		}
	}
    /**
    * Cancela a transa��o atual desfazendo todas as mudan�as pendentes.
    *
    */
	public function rollBack()
	{
		if( ! $this->getHasActiveTransaction() )
		{
			return;
		}
		$this->hasActiveTransaction=false;
		if ( $this->getConn() )
		{
			if ( $this->isPDO() )
			{
				$this->getConn()->rollBack();
			}
		}
	}
	/**
	* Define o valor de um campo da tabela
	*
	* @param string $strFieldName
	* @param mixed $value
	*/
	public function setFieldValue($strFieldName,$value=null)
	{
		$objField = $this->getField($strFieldName);
		if( is_object($objField) )
		{
			$objField->value = $value;
		}
		else
		{
			throw new Exception('Invalid field name '.$strFieldName. ' for table '.$this->getTableName() );
		}
	}
	/**
	* Retorna o valor de um campo da tabela
	*
	* @param string $strFieldName
	*/
	public function getFieldValue($strFieldName)
	{
		$objField = $this->getField($strFieldName);
		if( is_object($objField) && isset($objField->value) )
		{
			return $objField->value;
		}
		return null;
	}
	/**
	* Define o(s) campo(s) que ser�o chave prim�ria da tabela
	*
	* @example
	* $daoPg->setPrimaryKey(array('campo1','campo2'));
	* $daoPg->setPrimaryKey('campo1,campo2');
	*
	* @param mixed $mixFieldName
	*/
	public function setPrimaryKey( $mixFieldName=null )
	{
		$fields 	= $this->getFields();
		if( is_array( $fields ) )
		{
			// remover marca��o de chave primaria
			foreach($fields as $k => $objField )
			{
				$objField->primaryKey= 0;
			}
		}
		else
		{
			$this->addField( $mixFieldName );
			$fields 	= $this->getFields();
		}
		if( is_string($mixFieldName))
		{
			if( preg_match('/\,/',$mixFieldName)==1)
			{
				$mixFieldName = explode(',',$mixFieldName );
				$this->setPrimaryKey($mixFieldName);
			}
			else
			{
				$mixFieldName = trim($mixFieldName);
                $this->primaryKeys[$mixFieldName]=true;
				if( $this->getField($mixFieldName) )
				{
					$this->getField($mixFieldName)->primaryKey=1;
				}
			}
		}
		else if( is_array($mixFieldName))
		{
			foreach($mixFieldName as $fieldName)
			{
				$fieldName = trim($fieldName);
                $this->primaryKeys[$fieldName]=true;
				if( $this->getField($fieldName) )
				{
					$this->getField($fieldName)->primaryKey=1;
				}
			}
		}
	}
    /**
    * Retorna o array de campos que fazem parte da chave prim�ria da tabela
    *
    * @return array
    */
	public function getPrimaryKeys()
	{
		$result=array();
		if( $this->getFields())
		{
			foreach($this->getFields() as $fieldName=>$objField)
			{
				if( isset( $objField->primaryKey) && $objField->primaryKey == 1 )
				{
					array_push($result,$objField->fieldName);
				}
			}
		}
		else
		{
			if( is_array($this->primaryKeys) )
			{
				$result = array_keys($this->primaryKeys);
			}
		}
		return $result;
	}
	/**
	* Persiste os valores dos campos definidos com setFieldValue() chamando
	* o m�todo insert ou update
	*
	*/
	public function save()
	{
		$result = false;
		$pks = $this->getPrimaryKeys();
		if( count($pks) > 0 )
		{
			$params=null;
			$where = '';
			foreach($pks as $v)
			{
				$params[$v] = $this->getFieldValue($v);
				if($this->isPDO())
				{
					$where[] = $v.'=?';
				}
				else
				{
					$where[] = $v.' = :'.$v;
				}
			}
			$sql = "select ".$pks[0]." from ".$this->getTableName()." where ".implode(' and ',$where);
			//print_r($params);
			$result = $this->query($sql,$params);
			if( is_array($result) && count($result)>0)
			{
				$result = $this->update();
			}
			else
			{
				$result = $this->insert();
			}
		}
		else
		{
			$result = $this->insert();
		}
		return $result;
	}
	/**
	* Executa o comando insert com os valores definidos nos campos da tabela
	*
	*/
	public function insert()
	{
		$fields=$this->getFields();
		if( is_array( $fields ) )
		{
			$params=null;
			foreach($fields as $fieldName=>$objField)
			{
				if( ! $objField->autoincrement )
				{
					$params[$objField->fieldName] = isset($objField->value) ? $objField->value : null;
				}
			}
		}
		return $this->insertValues($params);
	}
    /**
    * Executa o comando update na tabela
    *
    */
	public function update()
	{
		$fields=$this->getFields();
		if( is_array( $fields ) )
		{
			$params=null;
			foreach($fields as $fieldName=>$objField)
			{
				if( ! $objField->autoincrement )
				{
					$params[$objField->fieldName] = isset($objField->value) ? $objField->value : null;
				}
			}
		}
		return $this->updateValues($params);
	}
    /**
    * Executa o comando delete na tabela
    *
    */
	public function delete()
	{
		return $this->deleteValues();
	}
    /**
    * Executa o comando insert baseado no array de campos e valores recebidos
    *
    * @param mixed $arrFieldValues
    */
    public function insertValues( $arrFieldValues = null )
	{
		if ( !$this->connect() )
		{
			return false;
		}

		try
		{
			$userTransation = $this->getHasActiveTransaction();
			$this->beginTransaction();
			if ( $this->getDbType() != 'oracle' )
			{
				$sqlInsert      ="insert into " . $this->getTableName() . ' ';
				$valuesClause   =null;
				$params         =null;
				$returningClause='';

				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = trim( $fieldName );

					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						if( ! is_null( $fieldValue ) )
						{
							$params[ $fieldName ]=$fieldValue;
							$valuesClause[]      ='?';
						}
					}
				}
				$columnsClause='(' . implode( ',', array_keys( $params ) ) . ')';
				$valuesClause ='values (' . implode( ',', $valuesClause ) . ')';
				if ( $this->getDbType() == 'postgres' && $this->getAutoincFieldName() )
				{
					$returningClause = 'returning ' . $this->getAutoincFieldName();
				}
				$sqlInsert .= trim( ' ' . $columnsClause . ' ' . $valuesClause . ' ' . $returningClause );
				$this->lastId=null;
				$result = self::query( $sqlInsert, $params );
			}
			else
			{
				// oracle
				$sqlInsert   ="insert into " . $this->getTableName() . ' ';
				$valuesClause=null;
				$params      =null;
				$returningFields=array();
				$returningInto=array();
				$descriptors=null;
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = strtolower( trim( $fieldName ) );
					$objField  =$this->getField( $fieldName );

					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						// valor do campo
						$params[ $fieldName ]=$fieldValue;

						// campo blob
						if ( $objField && strtoupper( $objField->fieldType ) == 'BLOB' )
						{
							$valuesClause[]='empty_blob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else if( $objField && strtoupper( $objField->fieldType ) == 'CLOB' )
						{
							$valuesClause[]='empty_clob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else
						{
							$valuesClause[] = ':' . $fieldName;
						}
					}
				}

				$params       =$this->prepareParams( $params, true ); // tratar acentos
				$columnsClause='(' . implode( ',', array_keys( $params ) ) . ')';
				$valuesClause ='values (' . implode( ',', $valuesClause ) . ')';

				if ( $this->getAutoincFieldName() )
				{
					array_push( $returningFields, $this->getAutoincFieldName() );
					array_push( $returningInto, ':' . $this->getAutoincFieldName() );
				}

				$returningClause='';

				if ( count( $returningFields ) > 0 )
				{
					$returningClause = ' returning ' . implode( ',', $returningFields ) . ' into ' . implode( ',', $returningInto );
				}
				$sqlInsert .= $columnsClause . ' ' . $valuesClause . ' ' . $returningClause;
				$stmt=oci_parse( $this->getConn()->connection, $sqlInsert );
				foreach( $params as $fieldName => $fieldValue )
				{
					$objField = $this->getField( $fieldName );

					if ( $objField )
					{
						$bindType=$this->getBindType( $objField->fieldType );
						if ( $bindType == SQLT_CLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_CLOB );
						}
						else if( $bindType == SQLT_BLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_BLOB );
						}
						else
						{
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
						}
					}
					else
					{
						oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
					}
				}

				$lastId      =null;
				$this->lastId=null;

				// adicionar o campo autoinc no retorno do insert para capturar o valor gerado
				if ( $this->getAutoincFieldName() )
				{
					oci_bind_by_name( $stmt, ':' . $this->getAutoincFieldName(), $lastId, 20, SQLT_INT );
				}

				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );

					throw new Exception( 'Insert error ' . $e[ 'message' ] );
				}

				// salvar os campos lobs
				if ( count( $descriptors ) > 0 )
				{
					foreach( $descriptors as $k => $v )
					{
						$params[ $k ]->save( $v );
					}
				}

				if ( $this->getAutoCommit() && ! $userTransation )
				{
					$this->commit();
				}

				oci_free_statement( $stmt );

				if ( $lastId )
				{
					$result[ 0 ][ $this->getAutoincFieldName()] = $lastId;
				}
			}
		}
		catch( Exception $e )
		{
			if( ! $userTransation )
			{
				$this->rollBack();
			}
			$this->setError( $e->getMessage() );
			return false;
		}
		if( $this->getAutoincFieldName() )
		{
			if ( isset($result) && is_array($result) )
			{
				if ( isset( $result[ 0 ][ strtolower( $this->getAutoincFieldName() )] ) )
				{
					$this->lastId = $result[ 0 ][ strtolower( $this->getAutoincFieldName() )];
				}
				else if( isset( $result[ 0 ][ strtoupper( $this->getAutoincFieldName() )] ) )
				{
					$this->lastId = $result[ 0 ][ strtoupper( $this->getAutoincFieldName() )];
				}
			}
			else
			{
				$this->lastId = $this->getLastInsertId();
			}
			$this->setFieldValue($this->getAutoincFieldName(),$this->lastId);
		}

		if( ! $userTransation )
		{
			$this->commit();
		}
		return true;
	}

    /**
    * Executa o comando delete aseado no array de campos e valores recebidos
    * @param mixed $arrFieldValues
    */
	public function deleteValues($arrFieldValues=null)
	{
		if ( !$this->connect() )
		{
			return false;
		}
    	$result = false;
		try
		{
			if ( $this->getDbType() != 'oracle' )
			{
				$sqlUpdate 		= "delete from " . $this->getTableName();
				$params         = null;
				if( is_array( $arrFieldValues ) )
				{
					foreach( $arrFieldValues as $fieldName => $fieldValue )
					{
						$fieldName = trim( $fieldName );
						$params[ $fieldName ]=$fieldValue;
					    $whereClause[] = $fieldName.' = ?';
					}
				}
				else
				{
					$pks = $this->getPrimaryKeys();
					if( count($pks) == 0 )
					{
						$this->setError('Primary key for table '.$this->getTableName().' not defined!');
						return $result;
					}
					else
	                {
		                $whereClause = null;
   						foreach($pks as $k=>$v)
						{
				            $whereClause[] = $v.' = ?';
				            $params[] = $this->getFieldValue($v);
						}
					}
				}
				if( is_array($params) && is_array($whereClause) )
				{
					$whereClause = implode(' and ',$whereClause);
					$sqlUpdate .= ' where '.$whereClause;
					$result = self::query( $sqlUpdate, $params );
				}
			}
			else
			{
  				// oracle sem PDO
				$sql ="delete from " . $this->getTableName();
				$whereClause = array();
				$params      =null;
				if( is_array($arrFieldValues))
				{
					foreach( $arrFieldValues as $fieldName => $fieldValue )
					{
						$params[ $fieldName ]=$fieldValue;
						$whereClause[] = $fieldName.'=:' . $fieldName;
					}
				}
				else
				{
					// where
					$pks = $this->getPrimaryKeys();
					if( count($pks) == 0 )
					{
						$this->setError('Primary key for table '.$this->getTableName().' not defined!');
						return $result;
					}
					else
	                {
						$whereClause =null;
						foreach($pks as $v)
						{
							$v = strtolower($v);
							$params[$v] = $this->getFieldValue($v);
							$whereClause[] = $v.' = :'.$v;
						}
					}
				}
				$whereClause = 'where '.implode(' and ', $whereClause);
				$sql .= ' '.$whereClause;
				$stmt = oci_parse( $this->getConn()->connection, $sql);
				if( !$stmt)
				{
					$e = oci_error();
					throw new Exception( 'Parse error ' . $e[ 'message' ] );
				}

   				$params = $this->prepareParams( $params, true ); // tratar acentos
				// fazer o bind dos valores aos parametros

				foreach( $params as $fieldName => $fieldValue )
				{
					oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
				}
				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );
					throw new Exception( 'Update error ' . $e[ 'message' ] );
				}
 				if ( $this->getAutoCommit() )
				{
					$this->commit();
				}
				$result = true;
 				oci_free_statement( $stmt );
			}
		}
		catch(Exception $e)
		{
			$this->setError($e->getMessage());
			return $result;
		}
		return $result;
	}
	/**
	* Executa o comando update baseado no array de campos e valores recebidos
	*
	* @param mixed $arrFieldValues
	*/
	public function updateValues($arrFieldValues=null)
	{
		if ( !$this->connect() )
		{
			return false;
		}
		$result = false;
		try
		{
			$pks = $this->getPrimaryKeys();
			if( ! is_array($pks))
			{
				$this->setError('Primary key for table '.$this->getTableName().' not defined!');
				return $result;
			}

			if ( $this->getDbType() != 'oracle' )
			{
				$sqlUpdate 		= "update " . $this->getTableName() . ' set ';
				$valuesClause   = null;
				$params         = null;
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = trim( $fieldName );
					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						//if( ! is_null( $fieldValue ) )
						{
							$params[ $fieldName ]=$fieldValue;
							$valuesClause[]      = $fieldName.'=?';
						}
					}
				}
				$valuesClause = implode( ',', $valuesClause );
                // criar a clausula where
				$sqlUpdate .= trim( $valuesClause );
                if( is_array($pks))
                {
	                $whereClause = null;
   					foreach($pks as $k=>$v)
					{

			            $whereClause[] = $v.' = ?';
			            $params[] = $this->getFieldValue($v);
					}
					$whereClause = implode(' and ',$whereClause);
					$sqlUpdate .= ' where '.$whereClause;
				}
				$result = self::query( $sqlUpdate, $params );
			}
			else
			{
  				// oracle sem PDO
				$sql ="update " . $this->getTableName() . ' set ';
				$valuesClause=null;
				$params      =null;
				$returningFields=array();
				$returningInto=array();
				$descriptors=null;
				foreach( $arrFieldValues as $fieldName => $fieldValue )
				{
					$fieldName = strtolower( trim( $fieldName ) );
					$objField  = $this->getField( $fieldName );
					if ( !$this->getAutoincFieldName() || strtolower( $fieldName ) != strtolower( $this->getAutoincFieldName() ) )
					{
						// valor do campo
						$params[ $fieldName ]=$fieldValue;

						// campo blob
						if ( $objField && strtoupper( $objField->fieldType ) == 'BLOB' )
						{
							$valuesClause[]= $fieldName.'=empty_blob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else if( $objField && strtoupper( $objField->fieldType ) == 'CLOB' )
						{
							$valuesClause[] = $fieldName.'= empty_clob()';
							array_push( $returningFields, $fieldName );
							array_push( $returningInto, ':' . $fieldName );
						}
						else
						{
							$valuesClause[] = $fieldName.'=:' . $fieldName;
						}
					}
				}
				$valuesClause = implode(',',$valuesClause);
				$sql .= ' '.$valuesClause;

				// where
				$whereClause =null;
				foreach($pks as $v)
				{
					$v = strtolower($v);
					$params['w_'.$v] = $this->getFieldValue($v);
					$whereClause[] = $v.' = :w_'.$v;
				}
				$whereClause = 'where '.implode(' and ', $whereClause);
				$sql .= ' '.$whereClause;

				// returning
				$returningClause='';
				if ( count( $returningFields ) > 0 )
				{
					$returningClause = ' returning ' . implode( ',', $returningFields ) . ' into ' . implode( ',', $returningInto );
				}

				$sql .= ' '.$returningClause;

				$stmt = oci_parse( $this->getConn()->connection, $sql);
				if( !$stmt)
				{
					$e = oci_error();
					throw new Exception( 'Parse error ' . $e[ 'message' ] );
				}

   				$params = $this->prepareParams( $params, true ); // tratar acentos
				// fazer o bind dos valores aos parametros
				foreach( $params as $fieldName => $fieldValue )
				{
					$objField = $this->getField( $fieldName );

					if ( $objField )
					{
						$bindType=$this->getBindType( $objField->fieldType );
						if ( $bindType == SQLT_CLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_CLOB );
						}
						else if( $bindType == SQLT_BLOB )
						{
							$descriptors[ $fieldName ]=$params[ $fieldName ];
							$params[ $fieldName ]     =oci_new_descriptor( $this->getConn()->connection );
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], -1, SQLT_BLOB );
						}
						else
						{
							oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ], $objField->size, $bindType );
						}
					}
					else
					{
						oci_bind_by_name( $stmt, ':' . $fieldName, $params[ $fieldName ] );
					}
				}
				if ( !@oci_execute( $stmt, OCI_NO_AUTO_COMMIT ) )
				{
					$e=oci_error( $stmt );
					oci_free_statement( $stmt );

					throw new Exception( 'Update error ' . $e[ 'message' ] );
				}

				// salvar os campos lobs
				if ( count( $descriptors ) > 0 )
				{
					foreach( $descriptors as $k => $v )
					{
						$params[ $k ]->save( $v );
					}
				}
 				if ( $this->getAutoCommit() )
				{
					$this->commit();
				}
				$result = true;
 				oci_free_statement( $stmt );
			}
		}
		catch(Exception $e)
		{
			$this->setError($e->getMessage());
			return $result;
		}
		return $result;
	}
	/**
	* Retorna se j� existe ou n�o uma transa��o aberta
	*
	*/
	public function getHasActiveTransaction()
	{
		return $this->hasActiveTransaction;
	}
	/**
	* Retorna o �ltimo comando sql executado
	*
	*/
	public function getSqlCmd()
	{
		return $this->sqlCmd;
	}
	/**
	* Retorna os parametros recebidos no ultimo comando sql executado
	*
	*/
	public function getSqlParams()
	{
		return $this->sqlParams;
	}

	/**
	* M�todo m�gico para definir/recuperar os valores dos campos no formato
	* setNome_campo(0) e getNome_campo();
	* sem a necessidade de criar um m�todo get e set para cada campo
	*
	* @param mixed $m
	* @param mixed $a
	*/
    function __call($m, $a)
    {
    	if( preg_match('/^set/',$m) == 1 )
    	{
    		$fieldName = substr($m,3);
    		if( $fieldName )
    		{
    			$this->setFieldValue($fieldName, isset( $a[0] ) ? $a[0]:null );
    			return;
			}
		}
		else
		{
    		if( preg_match('/^get/',$m) == 1 )
    		{
    			$fieldName = substr($m,3);
    			if( $fieldName )
    			{
    				return $this->getFieldValue($fieldName);
				}
			}
		}
		throw new Exception( 'Call to Undefined Method/Class Function '.$m );
    }
    /**
    * Manter compatibilidade com a classe TPDOConnection
    * retornando o array no formato $data['COLUNA_TABELA'][LINHA]= VALOR;
    *
    * @param string $sql
    * @param string $params
    */
    function executeSql($sql=null,$params=null)
    {
		$result = $this->query($sql,$params);
		$data=$result;
		if( is_array($result) )
		{
			$data=null;
			foreach($result as $rowIndex => $row)
			{
				foreach($row as $k=>$v)
				{
					$data[strtoupper($k)][$rowIndex]=$v;
				}
			}
		}
		return $data;
    }

    function getFieldNames()
    {
    	if( is_array($this->getFields() ))
    	{
    		$arrNames=array();
			foreach( $this->getFields() as $fieldName => $objField )
			{
				$arrNames[] = $objField->fieldName;
			}
			return implode(',',$arrNames);
		}
		return '*';
    }
    /**
    * Consulta com retorno no formato de array da Framework FormDin
    *
    * @param mixed $sql
    * @param mixed $params
    * @param mixed $fechMode
    */
    function qfw($sql=null,$params=null,$fechMode=null)
    {
		$data = $this->query($sql,$params,$fechMode);
		$result=null;
		if( is_array( $data ) )
		{
			foreach( $data as $k => $arr )
			{
				foreach( $arr as $fieldName => $value )
				{
					$result[ $fieldName ][ $k ] = $value;
				}
			}
		}
		return $result;
    }
}
?>