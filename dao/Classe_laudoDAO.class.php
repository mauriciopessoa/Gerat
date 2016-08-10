<?php
class Classe_laudoDAO extends TPDOConnection
{
	public function classe_laudoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Classe_laudoVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getDescricao() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into classe_laudo(
								 descricao
								,situacao
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from classe_laudo where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from classe_laudo where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,descricao
								,situacao
								from classe_laudo'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	    //--------------------------------------------------------------------------------
        public static function selectEspecifico( $query=null )
	{
		return self::executeSql($query);
	}
        
	//--------------------------------------------------------------------------------
	public static function update ( Classe_laudoVO $objVo )
	{
		$values = array( $objVo->getDescricao()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update classe_laudo set 
								 descricao = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>