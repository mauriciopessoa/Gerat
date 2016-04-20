
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

  /**
 * Campo para edi��o de horas.
 * maskType como hms,hm
 *
 */
class TTime extends TMask
{
	private $maskType;
	private $minValue;
	private $maxValue;
	/**
	 * @param string $name
	 * @param string $value
	 * @param boolean $required
	 * @param string $minValue
	 * @param string $maxValue
	 * @param string $maskType
	 */
	public function __construct($strName,$boolRequired=null,$strValue=null,$strMinValue=null,$strMaxValue=null,$strMaskType=null)
	{
		parent::__construct($strName,$strValue,null,$boolRequired);
		$this->setFieldType('time');
		$this->setMask($strMaskType);
		$this->setMinValue($strMinValue);
		$this->setMaxValue($strMaxValue);
	}
	//-------------------------------------------------------------------------------
	public function show($print=true)
	{
		// n�o colocar a imagem no campo data se ele estiver desabilitado
		if( $this->getEnabled())
		{
			$this->addEvent('onBlur' ,'fwValidarHora(this,this.value,"'.$this->getMaskType().'","'.$this->getMinValue().'","'.$this->getMaxValue().'","Hora inv�lida")');
		}
		return parent::show($print);
	}
	//--------------------------------------------------------------------------
	public function setMask($strNewMaskType)
	{
		$strNewMaskType = strtolower($strNewMaskType);
		$arrMasksTypes = array(
		 'hms'	=> '99:99:99'
		,'hm'	=> '99:99');
		if (!array_key_exists($strNewMaskType,$arrMasksTypes) )
		{
			$strNewMaskType = 'hm';
		}
		$this->maskType = $strNewMaskType;
		parent::setMask($arrMasksTypes[$strNewMaskType]);
	}
	//--------------------------------------------------------------------------
	public function getMaskType()
	{
		return $this->maskType;
	}
	//--------------------------------------------------------------------------
	public function setButtonVisible($boolValue=null)
	{
		$boolValue = $boolValue===null ? true : (bool)$boolValue;
		$this->buttonVisible = $boolValue;
	}
	public function getButtonVisible()
	{
		return $this->buttonVisible;
	}
	/**
	* validar campo dmy, dm, my
	*
	*/
	public function validate()
	{
		if( parent::validate() )
		{
			$hora =$this->getValue();
			$tam = strlen($hora);
			if( $tam == 0 )
			{
				return true; // campo est� vazio
			}
			if ( $tam == 5 or $tam==8 )
			{
				$h = (integer) substr($hora,0,2);
				$m = (integer) substr($hora,3,2);
				$s = (integer) substr($hora,5,4)+0;
				//print $h.','.$m.'.'.$s;
				if ( ($h<0) || ($h>23)  || ($m<0) || ($m>59)|| ($s<0) || ($s>59) )
				{

					$this->setError('Hora inv�lida');
				}
			}
			else
			{
				$this->setError('Hora inv�lida');
			}
			if(!$this->getError())
			{
				// validar intervalo
				if($this->getMinValue() && $this->getValue()<$this->getMinValue())
				{
					if($this->getMaxValue())
					{
						$this->setError('Hora deve estar entre '.$this->getMinValue().' e '. $this->getMaxValue());
					}
					else
					{
						$this->setError('Hora deve estar MAIOR ou IGUAL a'.$this->getMinValue());
					}
				}
				if($this->getMaxValue() && $this->getValue()>$this->getMaxValue())
				{
					if($this->getMinValue())
					{
						$this->setError('Hora deve estar entre '.$this->getMinValue().' e '. $this->getMaxValue());
					}
					else
					{
						$this->setError('Hora deve estar MENOR ou IGUAL a'.$this->getMaxValue());
					}
				}
			}
		}
		return ( (string)$this->getError()==="" );
	}


//---------------------------------------------------------------------------
	public function setMaxValue($strNewValue=null)
	{
		$this->maxValue = $strNewValue;
	}
	//---------------------------------------------------------------------------
	public function getMaxValue()
	{
		return $this->maxValue;
	}
	//---------------------------------------------------------------------------
	public function setMinValue($strNewValue=null)
	{
		$this->minValue = $strNewValue;
	}
	//---------------------------------------------------------------------------
	public function getMinValue()
	{
		return $this->minValue;
	}
}
?>