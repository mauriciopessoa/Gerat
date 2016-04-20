<?php
class EmpresaDAO extends TPDOConnection
{
	public function empresaDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( EmpresaVO $objVo )
	{
                
		if( $objVo->getCodigo_empresa() )
		{
			return self::update($objVo);
		}
		$values = array(  $objVo->getRazao_social() 
						, $objVo->getFantasia() 
						, $objVo->getCnpj() 
						, $objVo->getEndereco() 
						, $objVo->getIe() 
						, $objVo->getCidade() 
						, $objVo->getBairro() 
						, $objVo->getUf() 
						, $objVo->getCep() 
						, $objVo->getTelefone1() 
						, $objVo->getTelefone2() 
						, $objVo->getEmail() 
						, $objVo->getSituacao() 
						);
		return self::executeSql('insert into empresa(
								 razao_social
								,fantasia
								,cnpj
								,endereco
								,ie
								,cidade
								,bairro
								,uf
								,cep
								,telefone1
								,telefone2
								,email
								,situacao
								) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', $values );
	}
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql('delete from empresa where codigo_empresa = ?',$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
		$values = array($id);
		return self::executeSql('select
								 codigo_empresa
								,razao_social
								,fantasia
								,cnpj
								,endereco
								,ie
								,cidade
								,bairro
								,uf
								,cep
								,telefone1
								,telefone2
								,email
								,situacao
								from empresa where codigo_empresa = ?', $values );
	}
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
		return self::executeSql('select
								 codigo_empresa
								,razao_social
								,fantasia
								,cnpj
								,endereco
								,ie
								,cidade
								,bairro
								,uf
								,cep
								,telefone1
								,telefone2
								,email
								,situacao
								from empresa'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
	}
	//--------------------------------------------------------------------------------
	public static function update ( EmpresaVO $objVo )
	{
		$values = array( $objVo->getRazao_social()
						,$objVo->getFantasia()
						,$objVo->getCnpj()
						,$objVo->getEndereco()
						,$objVo->getIe()
						,$objVo->getCidade()
						,$objVo->getBairro()
						,$objVo->getUf()
						,$objVo->getCep()
						,$objVo->getTelefone1()
						,$objVo->getTelefone2()
						,$objVo->getEmail()
						,$objVo->getSituacao()
						,$objVo->getCodigo_empresa() );
		return self::executeSql('update empresa set 
								 razao_social = ?
								,fantasia = ?
								,cnpj = ?
								,endereco = ?
								,ie = ?
								,cidade = ?
								,bairro = ?
								,uf = ?
								,cep = ?
								,telefone1 = ?
								,telefone2 = ?
								,email = ?
								,situacao = ?
								where codigo_empresa = ?',$values);
	}
	//--------------------------------------------------------------------------------
}
?>