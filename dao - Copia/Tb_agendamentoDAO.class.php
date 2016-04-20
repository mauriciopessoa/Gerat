<?php

class Tb_agendamentoDAO extends TPDOConnection
{

    public function tb_agendamentoDAO()
    {
        
    }

    //--------------------------------------------------------------------------------
    public function insert(Tb_agendamentoVO $objVo)
    {
        if ($objVo->getId())
        {
            return self::update($objVo);
        }
        $values = array($objVo->getData_cadastro()
            , $objVo->getData_cirurgia()
            , $objVo->getHora_inicio()
            , $objVo->getHora_fim()
            , $objVo->getAtendimento()
            , $objVo->getNome_paciente()
            , $objVo->getIdade()
            , $objVo->getContato()
            , $objVo->getLeito()
            , $objVo->getAgendada_mv()
            , $objVo->getCancelada()
            , $objVo->getMotivo_cancelamento_cirurgia()
            , $objVo->getCod_cirurgia_principal()
            , $objVo->getDesc_cirurgia_principal()
            , $objVo->getData_autorizacao_cirurgia()
            , $objVo->getOutras_cirurgias()
            , $objVo->getCod_convenio()
            , $objVo->getNome_convenio()
            , $objVo->getCod_cirurgiao_principal()
            , $objVo->getNome_cirurgiao_principal()
            , $objVo->getCod_especialidade()
            , $objVo->getDesc_especialidade()
            , $objVo->getRx()
            , $objVo->getSangue()
            , $objVo->getLab()
            , $objVo->getUti()
            , $objVo->getMaterial()
            , $objVo->getData_autorizacao_material()
            , $objVo->getObs()
            , $objVo->getOperador()
        );
        return self::executeSql('insert into agendamento( 
data_cadastro, data_cirurgia,hora_inicio,hora_fim,atendimento,              
nome_paciente,idade,contato,leito,agendada_mv,cancelada,motivo_cancelamento_cirurgia,                
cod_cirurgia_principal,desc_cirurgia_principal,data_autorizacao_cirurgia,outras_cirurgias,         
cod_convenio,nome_convenio,cod_cirurgiao_principal,nome_cirurgiao_principal, 
cod_especialidade,desc_especialidade,rx,sangue,lab,uti,material,                 
data_autorizacao_material,obs,operador) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $values);
    }

    //--------------------------------------------------------------------------------
    public function delete($id)
    {
        $values = array($id);
        //return self::executeSql('delete from agendamento where id = ?',$values);
        return self::executeSql("update agendamento set cancelada = 'S' where id = ?", $values);
    }

    //--------------------------------------------------------------------------------
    public function select($id)
    {
        $values = array($id);
//		return self::executeSql('select
//								 id
//								,nome
//								,login
//								,senha
//								from tb_agendamento where id = ?', $values );



        return self::executeSql('select	* from agendamento where id = ?', $values);
    }

    //--------------------------------------------------------------------------------
    public function selectAll($orderBy = null, $where = null)
    {
        return self::executeSql('select
								 id
								,nome
								,login
								,senha
								from tb_agendamento' .
                ( ($where) ? ' where ' . $where : '') .
                ( ($orderBy) ? ' order by ' . $orderBy : ''));
    }

    //--------------------------------------------------------------------------------
    public function update(Tb_agendamentoVO $objVo)
    {
        $values = array(
            $objVo->getData_cadastro()
            , $objVo->getData_cirurgia()
            , $objVo->getHora_inicio()
            , $objVo->getHora_fim()
            , $objVo->getAtendimento()
            , $objVo->getNome_paciente()
            , $objVo->getIdade()
            , $objVo->getContato()
            , $objVo->getLeito()
            , $objVo->getAgendada_mv()
            , $objVo->getCancelada()
            , $objVo->getMotivo_cancelamento_cirurgia()
            , $objVo->getCod_cirurgia_principal()
            , $objVo->getDesc_cirurgia_principal()
            , $objVo->getData_autorizacao_cirurgia()
            , $objVo->getOutras_cirurgias()
            , $objVo->getCod_convenio()
            , $objVo->getNome_convenio()
            , $objVo->getCod_cirurgiao_principal()
            , $objVo->getNome_cirurgiao_principal()
            , $objVo->getCod_especialidade()
            , $objVo->getDesc_especialidade()
            , $objVo->getRx()
            , $objVo->getSangue()
            , $objVo->getLab()
            , $objVo->getUti()
            , $objVo->getMaterial()
            , $objVo->getData_autorizacao_material()
            , $objVo->getObs()
            , $objVo->getOperador()
            , $objVo->getId()
        );






        return self::executeSql('update agendamento set
                  
data_cadastro = ?, data_cirurgia = ?,hora_inicio = ?,hora_fim = ?,atendimento = ?,              
nome_paciente = ?,idade = ?,contato = ?,leito = ?,agendada_mv = ?,cancelada = ?,motivo_cancelamento_cirurgia = ?,                
cod_cirurgia_principal = ?,desc_cirurgia_principal = ?,data_autorizacao_cirurgia = ?,outras_cirurgias = ?,         
cod_convenio = ?,nome_convenio = ?,cod_cirurgiao_principal = ?,nome_cirurgiao_principal = ?, 
cod_especialidade = ?,desc_especialidade = ?,rx = ?,sangue = ?,lab = ?,uti = ?,material = ?,                 
data_autorizacao_material = ?,obs = ?, operador = ?	where id = ?', $values);
    }

    //--------------------------------------------------------------------------------
    function validar($login = null, $senha = null)
    {
        // verificar se a tabela está vazia
        $sql = "select count(*) as qtd from tb_agendamento";
        $dados = self::executeSql($sql);
        if ($dados['QTD'][0] == 0)
        {
            $vo = new Tb_agendamentoVO();
            $vo->setNome('Maurício');
            $vo->setLogin('mauricio');
            $vo->setSenha('amper');
            self::insert($vo);
        }
        // validar. Como a senha deve ser encriptada com md5, vou utilizar a o objeto VO da tabela que fará esta tarefa;
        $vo = new Tb_agendamentoVO();
        $vo->setLogin($login);
        $vo->setSenha($senha);
        $parametros = array($vo->getLogin(), $vo->getSenha());
        $res = self::executeSql("select * from tb_agendamento where login=? and senha=?", $parametros);
        return $res;
    }

    function selecionarCirurgias($nome = null)
    {
        if (!is_null($nome))
        {
            return self::executeSql("select * from agendamento
			where nome_paciente like '%{$nome}%'");
        }
    }

}

?>