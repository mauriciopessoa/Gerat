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

class TSelect extends TOption
{
	private $firstOptionText;
	private $firstOptionValue;

    /**
    * Classe para cria��o de campos do tipo combobox / menu select
    *
    * @param mixed $strName
    * @param mixed $mixOptions
    * @param mixed $strValue
    * @param mixed $boolRequired
    * @param mixed $boolMultiSelect
    * @param mixed $intSize
    * @param mixed $intWidth
    * @param mixed $strFirstOptionText
    * @param mixed $strFirstOptionValue
    * @param mixed $strKeyField
    * @param mixed $strDisplayField
    * @return TEditSelect
    */
    public function __construct($strName,$mixOptions=null,$strValue=null,$boolRequired=null,$boolMultiSelect=null,$intSize=null,$intWidth=null,$strFirstOptionText=null,$strFirstOptionValue=null,$strKeyField=null,$strDisplayField=null)
    {
         parent::__construct($strName,$mixOptions,$strValue,$boolRequired,null,$intWidth,null,null,$boolMultiSelect,'select',$strKeyField,$strDisplayField);
         parent::setSelectSize($intSize);
         $this->setFirstOptionText($strFirstOptionText);
         $this->setFirstOptionValue($strFirstOptionValue);
    }
    public function show($print=true)
    {
    	// adicionar o texto "-- selecione --" como primeira op��o, se o campo n�o for obrigat�rio
    	if(!$this->getMultiSelect() )
    	{
    		if( is_null($this->getFirstOptionText()) && !$this->getRequired() )
    		{
				$this->setFirstOptionText('-- selecione --');
			}
    		if( !$this->getFirstOptionValue() && !$this->getRequired() )
    		{
				$this->setFirstOptionValue(null);
			}
			$arrTemp=array();
			if($this->getFirstOptionText())
			{
				$arrTemp = array($this->getFirstOptionValue()=>$this->getFirstOptionText());
			}
			if(is_array($this->getOptions()) )
			{
				forEach($this->getOptions() as $k=>$v)
				{
					$arrTemp[$k]=$v;
				}
			}
			$this->setOptions($arrTemp);
		}
		return parent::show($print);
	}

	//---------------------------------------------------------------------------------
    public function setFirstOptionText($strNewValue=null)
    {
		$this->firstOptionText = $strNewValue;
		return $this;
    }
	//---------------------------------------------------------------------------------
    public function getFirstOptionText()
    {
		return $this->firstOptionText;
    }
	//---------------------------------------------------------------------------------
	public function setFirstOptionValue($strNewValue=null)
    {
		$this->firstOptionValue = $strNewValue;
		return $this;
    }
	//---------------------------------------------------------------------------------
    public function getFirstOptionValue()
    {
		return $this->firstOptionValue;
    }
    // Retorna o texto da op��o selecionada do combobox
    public function getText($strKeyValue=null)
    {
   		$strKeyValue =  ( is_null( $strKeyValue ) ) ? $this->getValue() : $strKeyValue ;
    	if(!$this->getMultiSelect() )
    	{
			//if( !is_null($this->getValue() ) )
			if( !is_null($strKeyValue ) )
			{
				$aTemp = $this->getOptions();
				return $aTemp[$strKeyValue];
				//return $aTemp[$this->getValue()];
			}
		}
		else
		{
			$result=null;
			if( is_array($strKeyValue))
			{
				$aTemp = $this->getOptions();
				forEach( $strKeyValue as $k )
				{
					$result[] = $aTemp[$k];
				}
			}
			return $result;
		}
    }
}
/*

//$_POST['tip_sexo']='2';
for($i=0;$i<10;$i++)
{
	$arr[$i]= 'Opcao '.$i;
}
// multi
$select = new TEditSelect('tip_sexo',$arr,'8',false,true,5);

// normal
$select2 = new TEditSelect('tip_sexo',$arr,'8',false,false,null,300);

print '<form name="formdin" action="" method="POST">';
$select->setEnabled(false);
$select->show();
$select2->show();
print '<hr>';
print '<input type="submit" value="Gravar">';
print '</form>';
print_r($_POST);
*/
?>