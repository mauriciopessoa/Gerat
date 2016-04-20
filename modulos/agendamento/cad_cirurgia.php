<?php
define('REQUIRED_FIELD_MARK', '*'); // alterar a identificação dos campos obrigatórios para * vermelho

$frm = new TForm('Cadastro de Cirurgias', 530, 1000);

$frm->addHiddenField('id');


//$frm->setColumns(100); // define a primeira coluna do formulário para 100 px
// define a largura das colunas verticais do formulario para alinhamento dos campos 
//$frm->setColumns(array(100,100,100)); 
//$frm->setColumns(array(100,100)); 

/* * ***************
 *  PARAM ORACLE *
 * *************** */


$tns = "  
(DESCRIPTION = 
    (ADDRESS_LIST = 
      (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.2.202)(PORT = 1521)) 
    ) 
    (CONNECT_DATA = 
      (SERVICE_NAME = prdmv) 
    ) 
  ) 
       ";
$db_username = "integrawtt";
$db_password = "integrawtt";
$conn = OCILogon($db_username, $db_password, $tns);

/* * ***************
 * PARAM  ORACLE *
 * *************** */


$pc = $frm->addPageControl('pc', null, null, null, 'abaClick()');
$page = $pc->addPage('Cadastro', true, true, 'abaCadastro');
$page->setColorHighlightBackground('#FDFCD7'); // cor de fundo do campo que possuir dica ( hint )
//$frm->addDateField('data_cadastro', 'Data Cadastro:', true, false, date("d/m/Y")); //->addEvent('onblur','sai(this)');

$frm->addTextField('data_cadastro', 'Data Cadastro:', 10, true, 10, date("d/m/Y"), false); //->addEvent('onblur','sai(this)');

$frm->addDateField('data_cirurgia', 'Data Cirurgia:', false, false); //->addEvent('onblur','sai(this)');
$frm->addTimeField('hora_inicio', 'hora Início:', false, null, null, null, false);
$frm->addTimeField('hora_fim', 'hora Fim:', false, null, null, null, false);
$frm->addNumberField('atendimento', 'Atendimento:   ', 14, false, 0, true, null, 0, 0, null, null, false, false); //->setEnabled(false);;
$frm->addTextField('nome_paciente', 'Nome do Paciente:', 100, true, 50, null, false, 'Informe o nome completo do paciente', null, null)->setCss('text-transform', 'uppercase');
$frm->addNumberField('idade', 'Idade:', 3, false, 0, false, null, 0, 0, null, null, false, false);
$frm->addTextField('contato', 'Contato:', 30)->setCss('text-transform', 'uppercase');
$frm->addTextField('leito', 'Leito(se internado):', 6, false, 6, null, false, null, null, null);
$frm->addSelectField('agendada_mv', 'Agendada MV?:', false, 'S=Sim,N=Não', false, null, null, null, null, null, null, 'N');
$frm->addSelectField('cancelada', 'Cancelada?:', false, 'S=Sim,N=Não', false, null, null, null, null, null, null, 'N');
$frm->addSelectField('motivo_cancelamento_cirurgia', 'Motivo:', false, 'M=A Pedido Médico,P=A Pedido do Paciente,N=Não Autorizada', false, null, null, null, null, null, 'Selecione');

//        $frm->addTextField('desc_cirurgia_principal','Cirurgia Principal:',50,true,50,null,true,null,null,null);


/* * ***************
 *    CIRURGIA     *
 * *************** */

$consulta = "select CD_CIRURGIA cod_cirurgia_principal,DS_CIRURGIA desc_cirurgia_principal "
    . "from DBAMV.CIRURGIA "
    . "ORDER BY DS_CIRURGIA";
$resultado = OCIParse($conn, $consulta);
if (OCIExecute($resultado))
{
    oci_fetch_all($resultado, $res);
    $frm->addSelectField('cod_cirurgia_principal', 'Cirurgia Principal:', true, $res, true, null, null, null, null, 400, 'Selecione uma cirurgia')->addEvent('onchange', 'pegaNomeCirurgia(this)');
    $frm->addHiddenField('desc_cirurgia_principal');
}
else
{
    echo "Aconteceu um erro no resultado da consulta de Cirurgia no MV!";
}

$frm->addDateField('data_autorizacao_cirurgia', 'Data Autorização:', null, false);

/* * ***************
 *   CIRURGIÃO   *
 * *************** */

$consulta = "select CD_PRESTADOR cod_cirurgiao_principal,NM_PRESTADOR nome_cirurgiao_principal "
    . "from DBAMV.PRESTADOR "
//    . "where CD_TIP_PRESTA = 8 AND SN_CIRURGIAO = 'S' AND TP_SITUACAO = 'A' "
    . "where CD_TIP_PRESTA = 8 AND TP_SITUACAO = 'A' "
    . "ORDER BY NM_PRESTADOR";
$resultado = OCIParse($conn, $consulta);
if (OCIExecute($resultado))
{
    oci_fetch_all($resultado, $res);
    $frm->addSelectField('cod_cirurgiao_principal', 'Cirurgião Principal:', true, $res, true, null, null, null, null, null, 'Selecione uma cirurgião')->addEvent('onchange', 'pegaNomeCirurgiao(this)');
    $frm->addHiddenField('nome_cirurgiao_principal');
}
else
{
    echo "Aconteceu um erro no resultado da consulta de Cirurião no MV!";
}


/* * ***************
 * ESPECIALIDADE   *
 * *****************/

$consulta = "select cd_especialid cod_especialidade, ds_especialid desc_especialidade "
    . "from DBAMV.ESPECIALID "
    . "ORDER BY DS_ESPECIALID";
$resultado = OCIParse($conn, $consulta);
if (OCIExecute($resultado))
{
    oci_fetch_all($resultado, $res);
    $frm->addSelectField('cod_especialidade', 'Especialidade:', true, $res, false, null, null, null, null, null, 'Selecione uma especialidade')->addEvent('onchange', 'pegaNomeEspecialidade(this)');
    $frm->addHiddenField('desc_especialidade');
}
else
{
    echo "Aconteceu um erro no resultado da consulta de Especialidade no MV!";
}


$frm->addMemoField('outras_cirurgias', 'Outras Cirurgias:', 2000, false, null, null, null, null, false)->setCss('text-transform', 'uppercase');


/* * ***************
 *    CONVENIO     *
 * *****************/

$consulta = "select CD_CONVENIO cod_convenio,NM_CONVENIO nome_convenio "
    . "from DBAMV.CONVENIO "
    . "ORDER BY NM_CONVENIO ";
$resultado = OCIParse($conn, $consulta);
if (OCIExecute($resultado))
{
    oci_fetch_all($resultado, $resConv);

    $frm->addSelectField('cod_convenio', 'Convênio:', true, $resConv, true, null, null, null, null, 250, 'Selecione um convênio', null)->addEvent('onchange', 'pegaNomeConvenio(this)');

    $frm->addHiddenField('nome_convenio');
}
else
{
    echo "Aconteceu um erro no resultado da consulta de Convênio no MV!";
}


$frm->addSelectField('rx', 'Exames Rx?:', true, 'S=Sim,N=Não', false, null, null, null, null, null, ' ');
$frm->addSelectField('lab', 'Exames Laboratório?:', true, 'S=Sim,N=Não', false, null, null, null, null, null, ' ');
$frm->addSelectField('sangue', 'Exames Sangue?:', true, 'S=Sim,N=Não', false, null, null, null, null, null, ' ');
$frm->addSelectField('uti', 'Uti?:', true, 'S=Sim,N=Não', false, null, null, null, null, null, ' ');
$frm->addMemoField('material', 'Material:', 200, true, null, null, null, null, false)->setCss('text-transform', 'uppercase');
$frm->addDateField('data_autorizacao_material', 'Data Autorização Material:', true, false);
$frm->addMemoField('obs', 'Observação:', 2000, false, null, null, null, null, false)->setCss('text-transform', 'uppercase');

$page = $pc->addPage('Pesquisar Cirurgia', false, true, 'abaCirurgias');
$page->setColumns(100); // define a primeira coluna do formulário da aba para 80 px
// o atributo noclear evita que a função fwClearFields limpe o campo
$frm->addTextField('psq_nome_paciente', 'Localizar por Nome:', 40, false)->setAttribute('noclear', 'true')->setTooltip('Pesquisar - Informe o nome ou parte do nome e clique no botão Pesquisar!');
$frm->addButton('Pesquisar', null, 'btnPesquisar', 'atualizarGride()', null, false, false);
$frm->addHtmlField('html_gride');
$frm->closeGroup(); // fim das abas

$frm->processAction();
$frm->addButtonAjax('Salvar', null, 'antesSalvar', 'depoisSalvar', 'salvar', 'Salvando...', 'text', false, null, 'btnSalvar');
$frm->addButton('Novo', null, 'btnNovo', 'novo()');


$frm->show();
?>


<script>


    jQuery("#data_cadastro").attr('readonly', 'true');

    jQuery("#Novo").attr('disabled', 'true');

    function pegaNomeConvenio(e)
    {
        fwAtualizarCampos('nome_convenio', jQuery("#cod_convenio option:selected").text());
        //alert( e.value );
    }

    function pegaNomeCirurgia(e)
    {
        fwAtualizarCampos('desc_cirurgia_principal', jQuery("#cod_cirurgia_principal option:selected").text());
        //alert( e.value );
    }

    function pegaNomeCirurgiao(e)
    {
        fwAtualizarCampos('nome_cirurgiao_principal', jQuery("#cod_cirurgiao_principal option:selected").text());
        //alert( e.value );
    }

    function pegaNomeEspecialidade(e)
    {
        fwAtualizarCampos('desc_especialidade', jQuery("#cod_especialidade option:selected").text());
        //alert( e.value );
    }

    function sai(e)
    {
        alert(jQuery("#data_cadastro").val());
        //alert( e.value );

    }

    function antesSalvar()
    {
        if (!fwValidateFields())
        {
            return false;
        }

        return true;

    }

    function depoisSalvar(res)
    {
        if (res)
        {
            fwAlert(res);
        }
        else
        {
            fwAlert('Dados gravados com SUCESSO!');
            novo();
        }
    }

    function novo()
    {
        fwClearChildFields();
        fwSelecionarAba('abaCadastro');
        fwSetFocus('nome');
    }

    function abaClick(pc, aba, id)
    {
        if (id == 'abaCadastro')
        {

            if (jQuery("#psq_nome_paciente").val() != '')
            {
                atualizarGride();
            }

        }

        if (id == 'abaCirurgias')
        {

            jQuery("#Salvar").attr('disabled', 'disabled');

        }


    }
    function atualizarGride()
    {
        fwGetGrid('agendamento/cad_cirurgia.php', 'html_gride', {"action": "criar_gride", "psq_nome_paciente": ""});
    }
    function grideAlterar(campoChave, valorChave)
    {
        fwAjaxRequest({
            "action": "alterar",
            "dataType": "json",
            "data": {"id": valorChave},
            "callback": function(dados)
            {
                if (dados.message)
                {
                    fwAlert(dados.message);
                    return;
                }
                fwUpdateFieldsJson(dados);
                fwSelecionarAba('abaCadastro');
            }
        });
    }
    function grideCancelar(campoChave, valorChave)
    {
        if (fwConfirm('Deseja cancelar a cirurgia ?',
                function(r) {
                    if (r == true)
                    {
                        fwAjaxRequest({
                            "action": "cancelar",
                            "dataType": "text",
                            "data": {"id": valorChave},
                            "callback": function(res)
                            {
                                if (res)
                                {
                                    fwAlert(res);
                                }
                                atualizarGride();
                            }
                        });
                    }
                })
                )
            ;
    }
</script>