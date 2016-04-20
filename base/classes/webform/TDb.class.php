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
class TDb
{
	private static $conn	= array();
	private static $dbType 	= null;

	// construtor
	private function __construct()
	{
	}
	//------------------------------------------------------------------------------------------
	private function __clone()
	{
	}
	public static function setDbType( $newType = null )
	{
		self::$dbType = $newType;
	}
	public static function getDbType()
	{
		return self::$dbType;
	}
	//------------------------------------------------------------------------------------------
	public static function sql($sql=null,$arrParams=null,$fetchMode=null,$dbType=null)
	{
		$fetchMode = is_null($fetchMode) ? PDO::FETCH_ASSOC : $fetchMode;
		if( is_null( self::$dbType ) && defined('DEFAULT_DBMS' ) )
		{
			self::$dbType = DEFAULT_DBMS;
		}
		$dbType = is_null($dbType) ? self::$dbType : $dbType;
		if( ! $dbType )
		{
			throw new Exception("Necess�rio informar o tipo do banco de dados. Ex:TDb::setDbType('mysql'); ou defina a constante DEFAULT_DBMS. ex:define('DEFAULT_DBMS','mysql');");
		}
		if( is_null( self::$dbType ) )
		{
			self::$dbType = $dbType;
		}
		try
		{
			if( array_key_exists( $dbType, self::$conn ) )
			{
				$conn = self::$conn[$dbType];
			}
			else
			{
				$conn = TConnection::connect($dbType);
				if( !array_key_exists( $dbType, self::$conn ) )
				{
					self::$conn[$dbType] = $conn;
				}
			}
		}
		catch( Exception $e )
		{

			throw new Exception("<br><h3>Erro de conex�o</h3>".$e->getMessage().'<br>');
		}
		$result=null;
		try
		{
			if( !$sql)
			{
				return null;
			}
			$sql = trim($sql);
			if( $stmt = $conn->prepare( $sql ) )
			{
				if( $result = $stmt->execute( (array) $arrParams ) )
				{
					try
					{
						$data = $stmt->fetchAll( $fetchMode );
						if( preg_match('/^select/i',$sql ) > 0 )
						{
							$result = $data;
						}
					}
					catch(Exception $e)
					{
						return $result;
					}
				}
			}
		}
		catch( Exception $e )
		{
			$erro = "<h3>Erro de SQL</h3>".$sql.'<br><br>';
			if( $arrParams )
			{
				$erro .= '<b>Parametros:</b><br>';
				$erro .= print_r($arrParams,true);
				$erro .= '<br><br>';
			}
			$erro .= '<b>Mensagem:</b><br>'.$e->getMessage();
			throw new Exception($erro);
		}
		return $result;
	}
	//public static function

}
?>