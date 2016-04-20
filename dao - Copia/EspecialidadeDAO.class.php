<?php
class EspecialidadeDAO extends TPDOConnection
{
    public function especialidadeDAO()
    {
    }

    //--------------------------------------------------------------------------------
    public static function insert( PerfilVO $objVo )
    {
        if ( $objVo->getId_perfil() )
        {
            return self::update( $objVo );
        }
        $values = array( $objVo->getPerfil(), $objVo->getCancelado() );
        return self::executeSql( 'insert into perfil(
								 perfil, cancelado
								) values (?,?)', $values );
    }

    //--------------------------------------------------------------------------------
    public static function delete( $id )
    {
        $values = array( $id );
        return self::executeSql( 'delete from perfil where id_perfil = ?', $values );
    }

    //--------------------------------------------------------------------------------
    public static function select( $id )
    {
        $values = array( $id );
        return self::executeSql( 'select
								 id_perfil
								,perfil
								,cancelado
								from perfil where id_perfil = ?', $values );
    }

    //--------------------------------------------------------------------------------
    public static function selectAll( $orderBy = null, $where = null )
    {
        return self::executeSql( 'select
								 cod_especialidade
								,desc_especialidade
								from especialidade' . ( ( $where ) ? ' where ' . $where : '' )
            . ( ( $orderBy ) ? ' order by ' . $orderBy : '' ) );
    }

    //--------------------------------------------------------------------------------
    public static function update( PerfilVO $objVo )
    {
        $values = array( $objVo->getPerfil(), $objVo->getCancelado(), $objVo->getId_perfil() );
        return self::executeSql( 'update perfil set
								 perfil = ?
								 ,cancelado = ?
								where id_perfil = ?', $values );
    }

    //--------------------------------------------------------------------------------
    public static function cancelar( $id_perfil = null )
    {
        self::executeSql( "update perfil set cancelado = ? where id_perfil = ?", array( "S", $id_perfil ));
    }
}
?>