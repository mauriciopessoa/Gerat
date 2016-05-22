<?php
class EspecialidadeDAO extends TPDOConnection
{
	public function especialidadeDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( EspecialidadeVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						);
		return self::executeSql('insert into especialidade(
								 descricao
								) values (?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from especialidade where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								from especialidade where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								from especialidade'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( EspecialidadeVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getCodigo() );
		return self::executeSql('update especialidade set 
								 descricao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>