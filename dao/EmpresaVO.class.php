<?php
class EmpresaVO
{
	private $codigo_empresa = null;
	private $razao_social = null;
	private $fantasia = null;
	private $endereco = null;
	private $bairro = null;
	private $cidade = null;
	private $uf = null;
	private $cep = null;
	private $cnpj = null;
	private $ie = null;
	private $email = null;
	private $telefone1 = null;
	private $telefone2 = null;
	private $fax = null;
	private $situacao		 = null;
	public function EmpresaVO( $codigo_empresa=null, $razao_social=null, $fantasia=null, $endereco=null, $bairro=null, $cidade=null, $municipio=null, $uf=null, $cep=null, $cnpj=null, $ie=null, $email=null, $telefone1=null, $telefone2=null, $fax=null, $situacao		=null )
	{
		$this->setCodigo_empresa( $codigo_empresa );
		$this->setRazao_social( $razao_social );
		$this->setFantasia( $fantasia );
		$this->setEndereco( $endereco );
		$this->setBairro( $bairro );
		$this->setCidade( $cidade );
		$this->setUf( $uf );
		$this->setCep( $cep );
		$this->setCnpj( $cnpj );
		$this->setIe( $ie );
		$this->setEmail( $email );
		$this->setTelefone1( $telefone1 );
		$this->setTelefone2( $telefone2 );
		$this->setFax( $fax );
		$this->setSituacao		( $situacao		 );
	}
	//--------------------------------------------------------------------------------
	function setCodigo_empresa( $strNewValue = null )
	{
		$this->codigo_empresa = $strNewValue;
	}
	function getCodigo_empresa()
	{
		return $this->codigo_empresa;
	}
	//--------------------------------------------------------------------------------
	function setRazao_social( $strNewValue = null )
	{
		$this->razao_social = $strNewValue;
	}
	function getRazao_social()
	{
		return $this->razao_social;
	}
	//--------------------------------------------------------------------------------
	function setFantasia( $strNewValue = null )
	{
		$this->fantasia = $strNewValue;
	}
	function getFantasia()
	{
		return $this->fantasia;
	}
	//--------------------------------------------------------------------------------
	function setEndereco( $strNewValue = null )
	{
		$this->endereco = $strNewValue;
	}
	function getEndereco()
	{
		return $this->endereco;
	}
	//--------------------------------------------------------------------------------
	function setBairro( $strNewValue = null )
	{
		$this->bairro = $strNewValue;
	}
	function getBairro()
	{
		return $this->bairro;
	}
	//--------------------------------------------------------------------------------
	function setCidade( $strNewValue = null )
	{
		$this->cidade = $strNewValue;
	}
	function getCidade()
	{
		return $this->cidade;
	}
	
	//--------------------------------------------------------------------------------
	function setUf( $strNewValue = null )
	{
		$this->uf = $strNewValue;
	}
	function getUf()
	{
		return $this->uf;
	}
	//--------------------------------------------------------------------------------
	function setCep( $strNewValue = null )
	{
		$this->cep = $strNewValue;
	}
	function getCep()
	{
		return $this->cep;
	}
	//--------------------------------------------------------------------------------
	function setCnpj( $strNewValue = null )
	{
		$this->cnpj = preg_replace('/[^0-9]/','',$strNewValue);
	}
	function getCnpj()
	{
		return $this->cnpj;
	}
	//--------------------------------------------------------------------------------
	function setIe( $strNewValue = null )
	{
		$this->ie = $strNewValue;
	}
	function getIe()
	{
		return $this->ie;
	}
	//--------------------------------------------------------------------------------
	function setEmail( $strNewValue = null )
	{
		$this->email = $strNewValue;
	}
	function getEmail()
	{
		return $this->email;
	}
	//--------------------------------------------------------------------------------
	function setTelefone1( $strNewValue = null )
	{
		$this->telefone1 = $strNewValue;
	}
	function getTelefone1()
	{
		return $this->telefone1;
	}
	//--------------------------------------------------------------------------------
	function setTelefone2( $strNewValue = null )
	{
		$this->telefone2 = $strNewValue;
	}
	function getTelefone2()
	{
		return $this->telefone2;
	}
	//--------------------------------------------------------------------------------
	function setFax( $strNewValue = null )
	{
		$this->fax = $strNewValue;
	}
	function getFax()
	{
		return $this->fax;
	}
	//--------------------------------------------------------------------------------
	function setSituacao		( $strNewValue = null )
	{
		$this->situacao		 = $strNewValue;
	}
	function getSituacao		()
	{
		return $this->situacao		;
	}
	//--------------------------------------------------------------------------------
}
?>