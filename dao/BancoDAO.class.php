<?php
class BancoDAO extends TPDOConnection
{
	public function bancoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( BancoVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome() 
						, $objVo->getCodigo_bacen() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into banco(
								 nome
								,codigo_bacen
								,situacao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from banco where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,nome
								,codigo_bacen
								,situacao
								from banco where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,nome
								,codigo_bacen
								,situacao
								from banco'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( BancoVO $objVo )
	{
		$values = array( $objVo->getNome()
						,$objVo->getCodigo_bacen()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update banco set 
								 nome = ?
								,codigo_bacen = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>