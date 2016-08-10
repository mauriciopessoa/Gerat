<?php
class Subclasse_financeiraDAO extends TPDOConnection
{
	public function subclasse_financeiraDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Subclasse_financeiraVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getClasse() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into subclasse_financeira(
								 descricao
								,classe
								,situacao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from subclasse_financeira where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								,classe
								,situacao
								from subclasse_financeira where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								,classe
								,situacao
								from subclasse_financeira'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Subclasse_financeiraVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getClasse()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update subclasse_financeira set 
								 descricao = ?
								,classe = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>