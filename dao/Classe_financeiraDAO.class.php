<?php
class Classe_financeiraDAO extends TPDOConnection
{
	public function classe_financeiraDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Classe_financeiraVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into classe_financeira(
								 descricao
								,situacao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from classe_financeira where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from classe_financeira where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from classe_financeira'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	  //--------------------------------------------------------------------------------
        public static function selectEspecifico( $query=null )
	{
		return self::executeSql($query);
	}
        
	//--------------------------------------------------------------------------------
	public static function update ( Classe_financeiraVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update classe_financeira set 
								 descricao = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>