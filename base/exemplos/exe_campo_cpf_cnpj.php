<?php

$frm = new TForm('Exemplo Campo CPF/CNPJ',220,600);

//$frm->addCpfCnpjField('cpf_cnpj1','CPF/CNPJ:',false)->setExampleText('Mensagem Padr�o / Limpar se inconpleto');

$frm->addCpfCnpjField('cpf_cnpj2','CPF/CNPJ:',false,null,true,null,null,null,null,'myCb')->setExampleText('Tratamento no callback');
/**/
$frm->addCpfCnpjField('cpf_cnpj3','CPF/CNPJ:',false,null,true,null,null,'CPF/CNPJ Inv�lido',false)->setExampleText('Mensagem Customizada / Limpar se inconpleto');
$frm->addCpfCnpjField('cpf_cnpj4','CPF/CNPJ:',false,null,true,null,null,'CPF/CNPJ Inv�lido',true)->setExampleText('Mensagem Customizada / N�o limpar se inconpleto');
$frm->addCpfField('cpf'	,'CPF:',false);
$frm->addCnpjField('cnpj','CNPJ:',false);
/**/
$frm->show();
?>
<script>
function myCb(valido,e,event)
{
	if( valido )
	{
		if (e.value != '' )
		{
			fwAlert('SUCESSO!!!! Cpf/Cnpj est� v�lido');
		}
	}
	else
	{
		fwAlert('Oooooops!!! Cpf/Cnpj est� inv�lido');
		e.value='';
	}
}
</script>