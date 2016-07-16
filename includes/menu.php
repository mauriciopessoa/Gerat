<?php
$menu = new TMenuDhtmlx();
$menu->add(1,0,'Cadastro',null,null,'folderopen16.gif');
$menu->add(11,1,'Faturamento',null,null,'folderopen16.gif');
	$menu->add(12,11,'Cadastro de Cirurgias','agendamento/cad_cirurgia.php','Cadastro de Cirurgias','folderAzulOpen.gif');
	$menu->add(13,1,'Cadastro de Usuários','seguranca/cad_usuario.php','Cadastro de Usuários','folderAzulOpen.gif');
        $menu->add(14,1,'Agenda','agenda/cadastro_agenda.php','Cadastro de Agenda','folderAzulOpen.gif');
        $menu->add(15,1,'Empresa','empresa/cadastro_empresa.php','Cadastro de Empresa','folderAzulOpen.gif');
$menu->add(16,1,'Atendimento',null,null,'folderopen16.gif');
        $menu->add(17,16,'CID','atendimento/cad_cid.php','Cadastro de CID','folderAzulOpen.gif');
        $menu->add(33,16,'Conselho','atendimento/cad_conselho.php','Cadastro de Conselho','folderAzulOpen.gif');
        $menu->add(18,16,'Especialidade','atendimento/cad_especialidade/cad_especialidade.php','Cadastro de Especialidade','folderAzulOpen.gif');
        $menu->add(31,16,'País','atendimento/cad_pais/cad_pais.php','Cadastro de País','folderAzulOpen.gif');
        $menu->add(32,16,'UF','atendimento/cad_uf/cad_uf.php','Cadastro de UF','folderAzulOpen.gif');
$menu->add(19,1,'Financeiro',null,null,'folderopen16.gif');
        $menu->add(20,19,'Bancos','financeiro/cad_banco.php','Cadastro de banco','folderAzulOpen.gif');
        $menu->add(27,19,'Agências','financeiro/agencia/cad_agencia.php','Cadastro de agência','folderAzulOpen.gif');
        $menu->add(28,19,'Contas','financeiro/cad_conta/cad_conta.php','Cadastro de conta','folderAzulOpen.gif');
        $menu->add(29,19,'Cartões','financeiro/cad_cartao/cad_cartao.php','Cadastro de cartão','folderAzulOpen.gif');
         $menu->add(30,19,'Impostos','financeiro/cad_imposto/cad_imposto.php','Cadastro de imposto','folderAzulOpen.gif');
$menu->add(2,0,'Relatórios',null,null,'print16.gif');
	$menu->add(21,2,'Cirurgias x Médicos',null,null,'print16.gif');
	$menu->add(22,2,'Cirurgias x Data de Cadastro',null,null,'print16.gif');
	$menu->add(23,2,'Cirurgias x Data da Cirurgia',null,null,'print16.gif');
        
        $menu->add(24,2,'Cirurgias x Convênio',null,null,'print16.gif');
	$menu->add(25,2,'Cirurgias x Especialidade',null,null,'print16.gif');
	$menu->add(26,2,'Cirurgias Canceladas','relatorios/cirurgias_canceladas.php',null,'print16.gif');
        
$menu->add(3,0,'Gerador DAO/VO','base/includes/gerador_vo_dao.php');
$menu->getXml();


?>