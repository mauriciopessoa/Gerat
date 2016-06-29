<?php
class PaisDAO extends TPDOConnection
{
	public function paisDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( PaisVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into pais(
								 nome
								,situacao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from pais where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,nome
								,situacao
								from pais where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,nome
								,situacao
								from pais'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( PaisVO $objVo )
	{
		$values = array( $objVo->getNome()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update pais set 
								 nome = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>