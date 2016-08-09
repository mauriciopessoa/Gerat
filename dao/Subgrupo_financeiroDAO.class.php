<?php
class Subgrupo_financeiroDAO extends TPDOConnection
{
	public function subgrupo_financeiroDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Subgrupo_financeiroVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getGrupo() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into subgrupo_financeiro(
								 descricao
								,grupo
								,situacao
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from subgrupo_financeiro where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								,grupo
								,situacao
								from subgrupo_financeiro where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								,grupo
								,situacao
								from subgrupo_financeiro'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( Subgrupo_financeiroVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getGrupo()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update subgrupo_financeiro set 
								 descricao = ?
								,grupo = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>