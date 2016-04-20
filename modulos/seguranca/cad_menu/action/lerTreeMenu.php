<?php
// cria a instância do objeto treeData 
$tree = new TTreeViewData(0,'Raiz',true);
$res = MenuDAO::selectAll('ORDEM,ID_MENU','ID_MENU_PAI IS NULL');
if( $res )
{
	foreach($res['ID_MENU'] as $k=>$v)
	{
        $cancelado='';
        if($res['CANCELADO'][$k]=='S' )
        {
            $cancelado = ' (cancelado)';    
        }
 		$tree->addItem(new TTreeViewData(
			$res['ID_MENU'][$k]
			,(is_null($res['ROTULO'][$k]) ? '':$res['ROTULO'][$k].$cancelado )
			,null
			,null
			));
	}

}
echo $tree->getXml();			
?>