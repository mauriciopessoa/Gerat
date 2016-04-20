<?php
$frm = new TForm('Definição de Acesso do Perfil');
$frm->addSelectField('id_perfil','Perfil:',true,PerfilDAO::selectAll('PERFIL'),null,null,null,null,null,null,'-- selecione --','')->addEvent('onChange','atualizar_gride()');
$frm->addHtmlField('html_gride','');
$frm->show();
?>
<script>
function atualizar_gride()
{
	fwGetGrid('seguranca/cad_perfil_acesso/action/criar_gride.php','html_gride',{"id_perfil":""},true);
}
</script>
