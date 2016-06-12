<?php
class Banco_contaDAO extends TPDOConnection
{
	public function banco_contaDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Banco_contaVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getAgencia() 
						, $objVo->getNumero() 
						, $objVo->getSaldo() 
						);
		return self::executeSql('insert into banco_conta(
								 agencia
								,numero
								,saldo
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from banco_conta where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,agencia
								,numero
								,saldo
								from banco_conta where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,agencia
								,numero
								,saldo
								from banco_conta'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Banco_contaVO $objVo )
	{
		$values = array( $objVo->getAgencia()
						,$objVo->getNumero()
						,$objVo->getSaldo()
						,$objVo->getCodigo() );
		return self::executeSql('update banco_conta set 
								 agencia = ?
								,numero = ?
								,saldo = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>