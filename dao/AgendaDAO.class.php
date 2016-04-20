<?php
class AgendaDAO extends TPDOConnection
{
	public function agendaDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( AgendaVO $objVo )
	{
		if( $objVo->getCodigo_recurso() && $objVo->getdia() && $objVo->gethora() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getCodigo_recurso() 
						, $objVo->getDia() 
						, $objVo->getHora() 
						);
		return self::executeSql('insert into agenda(
								 codigo_recurso
								,dia
								,hora
								) values (?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from agenda where codigo_recurso,dia,hora = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo_recurso
								,dia
								,hora
								from agenda where codigo_recurso = ? and dia = ? and hora = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo_recurso
								,dia
								,hora
								from agenda'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( AgendaVO $objVo )
	{
		$values = array( $objVo->getCodigo_recurso()
						,$objVo->getDia()
						,$objVo->getHora()
						,$objVo->getCodigo_recurso,dia,hora() );
		return self::executeSql('update agenda set 
								 codigo_recurso = ?
								,dia = ?
								,hora = ?
								where codigo_recurso = ? and dia = ? and hora = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>