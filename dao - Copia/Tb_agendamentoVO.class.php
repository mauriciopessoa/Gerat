<?php

class Tb_agendamentoVO
{

    private $id = null;
    private $data_cadastro = null;
    private $data_cirurgia = null;
    private $hora_inicio = null;
    private $hora_fim = null;
    private $atendimento = null;
    private $nome_paciente = null;
    private $idade = null;
    private $contato = null;
    private $leito = null;
    private $agendada_mv = null;
    private $cancelada = null;
    private $motivo_cancelamento_cirurgia = null;
    private $cod_cirurgia_principal = null;
    private $desc_cirurgia_principal = null;
    private $data_autorizacao_cirurgia = null;
    private $outras_cirurgias = null;
    private $cod_convenio = null;
    private $nome_convenio = null;
    private $cod_cirurgiao_principal = null;
    private $nome_cirurgiao_principal = null;
    private $cod_especialidade = null;
    private $desc_especialidade = null;
    private $rx = null;
    private $sangue = null;
    private $lab = null;
    private $uti = null;
    private $material = null;
    private $data_autorizacao_material = null;
    private $obs = null;
    private $operador = null;

    public function Tb_agendamentoVO($id = null, $data_cadastro = null, $data_cirurgia = null, $hora_inicio = null, $hora_fim = null, $atendimento = null, $nome_paciente = null, $idade = null, $contato = null, $leito = null, $agendada_mv = null, $cancelada = null, $motivo_cancelamento_cirurgia = null, $cod_cirurgia_principal = null, $desc_cirurgia_principal = null, $data_autorizacao_cirurgia = null, $outras_cirurgias = null, $cod_convenio = null, $nome_convenio = null, $cod_cirurgiao_principal = null, $nome_cirurgiao_principal = null, $cod_especialidade = null, $desc_especialidade = null, $rx = null, $sangue = null, $lab = null, $uti = null, $material = null, $data_autorizacao_material = null, $obs = null, $operador = null)
    {

        $this->setId($id);
        $this->setData_cadastro($data_cadastro);
        $this->setData_cirurgia($data_cirurgia);
        $this->setHora_inicio($hora_inicio);
        $this->setHora_fim($hora_fim);
        $this->setAtendimento($atendimento);
        $this->setNome_paciente($nome_paciente);
        $this->setIdade($idade);
        $this->setContato($contato);
        $this->setLeito($leito);
        $this->setAgendada_mv($agendada_mv);
        $this->setCancelada($cancelada);
        $this->setMotivo_cancelamento_cirurgia($motivo_cancelamento_cirurgia);
        $this->setCod_cirurgia_principal($cod_cirurgia_principal);
        $this->setDesc_cirurgia_principal($desc_cirurgia_principal);
        $this->setData_autorizacao_cirurgia($data_autorizacao_cirurgia);
        $this->setOutras_cirurgias($outras_cirurgias);
        $this->setCod_convenio($cod_convenio);
        $this->setNome_convenio($nome_convenio);
        $this->setCod_cirurgiao_principal($cod_cirurgiao_principal);
        $this->setNome_cirurgiao_principal($nome_cirurgiao_principal);
        $this->setCod_especialidade($cod_especialidade);
        $this->setDesc_especialidade($desc_especialidade);
        $this->setRx($rx);
        $this->setSangue($sangue);
        $this->setLab($lab);
        $this->setUti($uti);
        $this->setMaterial($material);
        $this->setData_autorizacao_material($data_autorizacao_material);
        $this->setObs($obs);
        $this->setOperador($operador);
    }

    //--------------------------------------------------------------------------------
    function setId($strNewValue = null)
    {
        $this->id = $strNewValue;
    }

    function getId()
    {
        return $this->id;
    }

    //--------------------------------------------------------------------------------
    function setData_cadastro($strNewValue = null)
    {
        $this->data_cadastro = $strNewValue;
    }

    function getData_cadastro()
    {
        return $this->data_cadastro;
    }

    //--------------------------------------------------------------------------------
    function setData_cirurgia($strNewValue = null)
    {
        $this->data_cirurgia = $strNewValue;
    }

    function getData_cirurgia()
    {
        return $this->data_cirurgia;
    }

    //--------------------------------------------------------------------------------
    function setHora_inicio($strNewValue = null)
    {
        $this->hora_inicio = $strNewValue;
    }

    function getHora_inicio()
    {
        return $this->hora_inicio;
    }

    //--------------------------------------------------------------------------------
    function setHora_fim($strNewValue = null)
    {
        $this->hora_fim = $strNewValue;
    }

    function getHora_fim()
    {
        return $this->hora_fim;
    }

    //--------------------------------------------------------------------------------
    function setAtendimento($strNewValue = null)
    {
        $this->atendimento = $strNewValue;
    }

    function getAtendimento()
    {
        return $this->atendimento;
    }

    //--------------------------------------------------------------------------------
    function setNome_paciente($strNewValue = null)
    {
        $this->nome_paciente = strtoupper($strNewValue);
    }

    function getNome_paciente()
    {
        return $this->nome_paciente;
    }

    //--------------------------------------------------------------------------------
    function setIdade($strNewValue = null)
    {
        $this->idade = $strNewValue;
    }

    function getIdade()
    {
        return $this->idade;
    }

    //--------------------------------------------------------------------------------
    function setContato($strNewValue = null)
    {
        $this->contato = $strNewValue;
    }

    function getContato()
    {
        return $this->contato;
    }

    //--------------------------------------------------------------------------------
    function setLeito($strNewValue = null)
    {
        $this->leito = $strNewValue;
    }

    function getLeito()
    {
        return $this->leito;
    }

    //--------------------------------------------------------------------------------
    function setAgendada_mv($strNewValue = null)
    {
        $this->agendada_mv = $strNewValue;
    }

    function getAgendada_mv()
    {
        return $this->agendada_mv;
    }

    //--------------------------------------------------------------------------------
    function setCancelada($strNewValue = null)
    {
        $this->cancelada = $strNewValue;
    }

    function getCancelada()
    {
        return $this->cancelada;
    }

    //--------------------------------------------------------------------------------
    function setMotivo_cancelamento_cirurgia($strNewValue = null)
    {
        $this->motivo_cancelamento_cirurgia = $strNewValue;
    }

    function getMotivo_cancelamento_cirurgia()
    {
        return $this->motivo_cancelamento_cirurgia;
    }

    //--------------------------------------------------------------------------------
    function setCod_cirurgia_principal($strNewValue = null)
    {
        $this->cod_cirurgia_principal = $strNewValue;
    }

    function getCod_cirurgia_principal()
    {
        return $this->cod_cirurgia_principal;
    }

    //--------------------------------------------------------------------------------
    function setDesc_cirurgia_principal($strNewValue = null)
    {
        $this->desc_cirurgia_principal = $strNewValue;
    }

    function getDesc_cirurgia_principal()
    {
        return $this->desc_cirurgia_principal;
    }

    //--------------------------------------------------------------------------------
    function setData_autorizacao_cirurgia($strNewValue = null)
    {
        $this->data_autorizacao_cirurgia = $strNewValue;
    }

    function getData_autorizacao_cirurgia()
    {
        return $this->data_autorizacao_cirurgia;
    }

    //--------------------------------------------------------------------------------
    function setOutras_cirurgias($strNewValue = null)
    {
        $this->outras_cirurgias = $strNewValue;
    }

    function getOutras_cirurgias()
    {
        return $this->outras_cirurgias;
    }

    //--------------------------------------------------------------------------------
    function setCod_convenio($strNewValue = null)
    {
        $this->cod_convenio = $strNewValue;
    }

    function getCod_convenio()
    {
        return $this->cod_convenio;
    }

    //--------------------------------------------------------------------------------
    function setNome_convenio($strNewValue = null)
    {
        $this->nome_convenio = $strNewValue;
    }

    function getNome_convenio()
    {
        return $this->nome_convenio;
    }

    //--------------------------------------------------------------------------------
    function setCod_cirurgiao_principal($strNewValue = null)
    {
        $this->cod_cirurgiao_principal = $strNewValue;
    }

    function getCod_cirurgiao_principal()
    {
        return $this->cod_cirurgiao_principal;
    }

    //--------------------------------------------------------------------------------
    function setNome_cirurgiao_principal($strNewValue = null)
    {
        $this->nome_cirurgiao_principal = $strNewValue;
    }

    function getNome_cirurgiao_principal()
    {
        return $this->nome_cirurgiao_principal;
    }

    //--------------------------------------------------------------------------------
    function setCod_especialidade($strNewValue = null)
    {
        $this->cod_especialidade = $strNewValue;
    }

    function getCod_especialidade()
    {
        return $this->cod_especialidade;
    }

    //--------------------------------------------------------------------------------
    function setDesc_especialidade($strNewValue = null)
    {
        $this->desc_especialidade = $strNewValue;
    }

    function getDesc_especialidade()
    {
        return $this->desc_especialidade;
    }

    //--------------------------------------------------------------------------------
    function setRx($strNewValue = null)
    {
        $this->rx = $strNewValue;
    }

    function getRx()
    {
        return $this->rx;
    }

    //--------------------------------------------------------------------------------
    function setSangue($strNewValue = null)
    {
        $this->sangue = $strNewValue;
    }

    function getSangue()
    {
        return $this->sangue;
    }

    //--------------------------------------------------------------------------------
    function setLab($strNewValue = null)
    {
        $this->lab = $strNewValue;
    }

    function getLab()
    {
        return $this->lab;
    }

    //--------------------------------------------------------------------------------
    function setUti($strNewValue = null)
    {
        $this->uti = $strNewValue;
    }

    function getUti()
    {
        return $this->uti;
    }

    //--------------------------------------------------------------------------------
    function setMaterial($strNewValue = null)
    {
        $this->material = $strNewValue;
    }

    function getMaterial()
    {
        return $this->material;
    }

    //--------------------------------------------------------------------------------
    function setData_autorizacao_material($strNewValue = null)
    {
        $this->data_autorizacao_material = $strNewValue;
    }

    function getData_autorizacao_material()
    {
        return $this->data_autorizacao_material;
    }

    //--------------------------------------------------------------------------------
    function setObs($strNewValue = null)
    {
        $this->obs = $strNewValue;
    }

    function getObs()
    {
        return $this->obs;
    }

    //--------------------------------------------------------------------------------
    function setOperador($strNewValue = null)
    {
        //	$this->operador = $strNewValue;

        $strNewValue = $_SESSION[APLICATIVO]['usuario']['id'];

        $this->operador = $strNewValue;
    }

    function getOperador()
    {
        return $this->operador;
    }

}

?>