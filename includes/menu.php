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