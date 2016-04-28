<?php
class Cid_10DAO extends TPDOConnection
{
	public function cid_10DAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Cid_10VO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getCod_cid() 
						, $objVo->getDescricao() 
						);
		return self::executeSql('insert into cid_10(
								 cod_cid
								,descricao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from cid_10 where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 cod_cid
								,descricao
								from cid_10 where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 cod_cid
								,descricao
								from cid_10'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Cid_10VO $objVo )
	{
		$values = array( $objVo->getCod_cid()
						,$objVo->getDescricao()
						,$objVo->getCodigo() );
		return self::executeSql('update cid_10 set 
								 cod_cid = ?
								,descricao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>