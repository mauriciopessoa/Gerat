<?php
class Banco_agenciaDAO extends TPDOConnection
{
	public function banco_agenciaDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Banco_agenciaVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getBanco() 
						, $objVo->getNumero() 
						, $objVo->getEndereco() 
						, $objVo->getCidade() 
						, $objVo->getUf() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into banco_agencia(
								 banco
								,numero
								,endereco
								,cidade
								,uf
								,situacao
								) values (?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from banco_agencia where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,banco
								,numero
								,endereco
								,cidade
								,uf
								,situacao
								from banco_agencia where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,banco
								,numero
								,endereco
								,cidade
								,uf
								,situacao
								from banco_agencia'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Banco_agenciaVO $objVo )
	{
		$values = array( $objVo->getBanco()
						,$objVo->getNumero()
						,$objVo->getEndereco()
						,$objVo->getCidade()
						,$objVo->getUf()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update banco_agencia set 
								 banco = ?
								,numero = ?
								,endereco = ?
								,cidade = ?
								,uf = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>