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
* Classe para gerar o xml para cria��o de menus verticais utilizando a bibliotaca DHTMLX
* Link: http://www.dhtmlx.com/docs/products/docsExplorer/index.shtml?node=dhtmlxmenu
* Ex:
* 	$menu = new TMenuDhtmlx();
*	$menu->add(1,0,'Cadastro');
*	$menu->add(2,0,'Consulta');
*	$menu->add(21,2,'Consulta 2.1');
*	$menu->add(22,2,'Consulta 2.2');
*	$menu->add(221,22,'Consulta 2.2.1');
* 	echo $menu->getStructure();
* 	ou echo $menu->getXml()
*
*/
class TMenuDhtmlx
{
    private $arrMenu;
    private $arrOrphan;
    private $strId;
    private $strIdParent;
    private $strText;
	private $strUrl;
	private $boolDisabled;
	private $strImg;
	private $strImgDisabled;
	private $strHotKey;
	private $strTooltip;
	private $boolIgnoreOrphans;
	private $boolSeparator;
	private $arrUserData;

    public function __construct($data=null,$boolIgnoreOrphans=null)
    {
    	$this->boolIgnoreOrphans = $boolIgnoreOrphans === null ? true : $boolIgnoreOrphans;
        $this->arrMenu=null;
    }
    /**
    * M�todo para adicionar itens de menu
    *
    * @param string $strId
    * @param string $strIdParent
    * @param string $strText
    * @param string $strUrl
    * @param string $strToolTip
    * @param string $strImg
    * @param string $strImgDisabled
    * @param boolean $boolDisabled
    * @param string $strHotKey
    * @param boolean $boolSeparator
    * @return TMenuDhtmlx
    */
    public function add($strId, $strIdParent,$strText,$strUrl=null,$strToolTip=null,$strImg=null,$strImgDisabled=null,$boolDisabled=null,$strHotKey=null,$boolSeparator=null)
    {
        $menu = new TMenuDhtmlx();
        $menu->setText($strText);
        $menu->setId($strId);
        $menu->setIdParent($strIdParent);
        $menu->setUrl($strUrl);
        $menu->setToolTip($strToolTip);
        $menu->setImg($strImg);
        $menu->setImgDisabled($strImgDisabled);
        $menu->setDisabled($boolDisabled);
        $menu->setHotKey($strHotKey);
        $menu->setSeparator($boolSeparator);

        // verificar se o pai j� est� adicionado
        $objMenu = $this->getMenuById($strIdParent);
        if( $strIdParent && $objMenu )
        {
            $objMenu->addMenu($menu);
        }
        else
        {
        	// se tiver idparent ent�o � orf�o
            if( !$strIdParent )
            {
            	// item pai ou filho
                $this->addMenu($menu);
            }
            else
            {
                // Orphan
                $this->addOrphan($menu);
            }
        }
        return $menu;
    }
    protected function addMenu(TMenuDhtmlx $objMenu)
    {
        if( $Orphan = $this->getOrphanByIdParent($objMenu->getId()))
        {
            $objMenu->addMenu($Orphan);
        }
        $this->arrMenu[] = $objMenu;
    }
    public function setText($strNewValue)
    {
        $this->text = $strNewValue;
    }
    public function setId($strNewValue)
    {
        $this->id = $strNewValue;
    }
    public function setIdParent($strNewValue)
    {
        $this->idParent = $strNewValue;
    }
    public function setUrl($strNewValue)
    {
        $this->strUrl = $strNewValue;
    }
    public function setToolTip($strNewValue)
    {
        $this->strTooltip = $strNewValue;
    }
    public function setImg($strNewValue)
    {
        $this->strImg = $strNewValue;
    }
    public function setImgDisabled($strNewValue)
    {
        $this->strImgDisabled = $strNewValue;
    }
    public function setDisabled($boolNewValue)
    {
        $this->boolDisabled = $boolNewValue;
    }
    public function setHotKey($strNewValue)
    {
        $this->strHotKey = $strNewValue;
    }

    public function getText()
    {
        return $this->text;
    }
    public function getItem()
    {

		if( $this->getSeparator() )
		{
			$xml = "<item id='{$this->getId()}' type='separator'";
		}
		else
		{
			$xml = "<item id='{$this->getId()}' text='{$this->getText()}'";
		}
		if($this->getDisabled())
		{
			$xml.= " enabled='false'";
		}
		if($this->getImg())
		{
			$xml.= " img='{$this->getImg()}'";
		}
		if($this->getImgDisabled())
		{
			$xml.= " imgDis='{$this->getImgDisabled()}'";
		}
		$xml.= ">\n";
		if($this->getHotKey())
		{
			$xml.= "   <hotkey>{$this->getHotKey()}</hotkey>\n";
		}
		if($this->getToolTip())
		{
			$xml.= "   <tooltip>{$this->getToolTip()}</tooltip>\n";
		}
		if($this->getUrl())
		{
			$xml.= "   <userdata name='url'>{$this->getUrl()}</userdata>\n";
    	}
		$xml .= '</item>'."\n";
		return $xml;
    }
    public function addUserData($strName,$strValue)
    {
    	if( !is_null($strValue) && (string)$strValue != '' )
    	{
    		$this->arrUserData[$strName] = utf8_encode($strValue);
		}
    }
    public function getUserData()
    {
    	return $this->arrUserData;
    }
    public function getUserDataJson()
    {
    	if( is_array($this->arrUserData))
    	{
    	   	return json_encode($this->arrUserData);
       	}
    	return null;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getIdParent()
    {
        return $this->idParent;
    }
    function getUrl()
    {
        return $this->strUrl;
    }
    public function getToolTip()
    {
        return $this->strTooltip;
    }
    public function getImg()
    {
        return $this->strImg;
    }
    public function getImgDisabled()
    {
        return $this->strImgDisabled;
    }
    public function getDisabled()
    {
        return $this->boolDisabled;
    }
    public function getHotKey()
    {
        return $this->strHotKey;
    }
    public function getMenuById($strId)
    {
        $result = null;
        if($this->arrMenu)
        {
            foreach($this->arrMenu as $k=>$objMenu)
            {
                if( $objMenu->getId() == $strId)
                {
                    $result=$objMenu;
                    break;
                }
                $result = $objMenu->getMenuById($strId);
            }
        }
        return $result;
    }
    public function getOrphans()
    {
    	return $this->arrOrphan;
    }
    //--------------------------------------------------------------------------------------
    public function ignoreOrphans($boolNewValue=null)
    {
	    if( $boolNewValue === null)
	    {
    		return $this->boolIgnoreOrphans;
	    }
		$this->boolIgnoreOrphans = $boolNewValue;
    }
    //--------------------------------------------------------------------------------------
    public function clearOrphans()
    {
    	$this->arrOrphan = null;
    }
    //--------------------------------------------------------------------------------------
    public function setSeparator($boolNewValue=null)
    {
    	$this->boolSeparator = $boolNewValue;
    }
    public function getSeparator()
    {
    	return $this->boolSeparator;
    }
    //--------------------------------------------------------------------------------------

    public function getOrphanById($strId)
    {
        $result = null;
        if($this->arrOrphan)
        {
            foreach($this->arrOrphan as $k=>$objMenu)
            {
                if( $objMenu->getId() == $strId)
                {
                    $result=$objMenu;
                    break;
                }
                $result = $objMenu->getOrphanById($strId);
            }
        }
        return $result;
    }
    public function addOrphan(TMenuDhtmlx $menu)
    {
        // se existir filhos orf�o, adicionar todos os filhos
        while( $objMenu = $this->getOrphanByIdParent($menu->getId()) )
        {
            $menu->addMenu($objMenu);
        }
        // adicionar ao pai se existir
        if( $objMenu = $this->getOrphanById($menu->getIdParent()))
        {
            $objMenu->addMenu($menu);
        }
        else
        {
        	// adicionar a lista de orf�os
            $this->arrOrphan[] = $menu;
        }
    }
    public function getOrphanByIdParent($strId)
    {
        $result = null;
        if($this->arrOrphan )
        {
            foreach($this->arrOrphan as $k=>$objMenu)
            {
                if( $objMenu->getIdParent() == $strId)
                {
                    $result=$objMenu;
                    // remover o registro �rf�o
                    array_splice($this->arrOrphan,$k,1);
                    break;
                }
                $result = $objMenu->getOrphanByIdParent($strId);
            }
        }
        return $result;
    }
	public function getStructure()
	{
		static $level = 0;
		$xml=null;
		if( $level == 0 )
		{
			// processar o itens que ficaram sem pai e coloca-los no nivel 0 para aparecer no menu principal
			if($this->ignoreOrphans())
			{
				$this->clearOrphans();
			}
			else
			{
				if( $this->getOrphans())
				{
					foreach($this->getOrphans() as $k=>$objMenu)
					{
						$objMenu->setIdParent(0);
						$this->addMenu($objMenu);
					}
				}
			}
			$xml ='<menu>'."\n";
		}
		else
		{
			if( $this->getSeparator() )
			{
				$xml = "<item id='{$this->getId()}' type='separator'";
			}
			else
			{
				$xml = "<item id='{$this->getId()}' text='{$this->getText()}'";
			}
			if($this->getDisabled())
			{
				$xml.= " enabled='false'";
			}
			if($this->getImg())
			{
				$xml.= " img='{$this->getImg()}'";
			}
			if($this->getImgDisabled())
			{
				$xml.= " imgDis='{$this->getImgDisabled()}'";
			}
			$xml.= ">\n";
			if($this->getHotKey())
			{
				$xml.= "   <hotkey>{$this->getHotKey()}</hotkey>\n";
			}
			if($this->getToolTip())
			{
				$xml.= "   <tooltip>{$this->getToolTip()}</tooltip>\n";
			}
			if($this->getUrl())
			{
				$xml.= "   <userdata name='url'>{$this->getUrl()}</userdata>\n";
			}
			if($this->getUserData())
			{
				$xml.= "   <userdata name='parameters'>{$this->getUserDataJson()}</userdata>\n";
    		}
		}
        if( is_array($this->arrMenu))
		{
			foreach($this->arrMenu as $k => $objMenu)
			{
				$level++;
				$xml .= $objMenu->getStructure();
				$level--;
			}
		}
		return $xml.= ($level > 0 ) ? '</item>' :"\n</menu>";
		//return str_replace("\n","",$xml .= "</item>\n");
	}
	//--------------------------------------------------------------------------------------
	public function getXml($print=true)
	{
		$print = $print === null ? true : $print;
		if( $print)
		{
			echo str_replace("'",'"',$this->getStructure());
		}
		else
		{
			return str_replace("'",'"',$this->getStructure());
		}
        /*
		echo '<menu>
		<item id="file" text="Administra��o">
			<item id="new" text="New" img="new.gif"/>
			<item id="file_sep_1" type="separator"/>
			<item id="open" text="Open" img="open.gif">
				<userdata name="url">app_server_action("limparCache",false, "script")</userdata>
			</item>
			<item id="save" text="Save" img="save.gif"/>
			<item id="saveAs" text="Save As..." imgdis="save_as_dis.gif" enabled="false"/>
			<item id="file_sep_2" type="separator"/>
			<item id="print" text="Print" img="print.gif"/>
			<item id="pageSetup" text="Page Setup" imgdis="page_setup_dis.gif" enabled="false"/> <item id="file_sep_3" type="separator"/> <item id="close" text="Close" img="close.gif"/>
		</item>
		<item id="edit" text="Edit">
			<item id="undo" text="Undo" img="undo.gif"/>
			<item id="redo" text="Redo" img="redo.gif"/>
			<item id="edit_sep_1" type="separator"/>
			<item id="selectAll" text="Select All" img="select_all.gif"/>
			<item id="edit_sep_2" type="separator"/>
			<item id="cut" text="Cut" img="cut.gif"/>
			<item id="copy" text="Copy" img="copy.gif"/>
			<item id="paste" text="Paste" img="paste.gif"/>
		</item>
		<item id="help" text="Help">
			<item id="about" text="About..." img="about.gif"/>
			<item id="needhelp" text="Help" img="help.gif"/>
			<item id="bugReporting" text="Bug Reporting" img="bug_reporting.gif"/>
		</item>
		</menu>';
		*/
	}

}

/*
$menu = new TMenuDhtmlx();
$menu->add(4,3,'1.1.1.1','cad_1_1_1_1','Cadastro do item 1.1.1.1','save.gif','save_dis.gif',true,'CTRL+X');
$menu->add(3,2,'1.1.1');
$menu->add(2,1,'1.1');
$menu->add(1,0,'1 - Cadastro',null,null,'copy.gif');
$menu->add(7,5,'2.1');
$menu->add(8,7,'2.1.1');
$menu->add(9,7,'2.1.2');
$menu->add(10,7,'2.1.3');
$menu->add(5,0,'2 - Relat�rio',null,null,'save.gif');
*/

/*
$menu = new TMenuDhtmlx();
$menu->add(1,0,'Cadastro');
$menu->add(2,0,'Consulta 1');
    $menu->add(3,2,'3');
        $menu->add(31,3,'31');
        $menu->add(32,3,'32');
        $menu->add(33,3,'33');
            $menu->add(331,33,'331');
            $menu->add(332,33,'332');
            $menu->add(333,33,'333');
                $menu->add(3331,333,'3331');
                $menu->add(3332,333,'3332');

    $menu->add(4,2,'4');
        $menu->add(41,4,'41');
        $menu->add(42,4,'42');
*/

/*
$menu = new TMenuDhtmlx();
$menu->add(1,0,'Cadastro');
$menu->add(2,0,'Consulta 1');
    $menu->add(3,2,'Consulta 1.1');
        $menu->add(4,3,'Consulta 1.1.1');
        $menu->add(5,3,'Consulta 1.1.2');
        $menu->add(6,3,'Consulta 1.1.3');
    $menu->add(7,2,'Consulta 1.2');
    $menu->add(9,7,'Consulta 1.2.1');
*/
/*
$menu = new TMenuDhtmlx();
$menu->add(6,5,'Consulta 1.1.2.1');
$menu->add(5,3,'Consulta 1.1.2');
$menu->add(4,3,'Consulta 1.1.1');
$menu->add(3,2,'Consulta 1.1');
$menu->add(2,0,'Consulta 1');
$menu->add(9,0,'MENU 9');
$menu->add(7,9,'Consulta 7.9');
*/
/*
$menu->add(7,2,'Consulta 1.2');
$menu->add(9,7,'Consulta 1.2.1');
$menu->add(1,0,'Cadastro');
*/
//echo $menu->getXml();
?>