<?php
class CartaoDAO extends TPDOConnection
{
	public function cartaoDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( CartaoVO $objVo )
	{
		if( $objVo->getCodigo() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getNome() 
						, $objVo->getPrazo_pagto() 
						, $objVo->getBanco_conta() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into cartao(
								 nome
								,prazo_pagto
								,banco_conta
								,situacao
								) values (?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from cartao where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo
								,nome
								,prazo_pagto
								,banco_conta
								,situacao
								from cartao where codigo = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo
								,nome
								,prazo_pagto
								,banco_conta
								,situacao
								from cartao'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( CartaoVO $objVo )
	{
		$values = array( $objVo->getNome()
						,$objVo->getPrazo_pagto()
						,$objVo->getBanco_conta()
						,$objVo->getSituacao()
						,$objVo->getCodigo() );
		return self::executeSql('update cartao set 
								 nome = ?
								,prazo_pagto = ?
								,banco_conta = ?
								,situacao = ?
								where codigo = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>