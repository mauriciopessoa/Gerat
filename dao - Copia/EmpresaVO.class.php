<?php
class EmpresaVO
{
	private $codigo_empresa = null;
	private $razao_social = null;
	private $fantasia = null;
	private $cnpj = null;
	private $endereco = null;
	private $ie = null;
	private $cidade = null;
	private $bairro = null;
	private $uf = null;
	private $cep = null;
	private $telefone1 = null;
	private $telefone2 = null;
	private $email = null;
	private $situacao = null;
	public function EmpresaVO( $codigo_empresa=null, $razao_social=null, $fantasia=null, $cnpj=null, $endereco=null, $ie=null, $cidade=null, $bairro=null, $uf=null, $cep=null, $telefone1=null, $telefone2=null, $email=null, $situacao=null )
	{
		$this->setCodigo_empresa( $codigo_empresa );
		$this->setRazao_social( $razao_social );
		$this->setFantasia( $fantasia );
		$this->setCnpj( $cnpj );
		$this->setEndereco( $endereco );
		$this->setIe( $ie );
		$this->setCidade( $cidade );
		$this->setBairro( $bairro );
		$this->setUf( $uf );
		$this->setCep( $cep );
		$this->setTelefone1( $telefone1 );
		$this->setTelefone2( $telefone2 );
		$this->setEmail( $email );
		$this->setSituacao( $situacao );
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
	function setCnpj( $strNewValue = null )
	{
		$this->cnpj = preg_replace('/[^0-9]/','',$strNewValue);
	}
	function getCnpj()
	{
		return $this->cnpj;
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
	function setIe( $strNewValue = null )
	{
		$this->ie = $strNewValue;
	}
	function getIe()
	{
		return $this->ie;
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
	function setBairro( $strNewValue = null )
	{
		$this->bairro = $strNewValue;
	}
	function getBairro()
	{
		return $this->bairro;
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
	function setEmail( $strNewValue = null )
	{
		$this->email = $strNewValue;
	}
	function getEmail()
	{
		return $this->email;
	}
	//--------------------------------------------------------------------------------
	function setSituacao( $strNewValue = null )
	{
            if (empty($strNewValue))
            {
                $strNewValue = 'A';
            }
		$this->situacao = $strNewValue;
	}
	function getSituacao()
	{
		return $this->situacao;
	}
	//--------------------------------------------------------------------------------
}
?>