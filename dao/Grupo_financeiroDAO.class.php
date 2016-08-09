<?php
class Grupo_financeiroDAO extends TPDOConnection
{
	public function grupo_financeiroDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Grupo_financeiroVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into grupo_financeiro(
								 descricao
								,situacao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from grupo_financeiro where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from grupo_financeiro where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from grupo_financeiro'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
        
        //--------------------------------------------------------------------------------
        public static function selectEspecifico( $query=null )
	{
		return self::executeSql($query);
	}
        
	//--------------------------------------------------------------------------------
	public static function update ( Grupo_financeiroVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update grupo_financeiro set 
								 descricao = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>