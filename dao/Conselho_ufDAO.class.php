<?php
class Conselho_ufDAO extends TPDOConnection
{
	public function conselho_ufDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( Conselho_ufVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getConselho() 
						, $objVo->getUf() 
						);
		return self::executeSql('insert into conselho_uf(
								 conselho
								,uf
								) values (?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from conselho_uf where conselho = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,conselho
								,uf
								from conselho_uf where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,conselho
								,uf
								from conselho_uf'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
        
        	
        public static function selectEspecifico( $query=null )
	{
		return self::executeSql($query);
	}
        
        //--------------------------------------------------------------------------------
	public static function update ( Conselho_ufVO $objVo )
	{
		$values = array( $objVo->getConselho()
						,$objVo->getUf()
						,$objVo->getCodigo() );
		return self::executeSql('update conselho_uf set 
								 conselho = ?
								,uf = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>