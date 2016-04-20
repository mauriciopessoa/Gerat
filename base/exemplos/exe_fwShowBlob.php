<?php
/*
 * Formdin Framework
 * Copyright (C) 2012 Minist�rio do Planejamento
 * ----------------------------------------------------------------------------
 * This file is part of Formdin Framework.
 *
 * Formdin Framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License version 3
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License version 3
 * along with this program; if not,  see <http://www.gnu.org/licenses/>
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA  02110-1301, USA.
 * ----------------------------------------------------------------------------
 * Este arquivo � parte do Framework Formdin.
 *
 * O Framework Formdin � um software livre; voc� pode redistribu�-lo e/ou
 * modific�-lo dentro dos termos da GNU LGPL vers�o 3 como publicada pela Funda��o
 * do Software Livre (FSF).
 *
 * Este programa � distribu�do na esperan�a que possa ser �til, mas SEM NENHUMA
 * GARANTIA; sem uma garantia impl�cita de ADEQUA��O a qualquer MERCADO ou
 * APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU/LGPL em portugu�s
 * para maiores detalhes.
 *
 * Voc� deve ter recebido uma c�pia da GNU LGPL vers�o 3, sob o t�tulo
 * "LICENCA.txt", junto com esse programa. Se n�o, acesse <http://www.gnu.org/licenses/>
 * ou escreva para a Funda��o do Software Livre (FSF) Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02111-1301, USA.
 */

$frm = new TForm( 'Cadastro e Exibi��o de LOBS no Banco de Dados' );

$frm->addHiddenField( 'id_blob' ); // coluna chave da tabela

$frm->addHtmlField( 'obs','<center><h3><b>Este exemplo mostra como salvar um arquivo bin�rio no banco de dados e exibi-lo utilizando a fun��o fwShowBlob().<br>Est� utilizando o banco de dados bdApoio.s3db ( SQLite ) e a tabela � a tb_blob.</b></h3></center>' );

/*
// script para a cria��o da tabela no sqlite
CREATE TABLE [tb_blob] (
[id_blob] INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
[nome_arquivo] varchar(200)  NULL,
[conteudo_arquivo] BLOB  NULL
)
*/

// campo para upload do arquivo
$frm->addFileField( 'conteudo_arquivo', 'Anexo:', false, 'jpg,txt,gif,doc,pdf,xls,odt', '2M', 60, null, null,'aoAnexar' );

// grupo para exibir as informa��es do arquivo selecionado
$frm->addGroupField( 'gpDadosArquivo', 'Informa��es do Arquivo' )->setReadOnly(true);
	$frm->addTextField( 'nome_arquivo', 'Nome do Arquivo:', 60, false, 60 );
	$frm->addTextField( 'tamanho_arquivo', 'Tamanho:', 10 );
	$frm->addTextField( 'tipo_arquivo', 'Tipo:', 60 );
$frm->closeGroup();

// criar os bot�es no rodap� do formul�rio
$frm->setAction( 'Salvar,Limpar' );

switch( $acao )
{
    case 'Salvar':
        $vo = new Tb_blobVO();
        $frm->setVo( $vo );
        $vo->setTempName( '../' . $_POST[ 'conteudo_arquivo_temp_name' ] );
        Tb_blobDAO::insert( $vo );

    //------------------------------------------------------------------
    case 'Limpar':
        $frm->clearFields();
        break;

    //--------------------------------------------------------------------
    case 'gdArquivos_excluir':
   		Tb_blobDAO::delete( $frm->get( 'id_blob' ) );
    break;
	//--------------------------------------------------------------------
}

// criar o gride com os arquivos j� anexados
$dados = Tb_blobDAO::selectAll( 'nome_arquivo' );
$g = new TGrid( 'gdArquivos', 'Arquivos Gravados', $dados, null, null, 'ID_BLOB' );
$g->addColumn( 'id_blob', 'C�digo', 100, 'center' );
$g->addColumn( 'nome_arquivo', 'Nome do Arquivo', 3000 );
$g->addColumn( 'imagem', 'Conte�do', 100, 'center' );
$g->setCreateDefaultEditButton( false ); // n�o exibir o bot�o de edi��o no gride
$g->setOnDrawCell( 'configurarCelula' ); // colocar uma imagem com o link para visualizar o conteudo do arquivo na coluna "imagem" do gride

// exibir o gride na tela dentro do campo html
$frm->addHtmlField( 'gride', $g );

// exibir o formul�rio
$frm->show();

// fun��o chamada pela classe TGrid para manipula��o dos dados das celulas
function configurarCelula( $rowNum = null, $cell = null, $objColumn = null, $aData = null, $edit = null )
{
	// se for a coluna imagem, adicionar um bot�o
    if ( $objColumn->getFieldName() == 'imagem' )
    {
        $btn = new TButton( 'btn' . $rowNum, null, null, 'Visualizar(' . $aData[ 'ID_BLOB' ] . ')', null, 'analise.gif', null, 'Visualizar o Arquivo' );
        $cell->add( $btn );
    }
}
?>

<script>
    function Visualizar(id_blob)
        {
        	fwShowBlob('tb_blob', 'conteudo_arquivo', 'nome_arquivo', 'id_blob', id_blob,800,600);
        }

    function aoAnexar(temp, nome, tipo, tamanho)
        {
        //alert( temp+'\n'+file+'\n'+type+'\n'+size);
        jQuery("#nome_arquivo").val(nome);
        jQuery("#tamanho_arquivo").val(tamanho);
        jQuery("#tipo_arquivo").val(tipo);

        if (tamanho > 0)
            {
            fwConfirm('Deseja visualizar o arquivo ' + nome, function(resposta)
                {
                if (resposta == true)
                    {
                    	fwShowTempFile(temp, tipo, nome);
                    }
                });
            }
        }
</script>