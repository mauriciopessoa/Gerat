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

//error_reporting(E_ALL);
$frm = new TForm('RELAT�RIO: Destino do material coletado');

$frm->setWidth(700);
$frm->setHeight(400);

$frm->setAutoSize(true);

//N�o quebra o rotulo em linhas. Mantem o campo perto do rotulo
$frm->setNoWrap(true);

//$frm->enableOnlineDoc(true); // false = permitir edi��o

// variavel que seta o tamanho do grupo para ser usada abaixo
$largura_grupo = 650;

//Cria os campos do formulario

$frm->addHiddenField('num_pessoa_instituicao');

//Grupo 1: Pergunta
$frm->addGroupField('gp_pergunta','O destino do material foi a pr�pria institui��o vinculada?', null, $largura_grupo)->setColumns(10);

    $frm->addRadioField('flg_propria_instituicao', '',true,'S=SIM,N=N�o',null,false,null,2,null,null,null,false)->setCss('font-size','11');

$frm->closeGroup();

//Grupo 2: Busca de unidades cadastradas
$frm->addGroupField('gp_cadastrada','Institui��o cadastrada no SISBio', null, $largura_grupo);

    $frm->addTextField('cpf_cnpj_num_pessoa','N� do CNPJ da institui��o:',14,true,null,null,true,"Informe o n�mero do CNPJ da institui��o e click em localizar");
    $frm->addButton('Localizar'
        , null // a��o associada ao arquivo com mesmo nome.php, na pasta action
        , 'btnLocalizar'
        , 'localizarInstituicao()' // funcao
        , null
        , false // nova linha
        , false // nao criar o botao no rodape
    );
    $frm->addTextField('nom_instituicao','Nome da institui��o:',60,true,null,null,true);
    $frm->addTextField('nom_sigla','Sigla:',5,false,null,null,true);

$frm->closeGroup();

//Grupo 3: Cadastro de institui��es
$frm->addGroupField('gp_instituicao','Cadastro da institui��o', null, $largura_grupo);

    $frm->addTextField('nom_destino','Nome da institui��o:',60,true,null,null,true);
    $frm->addTextField('nom_departamento','Departamento:',60,false,null,null,true);
    $frm->addTextField('end_destino','Endere�o:',60,true,null,null,true);
    $frm->addSelectField('cod_pais','Pa�s:',true,null,null,null,null,null,null,null,'-- Selecione --');
    $frm->addSelectField('cod_uf','Estado:');
    $frm->addSelectField('cod_municipio','Munic�pio:');
    $frm->addTextField('nom_cidade_estrangeira','Cidade:',30,true,null,null,true);
    $frm->addTextField('nom_estado_provincia','Estado:',30,true,null,null,true);
    $frm->addTextField('des_bairro','Bairro:',30,true,null,null,true);
    $frm->addCepField('num_cep','CEP:');

$frm->closeGroup();

//Grupo 4: Tipo de institui��o
$frm->addGroupField('gp_tipo','Tipo da institui��o para onde o material foi destinado', null, $largura_grupo);

    // o Pacote abaixo retorna a descricao do tipo de solicitacao, concatenada com o campo HELP
    $erro = recuperarPacote('PESQUISA.PKE_CAD_PRJ_LOCAL_DESTINO.SEL_TIPO_DESTINO', $bvars, $res);
    if (!$erro) {
        /// Gerando um array com todas as opcoes de marcar que irao formar o campo RADIO
        foreach ($res['COD_TIPO_DESTINO'] as $k_array => $v_array) {
            $opcoes_marcar[$v_array] = $res['DES_TIPO_DESTINO'][$k_array];
        }
    }

    $frm->addRadioField('cod_tipo_destino', '',true,$opcoes_marcar,null,false,null,3,null,null,null,false);

    $frm->addTextField('nom_local_destino','Nome da cole��o:',50,true,null,null,true);
    $frm->addTextField('des_complementar','Nome do curador:',50,true,null,null,true);
    $frm->addTextField('des_tipo_destino_comp','Descri��o:',100,false,50,null,true);


$frm->closeGroup();

$frm->addHtmlField('campo_gride_destino');


//preenchimento dos selects (combos)
$erro = recuperarPacote('PESQUISA.PKE_CAD_PRJ_LOCAL_DESTINO.SEL_PAIS', $bvars, $res_pais);
$frm->setOptionsSelect('cod_pais', $res_pais);//, 'COD_PAIS', 'NOM_PAIS');

$frm->combinarSelects('cod_uf' // select pai
        , 'cod_municipio' /// select filho
        , 'PESQUISA.PK_GERAL.SEL_MUNICIPIO_UF'
        , 'COD_UF' // coluna filtro
        , 'COD_MUNICIPIO'  // coluna codigo
        , 'NOM_MUNICIPIO'  // coluna descricao
);

$frm->addButton('Gravar'
        , null // a��o associada ao arquivo com mesmo nome.php, na pasta action
        , 'btnSalvarUnidade'
        , 'salvarUnidade()' // funcao
        , null
        , true // nova linha
        , false // nao criar o botao no rodape
);

$frm->addButton('Novo'
        , null // a��o associada ao arquivo com mesmo nome.php, na pasta action
        , 'btnNovoArquivo'
        , 'novoArquivo()' // funcao
        , null
        , false // nova linha
        , false // nao criar o botao no rodape
);

//$frm->addHtmlField('campo_gride_arquivo');

// processando as a��es PHP dos botoes
$frm->processAction();

$frm->setFieldEvent('flg_propria_instituicao', 'onChange', 'esconderCamposCadastroInstituicao()');
$frm->setFieldEvent('cod_tipo_destino', 'onChange', 'tipoInstituicao()');

$formDinAcao = $_POST['formDinBotao'] . $_POST['formDinAcao'];

// preencher o campo seq_relato_arquivo_tipo
//$frm->setOptionsSelect('tip_documento','PESQUISA.PK_RELATO_ARQUIVO_TIPO.SEL_GRIDE',
  //                     'DES_RELATO_ARQUIVO_TIPO','SEQ_RELATO_ARQUIVO_TIPO');

// adicionar um arquivo Java Script manualmente
// O arquivo abaixo tem funcoes extras que n�o est�o contempladas no FormDin
$frm->addJsFile('base_extra/funcoes.js');

$frm->addJavascript('getGrideDestino();');

//menu slide
include 'modulos/menu/menu_slide.php';

//$frm->setAction('Salvar,Novo');

$frm->show();
?>

