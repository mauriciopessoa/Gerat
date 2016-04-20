<?php
class Tb_usuarioVO
{
	private $id = null;
	private $nome = null;
	private $login = null;
	private $senha = null;
	public function Tb_usuarioVO( $id=null, $nome=null, $login=null, $senha=null )
	{
		$this->setId( $id );
		$this->setNome( $nome );
		$this->setLogin( $login );
		$this->setSenha( $senha );
	}
	//--------------------------------------------------------------------------------
	function setId( $strNewValue = null )
	{
		$this->id = $strNewValue;
	}
	function getId()
	{
		return $this->id;
	}
	//--------------------------------------------------------------------------------
	function setNome( $strNewValue = null )
	{
		$this->nome = $strNewValue;
	}
	function getNome()
	{
		return $this->nome;
	}
	//--------------------------------------------------------------------------------
	function setLogin( $strNewValue = null )
	{
		$this->login = $strNewValue;
	}
	function getLogin()
	{
		return $this->login;
	}
	//--------------------------------------------------------------------------------
	function setSenha( $strNewValue = null )
	{
		$this->senha = $strNewValue;
	}
	function getSenha()
	{
		return md5(trim($this->senha));
	}
	//--------------------------------------------------------------------------------
}
?>