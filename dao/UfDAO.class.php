<?php
class UfDAO extends TPDOConnection
{
	public function ufDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( UfVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getSigla() 
						, $objVo->getDescricao() 
						);
		return self::executeSql('insert into uf(
								 sigla
								,descricao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from uf where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,sigla
								,descricao
								from uf where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,sigla
								,descricao
								from uf'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( UfVO $objVo )
	{
		$values = array( $objVo->getSigla()
						,$objVo->getDescricao()
						,$objVo->getCodigo() );
		return self::executeSql('update uf set 
								 sigla = ?
								,descricao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>