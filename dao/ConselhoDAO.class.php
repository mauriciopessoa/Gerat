<?php
class ConselhoDAO extends TPDOConnection
{
	public function conselhoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( ConselhoVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getSigla() 
						, $objVo->getDescricao_conselho() 
						);
		return self::executeSql('insert into conselho(
								 sigla
								,descricao_conselho
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from conselho where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,sigla
								,descricao_conselho
								from conselho where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
        public static function selectEspecifico( $query=null )
	{
		return self::executeSql($query);
	}
        
        //--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,sigla
								,descricao_conselho
								from conselho'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
        
        
        
	public static function update ( ConselhoVO $objVo )
	{
		$values = array( $objVo->getSigla()
						,$objVo->getDescricao_conselho()
						,$objVo->getCodigo() );
		return self::executeSql('update conselho set 
								 sigla = ?
								,descricao_conselho = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>