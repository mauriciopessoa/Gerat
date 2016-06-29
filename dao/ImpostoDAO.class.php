<?php
class ImpostoDAO extends TPDOConnection
{
	public function impostoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( ImpostoVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into imposto(
								 nome
								,situacao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from imposto where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,nome
								,situacao
								from imposto where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,nome
								,situacao
								from imposto'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( ImpostoVO $objVo )
	{
		$values = array( $objVo->getNome()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update imposto set 
								 nome = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>