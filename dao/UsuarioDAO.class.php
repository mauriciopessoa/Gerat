<?php
class UsuarioDAO extends TPDOConnection
{
	public function usuarioDAO()
	{
	}
	//--------------------------------------------------------------------------------
	public static function insert( UsuarioVO $objVo )
	{
		if( $objVo->getId() )
		{
			return self::update($objVo);
		}
//		$values = array(        $objVo->getId_perfil()
//						, $objVo->getNome()
//						, $objVo->getLogin()
//						, $objVo->getSenha()
//						);
//		return self::executeSql("insert into usuario(
//								 id_perfil
//								,nome
//								,login
//								,senha
//								,cancelado
//								) values (?,?,?,?,'N')", $values );
	
                $values = array(         $objVo->getNome()
						, $objVo->getLogin()
						, $objVo->getSenha()
						);
                return self::executeSql("insert into tb_usuario(
								nome
								,login
								,senha
								) values (?,?,?)", $values );
                
                
                }
	//--------------------------------------------------------------------------------
	public static function delete( $id )
	{
		$values = array($id);
		return self::executeSql("update tb_usuario set cancelado = 'S' where id = ?",$values);
	}
	//--------------------------------------------------------------------------------
	public static function select( $id )
	{
//		$values = array($id);
//		return self::executeSql('select
//								 id_usuario
//								,id_perfil
//								,nome
//								,login
//								,senha
//								,cancelado
//								from usuario where id_usuario = ?', $values );
	
          
          $values = array($id);
		return self::executeSql('select
								 id
								,nome
								,login
								,senha
								from tb_usuario where id = ?', $values );
          
        }
	//--------------------------------------------------------------------------------
	public static function selectAll( $orderBy=null, $where=null )
	{
//		return self::executeSql('select
//								 id_usuario
//								,id_perfil
//								,nome
//								,login
//								,senha
//								,cancelado
//								from usuario'.
//		( ($where)? ' where '.$where:'').
//		( ($orderBy) ? ' order by '.$orderBy:''));
	
          
          
          return self::executeSql('select
								 id
								,nome
								,login
								,senha
								from tb_usuario'.
		( ($where)? ' where '.$where:'').
		( ($orderBy) ? ' order by '.$orderBy:''));
          
          
        }
	//--------------------------------------------------------------------------------
	public static function update ( UsuarioVO $objVo )
	{
//		$values = array( $objVo->getId_perfil()
//						,$objVo->getNome()
//						,$objVo->getLogin()
//						,$objVo->getSenha()
//						,'N'
//						,$objVo->getId() );
//		return self::executeSql('update usuario set
//								 id_perfil = ?
//								,nome = ?
//								,login = ?
//								,senha = ?
//								,cancelado = ?
//								where id = ?',$values);
	
          
          if ($objVo->getSenha() != md5('') ) {  
            
          $values = array( $objVo->getNome()
						,$objVo->getLogin()
						,$objVo->getSenha()
						,$objVo->getId() );
          
                return self::executeSql('update tb_usuario set
								nome = ?
								,login = ?
								,senha = ?
								where id = ?',$values);
                
        }
        
        else
        {
         $values = array( $objVo->getNome()
						,$objVo->getLogin()
						,$objVo->getId() );
          
                return self::executeSql('update tb_usuario set
								nome = ?
								,login = ?
								where id = ?',$values);   
        }
        }
        
	//--------------------------------------------------------------------------------
	function validar($login=null,$senha=null)
	{
		// verificar se a tabela está vazia e criar o usuário administrador
		$sql = "select count(*) as qtd from tb_usuario";
		$dados = self::executeSql($sql);
		if( $dados['QTD'][0] == 0 )
		{
			$vo = new UsuarioVO();
			$vo->setNome('Administrador');
			$vo->setLogin('admin');
			$vo->setSenha('admin');
			self::insert($vo);
		}
		// validar. Como a senha deve ser encriptada com md5, vou utilizar a o objeto VO da tabela que fará esta tarefa;
		$vo = new UsuarioVO();
		$vo->setLogin($login);
		$vo->setSenha($senha);
		$parametros = array($vo->getLogin(),$vo->getSenha());
		$res = self::executeSql("select * from tb_usuario where login=? and senha=?",$parametros);
		return $res;
	}

	function selecionarUsuarios($nome=null)
	{
		if( !is_null( $nome ) )
		{
//			return self::executeSql("select u.*, p.perfil from usuario u
//			left outer join perfil p on p.id_perfil = u.id_perfil
//			where u.nome like '%{$nome}%'");

                  return self::executeSql("select u.* from tb_usuario u
			where u.nome like '%{$nome}%'");
                  
                  
                }
	}
}
?>