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
* @todo	- possibilitar exibir ou n�o o bot�o editar e excluir do grid-offline
* @todo	- definir o foco para o primeiro campo do formulario do grid-ofline se n�o tiver sido informado pelo usuario
*/
include( 'autoload_formdin.php');
class TGrid extends TTable
{
	private $width;
	private $height;
	private $columns;
	private $title;
	private $titleCell;
	private $bodyCell;
	private $footerCell;
	private $data;
	private $keyField;
	private $updateFields; // campos que ser�o atualizados no formulario antes de executar a a��o
	private $buttons;
	private $onDrawRow;
	private $onDrawCell;
	private $onDrawHeaderCell;
	private $onDrawActionButton;
	private $onGetAutocompleteParameters;
	private $actionColumnTitle;
	private $zebrarColors;
	private $hiddenField;
	private $readOnly;
	private $maxRows;
	private $url;
	private $bvars;
	private $cache;
	private $createDefaultButtons;
	private $createDefaultImages;
	private $exportExcel;
	private $excelHeadFields;
	private $noWrap;
	private $noDataMessage;

	// dados do grid offline
	private $form;
	private $newRecordColor;
	private $editedRecordColor;
	private $savedRecordColor;
	private $deletedRecordColor;
	private $sortable;
	private $showCollapsed;

	private $autocomplete;
	private $javaScript;

	protected $numPages;
	protected $currentPage;

	private $createDefaultEditButton;
	private $createDefaultDeleteButton;
	private $createDefaultAdicionarButton;
	private $showAdicionarButton; // bot�o do grid offline
	private $disableButtonImage=null;
	private $exportFullData;


	/**
	* Classe para cria��o de grides
	*
	* Parametros do evento onDrawHeaderCell
	* 	1) $th			- objeto TElement
	* 	2) $objColumn 	- objeto TGridColum
	* 	3) $objHeader 	- objeto TElement
	*
	* Parametros do envento onDrawRow
	* 	1) $row 		- objeto TGridRow
	* 	2) $rowNum 		- n�mero da linha corrente
	* 	3) $aData		- o array de dados da linha ex: $res[''][n]
	*
	* Parametros do envento onDrawCell
	* 	1) $rowNum 		- n�mero da linha corrente
	* 	2) $cell		- objeto TTableCell
	* 	3) $objColumn	- objeto TGrideColum
	* 	4) $aData		- o array de dados da linha ex: $res[''][n]
	* 	5) $edit		- o objeto campo quando a coluna for um campo de edi��o
	*   ex: function ondrawCell($rowNum=null,$cell=null,$objColumn=null,$aData=null,$edit=null)
	*
	* Parametros do evento onDrawActionButton
	* 	1) $rowNum 		- n�mero da linha corrente
	* 	2) $button 		- objeto TButton
	* 	3) $objColumn	- objeto TGrideColum
	* 	4) $aData		- o array de dados da linha ex: $res[''][n]
	*   Ex: function tratarBotoes($rowNum,$button,$objColumn,$aData);
	*
	* Parametros do evento onGetAutocompleteParameters
	* 	1) $ac 			- classe TAutocomplete
	* 	2) $aData		- o array de dados da linha ex: $res[''][n]
	* 	3) $rowNum 		- n�mero da linha corrente
	* 	3) $cell		- objeto TTableCell
	* 	4) $objColumn	- objeto TGrideColum
	*
	*
	* @param mixed $strName
	* @param mixed $strTitle
	* @param mixed $mixData
	* @param mixed $strHeight
	* @param mixed $strWidth
	* @param mixed $strKeyField
	* @param mixed $mixUpdateFields
	* @param mixed $intMaxRows
	* @param mixed $strOnDrawCell
	* @param mixed $strOnDrawHeaderCell
	* @return TGride
	*/
	public function __construct( $strName, $strTitle = null, $mixData = null, $strHeight = null, $strWidth = null, $strKeyField = null, $mixUpdateFields = null, $intMaxRows = null, $strRequestUrl = null, $strOnDrawCell = null, $strOnDrawRow = null, $strOnDrawHeaderCell = null, $strOnDrawActionButton = null )
	{
		parent::__construct( $strName );
		parent::clearCss();
		$this->setTitle( $strTitle );
		$this->setData( $mixData );
		$this->addKeyField( $strKeyField );
		$this->setOnDrawRow( $strOnDrawRow );
		$this->setOnDrawHeaderCell( $strOnDrawHeaderCell );
		$this->setOnDrawCell( $strOnDrawCell );
		$this->setOnDrawActionButton( $strOnDrawActionButton );
		$this->setUpdateFields( is_null( $mixUpdateFields ) ? $strKeyField : $mixUpdateFields );
		$this->setMaxRows( $intMaxRows );
		if( isset( $_REQUEST[ 'modulo' ] ) )
		{
		$this->setUrl( ( is_null( $strRequestUrl ) ? $_REQUEST[ 'modulo' ] : $strRequestUrl ) );

		}
		$this->setExportExcel( true );
		$this->setSortable( true ); // permitir ordernar clicando no titulo da coluna
		$this->setCreateDefaultDeleteButton( true );
		$this->setCreateDefaultEditButton( true );
		$this->setShowAdicionarButton( true );
        $this->setNoDataMessage('Nenhum registro cadastrado!');
		// css da table principal ( externa )
		$this->setProperty( 'border', 0 );
		$this->setProperty( 'cellspacing', 0 );
		$this->setProperty( 'cellpadding', 0 );
		$this->setCss( 'border', '1px solid silver' );
		$this->setClass('tablesorter',false);

		// criar o titulo do gride
		$trTitle = $this->addRow();
		$this->titleCell = $trTitle->addCell();
		$this->titleCell->setId( $this->getId() . '_title' );
		$this->titleCell->setClass( 'fwGridTitle' );
		$this->titleCell->setCss( 'text-align', 'center' );

		// criar o corpo do gride
		$trBody = $this->addRow();
		$this->bodyCell = $trBody->addCell();
		$this->bodyCell->setId( $this->getId() . '_body' );

		// definir as medidas
		$strWidth = is_null( $strWidth ) ? '100%' : $strWidth;
		$this->setWidth( $strWidth );
		$this->setHeight( $strHeight );

		// criar o rodape do gride
		$trFooter = $this->addRow();
		$this->footerCell = $trFooter->addCell();
		$this->footerCell->setId( $this->getId() . '_footer' );
		$this->footerCell->setClass( 'fwGridFooter' );
		$this->footerCell->setCss( 'text-align', 'left' );

		// zebrar o gride
		$this->setZebrarColors( '#ffffff', '#efefef' );

		// iniciar as vari�veis de controle de pagina��o
		$this->currentPage = 1;
		$this->numPages = 0;

		if ( isset( $_REQUEST[ 'TGrid' ] ) && $_REQUEST[ 'TGrid' ] > 0 )
		{
			/**
			* @todo alterar a chamada do gride para fwAjaxRequest e n�o mais pela json.onLoad();
			*/
			$_REQUEST[ 'dataType' ] = 'text'; // evitar problema com a chamada pela fwAjaxRequest
		}

		if ( isset( $_REQUEST[ 'page' ] ) && $_REQUEST[ 'page' ] > 0 )
		{
			// chamada via ajax
			$this->currentPage = ( int ) $_REQUEST[ 'page' ];
		}
		else if( isset( $_REQUEST[ $this->getId() . '_jumpToPage' ] ) && $_REQUEST[ $this->getId() . '_jumpToPage' ] > 0 )
		{
			// chamada via post
			$this->currentPage = ( int ) $_REQUEST[ $this->getId() . '_jumpToPage' ];
		}
	}

	//------------------------------------------------------------------------------------
	public function show( $boolPrint = true )
	{
		// quando for requisi��o de pagina��o do gride, limpar o buffer de saida
		if( isset($_REQUEST['page'] ) && isset( $_REQUEST['TGrid'] ) )
		{
			ob_clean();
		}
		// se o grid for offline, criar as colunas e configurar o form
		if ( $this->getForm() )
		{
			$this->configOffLine();
		}

		// definir as medidas do gride
		$this->setProperty( 'width', $this->getWidth() );
		$this->setProperty( 'height', $this->getHeight() );
		$this->setProperty( 'row_count', $this->getRowCount() );
		$this->setProperty('fieldtype','grid' );

		$fldSortedColumn = new THidden( $this->getId() . '_sorted_column' );
		$fldSortedColumnOrder = new THidden( $this->getId() . '_sorted_column_order' );
		$fldCollapsed 			= new THidden( $this->getId() . '_collapsed' );
		//$this->add('<input id="'.$this->getId().'_sorted_column" type="hidden" value="">');
		$this->add($fldSortedColumn);
		$this->add($fldSortedColumnOrder);
		$this->add($fldCollapsed);

		// esconder o titulo se o titulo do gride for null
		if ( is_null( $this->getTitle() ) )
		{
			$this->titleCell->setCss( 'display', 'none' );
		}

		if ( $this->getColumnCount() == 0 )
		{
			// tentar criar as colunas automaticamente utilizando o array de dados
			$this->autoCreateColumns();
		}

		if ( $this->getColumnCount() == 0 )
		{
			// nenhuma coluna adicionada
			$row = $this->addRow();
			$row->addCell( 'nenhuma coluna adicionada' );
		}
		else
		{
			// adicionar os bot�es Alterar e Excluir
			if ( $this->getCreateDefaultButtons() )
			{
				$imgEdit = null;
				$imgDeleter = null;

				if ( $this->getUseDefaultImages() )
				{
					$imgEdit = 'alterar.gif';
					$imgDelete = 'lixeira.gif';
				}

				if ( $this->getCreateDefaultEditButton() )
				{
					$this->addbutton( 'Alterar', $this->getId() . '_alterar', null, null, null, $imgEdit, null, 'Alterar' );
				}

				if ( $this->getCreateDefaultDeleteButton() )
				{
					//$this->addButton('Excluir',$this->getId().'_excluir',null,null,'Confirma exclus�o ?',$imgDelete,null,'Excluir');
					$this->addButton( 'Excluir', $this->getId() . '_excluir', null, 'fwGridConfirmDelete()', null, $imgDelete, null, 'Excluir' );
				}
			}
			// calcular a quantidade de colunas
			$qtdColumns = $this->getColumnCount() + ( count( $this->getButtons() ) > 0 ? 1 : 0 );

			// ajustar colspan do header e footer
			$this->titleCell->setProperty( 'colspan', $qtdColumns );
			$this->footerCell->setProperty( 'colspan', $qtdColumns );

			// exibir o titulo do gride
			$this->titleCell->add( $this->getTitle() );

			if ( $this->getCss( 'font-size' ) )
			{
				if ( !$this->titleCell->getCss( 'font-size' ) )
				{
					$this->titleCell->setcss( 'font-size', $this->getCss( 'font-size' ) );
				}
			}
			$this->bodyCell->setProperty( 'valign', 'top' );
			$this->bodyCell->setProperty( 'bgcolor', '#efefef' );

			$this->bodyCell->add( $divScrollArea = new TElement( 'div' ) );
			$divScrollArea->clearCss();
			$divScrollArea->setClass( 'fwGridBody' );
			$divScrollArea->setCss( 'width', $this->getWidth() );
			$divScrollArea->setCss( 'height', $this->getHeight() );

			$divScrollArea->add( $tableGrid = new TTable( $this->getId() . '_table' ) );
			$tableGrid->setProperty( 'border', '0' );
			$tableGrid->setProperty( 'cellspacing', '0' );
			$tableGrid->setProperty( 'cellpadding', '0' );

			$tableGrid->setCss( 'width', '100%' );
			$tableGrid->setCss( 'border-left', '1px solid silver' );
			$tableGrid->setCss( 'border-right', '1px solid silver' );
			//$tableGrid->setCss('border-collapse','collapse');
			//$tableGrid->setCss('height','auto');

			// thead e tbody
			$tableGrid->add( $thead = new TElement( 'thead' ) );
			$thead->clearCss();
			$thead->setClass( 'fwHeaderBar' );
			$thead->add( $row = new TTableRow() );
			$row->clearCss();
			$tableGrid->add( $tbody = new TElement( 'tbody' ) );
			$tbody->clearCss();

			// se a funcao ondrawRow estiver definia e nao existir, retirar o evento
			if ( $this->getOnDrawRow() && !function_exists( $this->getOnDrawRow() ) )
			{
				$this->setOnDrawRow( null );
			}

			// se a funcao ondrawcell estiver definia e nao existir, retirar o evento
			if ( $this->getOnDrawCell() && !function_exists( $this->getOnDrawCell() ) )
			{
				$this->setOnDrawCell( null );
			}

			// se a funcao ondrawcell estiver definia e nao existir, retirar o evento
			if ( $this->getOnDrawHeaderCell() && !function_exists( $this->getOnDrawHeaderCell() ) )
			{
				$this->setOnDrawHeaderCell( null );
			}

			// se a funcao ondrawActionButton estiver definia e nao existir, retirar o evento
			if ( $this->getOnDrawActionButton() && !function_exists( $this->getOnDrawActionButton() ) )
			{
				$this->setOnDrawActionButton( null );
			}

			// se a funcao onGetAutocompleteCallBackParameters estiver definia e nao existir, retirar o evento
			if ( $this->getOnGetAutocompleteCallBackParameters && !function_exists( $this->getOnGetAutocompleteCallBackParameters() ) )
			{
				$this->setOnGetAutocompleteCallBackParameters( null );
			}

			// adicionar a coluna de a��es do gride se tiver botoes adicionados
			if ( $this->getButtons() )
			{
				$colAction = $this->addColumn( null, $this->getActionColumnTitle(), 'auto' );
				$colAction->setId('col_action');
				$colAction->setColumnType( 'action' );
				$colAction->setCss( 'text-align', 'center' );
				// dist�ncia entre a borda e os bot�es
				$colAction->setCss( 'padding', '2.5px' );
			}
			// contador de colunas
			$colIndex = 0;
			$colSort  = null;
			$headersSortable = '';
			// criar as colunas titulo do gride
			foreach( $this->getColumns() as $name => $objColumn )
			{
            	if( $objColumn->getVisible() )
                {
					if ( ! $this->getSortable()  )
					{
						$objColumn->setSortable( false );
					}
					if( ! $objColumn->getSortable() )
					{
						$headersSortable .= ( ($headersSortable == '' ) ? '' :',' );
						$headersSortable .= $colIndex.': {sorter: false}';
					}
					else
					{
						if( is_null($colSort))
						{
							$colSort = $colIndex;
						}
					}
					$objColumn->setGridId( $this->getId() );
					$objColumn->setColIndex( ++$colIndex );

					$th = new TElement( 'th' );
					$th->setId( $this->getid().'_th_' . $objColumn->getId() );

					$th->clearCss();
					$objColumn->setCss( 'width', $objColumn->getWidth() );
					$th->setClass( 'fwGridHeader' );
					$th->setCss( 'width', $objColumn->getWidth() );
					$th->setCss( 'text-align', $objColumn->getHeaderAlign() );
					$th->setAttribute('grid_id',$this->getId());
					$th->setAttribute('column_index',$objColumn->getColIndex());
					if( $objColumn->getId()=='col_action')
					{
						$th->setAttribute( 'column_name', $this->getId().'_action' );
					}
					else
					{
						$th->setAttribute( 'column_name', strtolower( $objColumn->getFieldName() ) );
					}

					if ( $objColumn->getHeader()->getCss( 'background-color' ) )
					{
						$th->setCss( 'background-color', $objColumn->getHeader()->getCss( 'background-color' ) );
					}
					$objHeader = $objColumn->getHeader();
					$objHeader->setId( $th->getId() . '_label' );

					if ( $this->getCss( 'font-size' ) )
					{
						if ( !$objHeader->getCss( 'font-size' ) )
						{
							$objHeader->setCss( 'font-size', $this->getCss( 'font-size' ) );
						}
					}
					$th->add( $objHeader );

					if ( $this->getOnDrawHeaderCell() && function_exists( $this->getOnDrawHeaderCell() ) )
					{
						call_user_func( $this->onDrawHeaderCell, $objHeader, $objColumn, $th );
					}
					else
					{
						$th->add( $th->getValue() );
					}

					if ( $this->getReadOnly() )
					{
						$objColumn->setReadOnly( true );
					}

					// colcocar checkbox no titulo se a coluna for do tipo checkbox
					if ( $objColumn->getDataType() == 'checkbox' )
					{
						if ( $objColumn->getAllowCheckAll() )
						{
							$chk = new TElement( 'input' );
							$chk->setProperty( 'type', 'checkbox' );
							$chk->setProperty( 'value', '1' );
							$chk->setId( 'chk_' . $objColumn->getId() . '_header' );
							$chk->setCss( 'cursor', 'pointer' );
							$chk->setProperty( 'title', 'marcar/desmarcar todos' );
							$chk->addEvent( 'onclick', "fwGridCheckUncheckAll(this,'{$objColumn->getEditName()}',event)" );
							if ( $objColumn->getReadOnly() )
							{
								$chk->setProperty( 'disabled', 'true' );
							}

							if ( isset( $_POST[ $chk->getId()] ) && $_POST[ $chk->getId()] == 1 )
							{
								$chk->setProperty( 'checked', '' );
							}
                            $divChk = new TElement('div');
                            $divChk->setCss(array('padding-left'=>'1.5px','background-color'=>'transparent','display'=>'table-cell','vertical-align'=>'middle') );
                            $divChk->add($chk);
                            $divVal = new TElement('div');
                            $divVal->setCss(array('background-color'=>'transparent','display'=>'table-cell','vertical-align'=>'middle' ) );
                            $divVal->add($objHeader->getValue());
							$objHeader->setValue( $divChk->show(false).$divVal->show(false) );
						}
					}
					$row->add( $th );
				}
			}

            $tableSorterCfg = '';
			if( $headersSortable != '' )
			{
				$tableSorterCfg .= 'headers:{'.$headersSortable.'}';
			}

        	$this->javaScript[] = 'jQuery("#'.$this->getId().'_table").tablesorter({'.$tableSorterCfg.'});';

			// avisar erro se tiver passado o parametro maxRows e n�o tiver informado a url
			if ( $this->getMaxRows() && !$this->url )
			{
				$this->footerCell->add( '<blink><span style="color:red;font-weight:bold;">Para utilizar o recurso de pagina��o, o parametro strRequestUrl, tambem dever ser informado</span></blink>' );
			}

			if ( is_array( $this->getData() ) )
			{
				$res = $this->getData();

				if( isset($_REQUEST[$this->getId().'_sorted_column'] ) )
				{
					$res = $this->sortArray($res,$_REQUEST[$this->getId().'_sorted_column'],$_REQUEST[$this->getId().'_sorted_column_order']);
				}

				$rowNum = 0;
				$rowStart = 0;
				$totalRows = $this->getRowCount();
				$rowEnd = $totalRows;

				if ( $this->getMaxRows() > 0 )
				{
					$this->numPages = ceil( $rowEnd / $this->getMaxRows() );

					// controle de paginacao
					if ( $this->currentPage > 0 )
					{
						$rowStart = ( $this->currentPage - 1 ) * $this->getMaxRows();
						$rowEnd = $rowStart + $this->getMaxRows();
					}
				}



				$keys = array_keys($res);
				foreach( $res[ strtoupper( $keys[0]  )] as $k => $v )
				{
					$rowNum++;

					if ( ( $rowNum - 1 ) < $rowStart )
					{
						continue;
					}

					if ( ( $rowNum - 1 ) >= $rowEnd )
					{
						break;
					}
					// adicionar uma linha na tabela ( tr )
					$tbody->add( $row = new TTableRow() );
					$row->setProperty( 'id', strtolower( $this->getId() . '_tr_' . $rowNum ) );
					$row->setProperty( 'grid_id', $this->getId() );
					$row->clearCss();
					$row->setClass( 'fwGridRow' );
					$row->getCss( $objColumn->getCss() );
					$row->setProperty( 'line_number', $rowNum );
					$row->setProperty( 'row_count', $totalRows );
					//$row->setProperty( 'num_rows', $totalRows );

					if ( $this->onDrawRow )
					{
						call_user_func( $this->onDrawRow, $row, $rowNum, $this->getRowData( $k ) );
					}

					if ( !$row->getVisible() )
					{
						continue;
					}
					$arrColunms = $this->getColumns();
					/*if( $rowNum == 1 )
					{
						print_r($arrColunms);
					}
					*/

					// adicionar as colunas ( td )
					foreach( $arrColunms as $columnId => $objColumn )
					{
                        if( !$objColumn->getVisible() )
                        {
                        	continue;
						}
						$fieldName = $objColumn->getFieldName();

						// zebrar o gride se nao existir a funcao ondrawrow definida pelo usuario
						if ( $this->getZebrarColors( 0 ) )
						{
							// n�o sobrepor se o background color estiver definido
							if ( !$row->getCss( 'background-color' ) )
							{
								if ( $rowNum % 2 != 0 )
								{
									$row->setCss( 'background-color', $this->getZebrarColors( 0 ) );
								}
								else
								{
									$row->setCss( 'background-color', $this->getZebrarColors( 1 ) );
								}
							}
						}
						$cell = $row->addCell();
						$cell->setAttribute('column_index',$objColumn->getColIndex() );
						$cell->setAttribute('grid_id',$this->getId() );
						$cell->setProperty( 'id', strtolower( $this->getId() . '_td_' . $rowNum ) );
						//$cell->clearCss();
						$cell->setClass( 'fwGridCell', false );

						if ( $objColumn->getNoWrap() || ( is_null( $objColumn->getNoWrap() ) && $this->getNoWrap() === true ) )
						{
							$cell->setProperty( 'nowrap', 'nowrap' );
						}
						$cell->setCss( $objColumn->getCss() );
						$cell->setCss( 'width', null ); // a largura � dada pelo titulo (head)

						if ( $objColumn->getTextAlign() )
						{
							$cell->setCss( 'text-align', $objColumn->getTextAlign() );
						}

						// alterar o tamanho da fonte para o tamanho definido para o gride todo
						if ( $this->getCss( 'font-size' ) )
						{
							if ( !$cell->getCss( 'font-size' ) )
							{
								$cell->setcss( 'font-size', $this->getCss( 'font-size' ) );
							}
						}
						$cell->setProperty( 'line_number', $rowNum );
						//$cell->setProperty( 'num_rows', $totalRows );

						if ( $objColumn->getColumnType() == 'rownum' )
						{
							$cell->setProperty( 'id', strtolower( $this->getid() . '_' . $objColumn->getFieldName() . '_' . $rowNum ) );
							$cell->add( $rowNum );

							if ( $this->onDrawCell )
							{
								call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), null );
							}
						}
						else if( $objColumn->getColumnType() == 'plain' )
						{
							$cell->setProperty( 'field_name', $objColumn->getFieldName() );
							$cell->setProperty( 'id', strtolower( $this->getid() . '_' . $objColumn->getFieldName() . '_' . $rowNum ) );
							$tdValue = '';

							// verificar o nome da coluna informado em caixa alta, baixa e normal
							if ( isset( $res[ $fieldName ][ $k ] ) )
							{
								$tdValue = ( ( $res[ $fieldName ][ $k ] ) ? $res[ $fieldName ][ $k ] : '' );
							}
							else if( isset( $res[ strtolower( $fieldName )][ $k ] ) )
							{
								$tdValue = ( ( $res[ strtolower( $fieldName )][ $k ] ) ? $res[ strtolower( $fieldName )][ $k ] : '' );
							}
							else if( isset( $res[ strtoupper( $fieldName )][ $k ] ) )
							{
								$tdValue = ( ( $res[ strtoupper( $fieldName )][ $k ] ) ? $res[ strtoupper( $fieldName )][ $k ] : '' );
							}
							//$tdValue = isset($res[strtoupper($fieldName)][$k]) && $res[strtoupper($fieldName)][$k] ? $res[strtoupper($fieldName)][$k]: '<center>---</center>';
							//$tdValue = ( $objColumn->getConvertHtml() ) ? htmlentities($tdValue): $tdValue;
							$tdValue = ( $tdValue == '' ) ? '&nbsp;' : $tdValue;
							$cell->setValue( $tdValue );
							$tdValue = null;

							if ( $this->onDrawCell )
							{
								call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), null );
							}

							if ( $this->getForm() )
							{
								// colocar as cores dos estatus na primeira coluna do gride
								if ( strtoupper( $columnId ) == strtoupper( $this->getId() . '_AEI' ) )
								{
									$data = $this->getRowData( $k );

									if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'A' )
									{
										$cell->clearChildren();
										$cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getEditedRecordColor() . ';"></div></center>' );
									}
									else if( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
									{
										$cell->clearChildren();
										$cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getDeletedRecordColor() . ';"></div></center>' );
									}
									else if( $data[ strtoupper( $this->getId() . '_AEI' )] == 'I' )
									{
										$cell->clearChildren();
										$cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getNewRecordColor() . ';"></div></center>' );
									}
									else
									{
										$cell->clearChildren();
										$cell->add( '<center><div style="width:10px;height:10px;background-color:' . $this->getSavedRecordColor() . ';"></div></center>' );
									}
								}
							}
						}
						else if( $objColumn->getColumnType() == 'edit' )
						{

							$value = null;
							// primeiro ler o valor do post, se n�o existir, ler do $res
							if ( $objColumn->getFieldName() )
							{
								if ( isset( $res[ $objColumn->getFieldName()][ $k ] ) )
								{
									$value = $res[ $objColumn->getFieldName()][ $k ];
								}
							}
							$keyValue = '';
   							if ( $this->getKeyField() )
							{
								// chave composta
								foreach( $this->getKeyField() as $key => $fieldName )
								{
									$keyValue .= trim($res[ $fieldName ][ $k ]);
								}
                            }
                            if( $keyValue == '')
                            {
								$keyValue=$v;
                            }
							$objColumn->setKeyValue( $keyValue );
							// configurar a coluna
							$objColumn->setRowNum( $rowNum );
							$objColumn->setValue( $value );
							$edit = $objColumn->getEdit();

							// definir o valor do campo chave para as colunas poderem gerar os edit
							if ( $this->getKeyField() )
							{
								foreach( $this->getKeyField() as $key => $fieldName )
								{
									// Se o edit tiver algum evento definido, adicionar os campos
									// chaves e seus valores como atributos para serem recuperados
									// no evento se neces�rio
									if ( is_array( $edit->getEvents() ) )
									{
										$edit->setAttribute( $fieldName, $res[ $fieldName ][ $k ] );
									}
								}
							}
							// se a coluna checkbox tiver o campo descri��o, adicionar a descri��o na op��o
							if ( $objColumn->getDataType() == 'select' )
							{
								if ( !$objColumn->getKeyValue() )
								{
									$edit->setName( $edit->getId() . '[' . $rowNum . ']' );
									$edit->setId( $edit->getId() . '_' . $rowNum );
								}
								if( $objColumn->getFieldName() && isset( $res[ $objColumn->getFieldName()][$k] ) )
								{
									$edit->setOptions( $res[ $objColumn->getFieldName()][$k] );
									if( $objColumn->getInitialValueField() && isset($res[ $objColumn->getInitialValueField()][$k]) )
									{
										// o valor do post deve prevaler sobre o valor inicial
										if( ! isset( $_REQUEST[ $edit->getAttribute('fwName') ] ) )
										{
											$edit->setvalue( $res[ $objColumn->getInitialValueField()][$k] );
										}
									}

								}
								//$edit->setOptions('1=Um,2=Dois');
							}
							else if( $objColumn->getDataType() == 'checkbox' || $objColumn->getDataType() == 'radio' )
							{
								$cell->setProperty( 'nowrap', '' );

								if ( $objColumn->getDescField() )
								{
									$desc = '';

									if ( isset( $res[ $objColumn->getDescField()][ $k ] ) ) $desc = $res[ $objColumn->getDescField()][ $k ];

									else if( isset( $res[ strtoupper( $objColumn->getDescField() )][ $k ] ) ) $desc = $res[ strtoupper( $objColumn->getDescField() )][ $k ];

									else if( isset( $res[ strtolower( $objColumn->getDescField() )][ $k ] ) ) $desc = $res[ strtolower( $objColumn->getDescField() )][ $k ];
									$objColumn->setDescValue( $desc );
									//$edit->setOptions(array($value=>$desc));
									$edit = $objColumn->getEdit();
								}
							}
							//$edit = $objColumn->getEdit();

							if ( $edit->getEvents() )
							{
								foreach( $edit->getEvents() as $eventName => $eventFunction )
								{
									if ( preg_match( '/\(\)/', $eventFunction ) == 1 )
									{
										$eventFunction = preg_replace( '/\(\)/', '(this,' . $rowNum . ')', $eventFunction );
										$edit->setEvent( $eventName, $eventFunction );
									}
								}
							}

							//desabilitar o campo se a coluna for readonly
							if ( $objColumn->getReadOnly() )
							{
								// o campo check nao tem setEnabled
								if ( method_exists( $edit, 'setReadOnly' ) )
								{
									$edit->setReadOnly( true );
								}
								else if( method_exists( $edit, 'setEnabled' ) )
								{
									$edit->setEnabled( false );
								}
							}

							if ( $edit )
							{
								if ( is_object( $this->autocomplete[ strtolower( $objColumn->getFieldName() )] ) )
								{
									$ac = $this->autocomplete[ strtolower( $objColumn->getFieldName() )];
									// transformar os campos de update para array
									$up = $ac->getUpdateFields();
									$ac->setUpdateFields( null );

									if ( $up )
									{
										if ( is_string( $up ) )
										{
											$up = explode( ',', $up );
										}
										$upFields = '';

										foreach( $up as $key => $value )
										{
											$value = explode( '%', $value );
											$upFields .= $upFields == '' ? '' : ',';
											$upFields .= $value[ 0 ] . '%' . $objColumn->getRowNum();
										}
										$ac->setUpdateFields( $upFields );
									}
									$ac->setFieldName( $edit->getId() );
									// parametros defaul
									$ac->setCallBackParameters( "'" . $keyValue . "'," . $objColumn->getRowNum() . ',' . $this->getRowCount() );

									// verificar se o usu�rio quer redefinir os parametros
									if ( $this->getOnGetAutocompleteParameters() )
									{
										call_user_func( $this->onGetAutocompleteParameters, $ac, $this->getRowData( $k ), $rowNum, $cell, $objColumn );
									}
									$edit->setHint( $ac->getHint() );
									$this->javaScript[] = $ac->getJs() . "\n";
								}
								$cell->add( $edit );
							}

							if ( $this->onDrawCell )
							{
								call_user_func( $this->onDrawCell, $rowNum, $cell, $objColumn, $this->getRowData( $k ), $edit );
							}

							// deaabilitar todos os edits se o grid for readonly
							if ( $this->getReadOnly() )
							{
								if ( method_exists( $edit, 'setEnabled' ) )
								{
									$edit->setEnabled( false );
								}
							}
						}
						else if( $objColumn->getColumnType() == 'action' )
						{
							//----------------------------------------------------
							$cell->setClass( 'fwGridCellAction', false );
							$cell->setProperty( 'nowrap', 'true' );

							if ( is_array( $this->getButtons() ) )
							{
								foreach( $this->getButtons() as $buttonName => $objButton )
								{
									if( $this->getDisabledButtonImage() && preg_match('/fwblank/',$objButton->getImageDisabled() ) )
									{
										$objButton->setImageDisabled( $this->getDisabledButtonImage() ) ;
									}
									// criar novo bot�o para n�o acumular o evento onClick
									$newButton = new TButton( $objButton->getName(), $objButton->getValue(), $objButton->getAction(), $objButton->getOnClick(), $objButton->getConfirmMessage(), $objButton->getImage(), $objButton->getImageDisabled(), $objButton->getHint(), $objButton->getSubmitAction() );
									$newButton->setCss( 'width', "auto" );
									$newButton->setCss( 'height', "auto" );
									$newButton->setClass( $objButton->getClass() );

									// criar a fun��o de atualizar os campos do formul�rio ao clicar no bot�o
									if ( is_array( $this->getUpdateFields() ) )
									{
										$strFields = null;
										$strValues = null;
										$strJquery = null; // para grids offline

										foreach( $this->getUpdateFields() as $field => $formField )
										{
											$strFields .= is_null( $strFields ) ? '' : '|';
											$strFields .= $formField;
											$strValues .= is_null( $strValues ) ? '' : '|';
											$strJquery .= is_null( $strJquery ) ? '' : ',';
											$aKeyFields = $this->getKeyField();

											if ( is_array($aKeyFields) && in_array( $field, $aKeyFields ) )
											{
												$newButton->setProperty( $field, $res[ $field ][ $k ] );
											}

											if ( array_key_exists( $field, $res ) )
											{
												if ( isset( $res[ $field ][ $k ] ) )
												{
													$strValues .= preg_replace('/'.chr(13).'/','', preg_replace('/'.chr(10).'/','\r',addcslashes($res[ $field ][ $k ],"'")) );
													$strJquery .= '"' . strtolower( $field ) . '":"' . addcslashes($res[ $field ][ $k ],"'") . '"';
												}
												else
												{
													$strValues .= '';
													$strJquery .= '"' . strtolower( $field ) . '":""';
												}
											}
										}

										if ( $newButton->getOnClick() )
										{
											// deixar somente o nome da fun��o sem os parametros
											$jsFunction = $objButton->getOnClick();
											$pos = strpos( $jsFunction, '(' );

											if ( $pos > 0 )
											{
												$jsFunction = substr( $jsFunction, 0, $pos );
											}

											if ( !$this->getForm() )
											{
												$jsFunction .= '("' . $strFields . '","' . $strValues . '","' . $this->getId() . '","' . $rowNum . '")';
											}
											else
											{
												$jsFunction = 'jQuery("#' . $_POST[ 'parent_field' ] . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $_POST[ 'parent_field' ] . '","subform":1,"' . $this->getId() . 'Width":"' . $this->getWidth() . '","action":"' . $newButton->getAction() . '",' . $strJquery . '} );';
											}
										}
										else
										{
											$strFields = 'fwAtualizarCampos("' . $strFields . '","' . $strValues . '");';
											$jsFunction = $strFields;

											if ( $newButton->getSubmitAction() )
											{
												$jsFunction .= 'fwFazerAcao("' . $newButton->getAction() . '")';
											}
										}
										$newButton->setOnClick( $jsFunction );
										// retirar a acao do bot�o para valer o evento onclick;
										$newButton->setAction( null );
									}
									$cell->add( $newButton );

									if ( $this->onDrawActionButton )
									{
										call_user_func( $this->onDrawActionButton, $rowNum, $newButton, $objColumn, $this->getRowData( $k ), $row );
									}

									// se o bot�o estiver invis�vel, trocar para uma imagem transparente para manter o epa�amento dos outros bot�es
									if ( !$newButton->getVisible() )
									{
										$newButton->setEnabled( false );
										$newButton->setVisible( true );
										$newButton->setImageDisabled( 'fwDisabled.png' );
									}

									// alterar o rotulo do bot�o excluir para recuperar quando o registro tiver excluido
									if ( $this->getForm() )
									{
										if ( strtolower( $newButton->getId() ) == strtolower( 'btn' . $this->getId() . '_edit' ) )
										{
											$data = $this->getRowData( $k );

											if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
											{
												$newButton->setEnabled( false );
											}
										}
										else if( strtolower( $newButton->getId() ) == strtolower( 'btn' . $this->getId() . '_delete' ) )
										{
											$data = $this->getRowData( $k );

											if ( $data[ strtoupper( $this->getId() . '_AEI' )] == 'E' )
											{
												$newButton->setValue( 'Recuperar' );
												$newButton->setHint( 'Recuperar' );
												// alterar a confirm message.
												//$newButton->setImage('lixeira_cancelar.gif');
												$newButton->setImage( 'undo16.gif' );
												$newButton->setConfirmMessage( 'Confirma a recupera��o do registro ?' );
											}
										}
									}

									if ( $this->getReadOnly() )
									{
										$newButton->setEnabled( false );
									}
								}
							}
						}
					}

					// adicionar os campos ocultos na linha ( tr )
					if ( $this->getHiddenField() )
					{
						foreach( $this->getHiddenField() as $fieldName => $id )
						{
							$value = '';

							if ( isset( $_POST[ strtolower( $id )][ $keyValue ] ) )
							{
								$value = $_POST[ strtolower( $id )][ $keyValue ];
							}
							else if( isset( $res[ $fieldName ][ $k ] ) )
							{
								$value = $res[ $fieldName ][ $k ];
							}
							else if( isset( $res[ strtoupper( $fieldName )][ $k ] ) )
							{
								$value = $res[ strtoupper( $fieldName )][ $k ];
							}
							$hidden = new THidden( strtolower( $id ) . '[' . $keyValue . ']' );
							$hidden->setId( strtolower( $id ) . '_' . $rowNum );
							$hidden->setValue( $value );
							$row->add( $hidden );
						}
					}
				}

				// adicionar a imagem do excel no rodap�
				if ( $this->getExportExcel() )
				{
					//$_SESSION['fwGrid'][$this->getId()] = $this->getData2Excel();
					//$_SESSION['fwGrid'][$this->getId()]['titulo'] =$this->getTitle();
					$excel = new TElement( 'a' );
					$excel->setProperty( 'href', 'javascript: void(0)' );
					$arrParams = null;
					$arrParams[ 'id' ] 		= utf8_encode($this->getId());
					$arrParams[ 'head' ] 	= $this->getExcelHeadField('utf8');
					$arrParams[ 'title' ] 	= utf8_encode($this->getTitle() );
					$excel->addEvent( 'onclick', 'fwExportGrid2Excel(' . json_encode( $arrParams ) . ')' );
					//$excel->addEvent('onclick','alert("base/classes/FormDin3.xls.php?gride='.$this->getID().'")');
					$img = new TElement( 'img' );
					$img->setProperty( 'src', $this->getBase() . 'imagens/planilha.png' );
					$img->setCss( 'border', 'none' );
					$img->setCss( 'width', '16' );
					$img->setCss( 'height', '13' );
					$excel->setProperty( 'title', 'Exportar planilha' );
					$excel->add( $img );
					$excel->setCss( 'float', 'right' );
					$this->footerCell->add( $excel );

					// salvar o array em disco
					$tmpName = $excel->getBase().'tmp/tmp_'.$this->getId().'_'.session_id().'.go';
					if( file_exists( $tmpName ))
					{
						@unlink($tmpName);
					}
					if( !file_put_contents( $tmpName, serialize( $this->getData2Excel() ) ) )
					{
						$excel->setAttribute('title',htmlentities('Erro ao salvar os dados para exporta��o',null,'ISO-8859-1'));
					}
				}

				//$btnExcel = new TButton('btnExcel','Excel',null,'alert("excel")',null,'excel.gif',null,'Exportar dados para o excel');
				// adicionar a barra de navega��o no fim do gride
				if ( $this->getMaxRows() )
				{
					//$this->setNavButtons($tbody,$qtdColumns);
					$this->setNavButtons( $this->footerCell, $qtdColumns );
				}
			}
			else
			{
				// nenhum registro encontrado
				$tbody->add( $row = new TTableRow() );
				$row->clearCss();
				$cell = $row->addCell( '<center>'.$this->getNoDataMessage().'</center>' );
				$cell->clearCss();
				$cell->setClass( 'fwGridCell' );
				$cell->setCss( 'color', '#ff0000' );
				$cell->setCss( 'width', 'auto' );
				$cell->setProperty( 'colspan', $qtdColumns );
			}
		}

		if ( isset( $_REQUEST[ 'ajax' ] ) && $_REQUEST[ 'ajax' ] && isset( $_REQUEST[ 'page' ] ) && $_REQUEST[ 'page' ] && $_REQUEST[ 'page' ] > 0 )
		{
			return $tbody->show( true );
		}
		if ( $this->javaScript )
		{
			$js = str_replace( ';;', ';', implode( ';', $this->javaScript ) );
			$tbody->add( '<script>jQuery(document).ready(function() {' . $js . '});</script>' );
		}
		return parent::show( $boolPrint );
	}

	//------------------------------------------------------------------------------------
	public function getColumns()
	{
		return $this->columns;
	}

	//------------------------------------------------------------------------------------
	public function getColumn( $strColumnName )
	{
		$strColumnName = strtolower( $strColumnName );

		if ( isset( $this->columns[ $strColumnName ] ) )
		{
			return $this->columns[ $strColumnName ];
		}
		return null;
	}

	//------------------------------------------------------------------------------------
	public function getColumnCount()
	{
		if ( is_array( $this->getColumns() ) )
		{
			return ( int ) count( $this->columns );
		}
		return 0;
	}

	//------------------------------------------------------------------------------------
	public function addColumn( $strFieldName, $strValue = null, $strWidth = null, $strTextAlign = null )
	{

		$col = new TGridColumn( $strFieldName, $strValue, $strWidth, $strTextAlign );
		$col->clearCss();
		$col->setGridId($this->getId());
		$this->columns[ $col->getId()] = $col;
		return $col;
	}

	//------------------------------------------------------------------------------------
	public function addHiddenField( $strFieldName, $strId = null )
	{
		$strId = is_null( $strId ) ? strtolower( $strFieldName ) : $strId;
		$this->hiddenField[ $strFieldName ] = $strId;
	}

	//------------------------------------------------------------------------------------
	public function getHiddenField()
	{
		return $this->hiddenField;
	}

	//------------------------------------------------------------------------------------
	protected function addActionColumn( $strTitle = null )
	{
		$this->columns[ $strTitle ] = new TActionColumn( $strTitle );
	}

	//------------------------------------------------------------------------------------
	public function setTitle( $strValue = null )
	{
		$this->title = $strValue;
	}

	public function getTitle()
	{
		return $this->title;
	}

	//------------------------------------------------------------------------------------
	public function setData( $mixValue = null )
	{
		if ( is_array( $mixValue ) )
		{
			$keys = array_keys($mixValue);
			//if ( !key( $mixValue ) )
			if ( ! $keys[0] )
			{
				$mixValue = null;
			}
		}
		$this->data = $mixValue;
	}

	//---------------------------------------------------------------------------------------
	/**
	* Retorna o array de dados do gride
	*/
	public function getData()
	{
		$res = null;

		if ( is_array( $this->data ) )
		{
			$keys = array_keys( $this->data );
			if( ! is_array($this->data[$keys[0]] ) || isset($this->data[$keys[0]][0] ) )
			{
				return $this->data;
			}
			return $this->data;
		}
		else if( strpos( strtolower( $this->data ), 'select ' ) !== false )
		{

			$bvars = null;
			$bvars = $this->getBvars();

			if ( function_exists( 'recuperarPacote' ) )
			{
				$cache = $this->getCache();
				print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $this->data, $bvars, $res, $cache ) );
			}
			else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
			{
				$res = TPDOConnection::executeSql( $this->data );
			}
		}
		//else if( strpos(strtolower($this->data),'pk_') !== false || strpos(strtolower($this->data),'pkg_') !== false )
		else if( preg_match( '/\.PK\a?/i', $this->data ) > 0 )
		{
			$bvars = $this->getBvars();
			$cache = $this->getCache();
			print_r( recuperarPacote( $this->data, $bvars, $res, $cache ) );
		}
		else if( !is_null( $this->data ) )
		{
			$where = '';

			if ( is_array( $this->getBvars() ) )
			{
				foreach( $this->getBvars() as $k => $v )
				{
					$where .= $where == '' ? '' : ' and ';
					$where .= "($k='$v')";
				}
				$where = $where == '' ? '' : ' where ' . $where;
			}
			$sql = "SELECT * FROM {$this->data} {$where}";
			$cache = $this->getCache();
			$bvars = null;

			if ( function_exists( 'recuperarPacote' ) )
			{
				print_r( $GLOBALS[ 'conexao' ]->executar_recuperar( $sql, $bvars, $res, $cache ) );
			}
			else if( !class_exists( 'TPDOConnection' ) || !TPDOConnection::getInstance() )
			{
				$res = TPDOConnection::executeSql( $sql );
			}
		}

		if ( $res )
		{
			$this->setData( $res );
		}
		return $res;
	}

	//------------------------------------------------------------------------------------
	public function addKeyField( $strNewValue = null )
	{
		if ( $strNewValue )
		{
			if ( is_array( $this->getKeyField() ) )
			{
				if ( array_search( $strNewValue, ( array ) $this->getKeyField() ) === false )
				{
					$this->keyField[] = $strNewValue;
				}
			}
			else
			{
				$aTemp = explode( ',', $strNewValue );

				if ( is_array( $aTemp ) )
				{
					foreach( $aTemp as $v )
					{
						$this->keyField[] = $v;
					}
				}
			//$this->keyField[] = $strNewValue;
			}
		}
	}

	//------------------------------------------------------------------------------------
	public function getKeyField()
	{
		return $this->keyField;
	}

	//------------------------------------------------------------------------------------
	/**
	 * Adicionar bot�o na linha do gride
	 *
	 * $boolSubmitAction = adicionar/remover a fun��o fwFazerAcao(). Padr�o=true
	 *
	 * @param string $strRotulo
	 * @param string $strAction
	 * @param string $strName
	 * @param string $strOnClick
	 * @param string $strConfirmMessage
	 * @param string $strImage
	 * @param string $strImageDisabled
	 * @param string $strHint
	 * @param boolean $boolSubmitAction
	 * @return object> TButton
	 */
	public function addButton( $strRotulo, $strAction = null, $strName = null, $strOnClick = null, $strConfirmMessage = null, $strImage = null, $strImageDisabled = null, $strHint = null, $boolSubmitAction = null )
	{
		if ( is_null( $strName ) )
		{
			$strName = $this->getId() . ucwords( $this->removeIllegalChars( $strRotulo ) );
		}

		if ( is_null( $strAction ) && is_null( $strOnClick ) )
		{
			$strAction = strtolower( $this->getId() . '_' . $strRotulo );
		}
		$this->buttons[ $strName ] = new TButton( $strName, $strRotulo, $strAction, $strOnClick, $strConfirmMessage, $strImage, $strImageDisabled, $strHint, $boolSubmitAction );
		// se o usu�rio adicionar um bot�o, cancelar a cria��o dos bot�es padr�o de alterar e excluir
		$this->enableDefaultButtons( false );
		return $this->buttons[ $strName ];
	}

	//---------------------------------------------------------------------------------------
	public function getButtons()
	{
		return ( array ) $this->buttons;
	}

	//------------------------------------------------------------------------------------
	public function setOnDrawRow( $newValue = null )
	{
		$this->onDrawRow = $newValue;
	}

	//------------------------------------------------------------------------------------
	public function getOnDrawRow()
	{
		return $this->onDrawRow;
	}

	//------------------------------------------------------------------------------------
	public function setOnDrawCell( $newValue = null )
	{
		$this->onDrawCell = $newValue;
	}

	//------------------------------------------------------------------------------------
	public function getOnDrawCell()
	{
		return $this->onDrawCell;
	}

	//------------------------------------------------------------------------------------
	public function setOnDrawHeaderCell( $newValue = null )
	{
		$this->onDrawHeaderCell = $newValue;
	}

	//------------------------------------------------------------------------------------
	public function getOnDrawHeaderCell()
	{
		return $this->onDrawHeaderCell;
	}

	//------------------------------------------------------------------------------------
	public function setOnDrawActionButton( $newValue = null )
	{
		$this->onDrawActionButton = $newValue;
	}

	//------------------------------------------------------------------------------------
	public function getOnDrawActionButton()
	{
		return $this->onDrawActionButton;
	}

	//------------------------------------------------------------------------------------
	public function setUpdateFields( $mixUpdateFields = null )
	{
		if ( $mixUpdateFields )
		{
			if ( is_array( $mixUpdateFields ) )
			{
				foreach( $mixUpdateFields as $k => $v )
				{
					if ( is_numeric( $k ) )
					{
						$k = $v;
						$v = strtolower( $v );
					}
					$this->setUpdateFields( $k . '|' . $v );
				}
			}
			else if( strpos( $mixUpdateFields, ',' ) !== false )
			{
				$a = explode( ',', $mixUpdateFields );
				$this->setUpdateFields( $a );
			}
			else
			{
				$aFields = explode( '|', $mixUpdateFields );

				if ( !isset( $aFields[ 1 ] ) )
				{
					$aFields[ 0 ] = strtoupper( $aFields[ 0 ] );
					$aFields[ 1 ] = strtolower( $aFields[ 0 ] );
				}

				if ( $aFields[ 0 ] != '' )
				{
					$this->updateFields[ $aFields[ 0 ] ] = $aFields[ 1 ];
				}
			}
		}
	}

	//------------------------------------------------------------------------------------
	public function getUpdateFields()
	{
		$arrResult = $this->updateFields;

		if ( $arrResult )
		{
			// adicionar o campo chave na lista de campos a serem atualizados
			if ( $this->getKeyField() )
			{
				$keyValue = '';

				foreach( $this->getKeyField() as $key => $fieldName )
				{
					if ( !in_array( $fieldName, $arrResult ) )
					{
						$this->setUpdateFields( $fieldName );
					}
				}
			}
		}
		return $arrResult;
	}

	//------------------------------------------------------------------------------------
	public function clearUpdateFields()
	{
		$this->updateFields = null;
	}

	//------------------------------------------------------------------------------------
	public function getWidth()
	{
		if ( is_null( $this->width ) )
		{
			return 'auto';
		}
		else
		{
			if ( strpos( $this->width, '%' ) === false )
			{
				$w = preg_replace( '/[^0-9]/', '', $this->width ) . 'px';
				$w = $w == 'px' ? 'auto' : $w;
			}
			else
			{
				return $this->width;
			}
		}
		return $w;
	}

	//---------------------------------------------------------------------------------------
	public function getHeight()
	{
		if ( is_null( $this->height ) )
		{
			return 'auto';
		}
		else
		{
			if ( strpos( $this->height, '%' ) === false )
			{
				$w = preg_replace( '/[^0-9]/', '', $this->height ) . 'px';
				$w = $w == 'px' ? 'auto' : $w;
			}
			else
			{
				return $this->height;
			}
		}
		return $w;
	}

	//------------------------------------------------------------------------------------
	public function setWidth( $strNewValue = null )
	{
		$this->width = $strNewValue;
	}

	//------------------------------------------------------------------------------------
	public function setHeight( $strNewValue = null )
	{
		$this->height = $strNewValue;
	}

	//------------------------------------------------------------------------------------
	public function setActionColumnTitle( $strNewValue = null )
	{
		$this->actionColumnTitle = $strNewValue;
	}

	//------------------------------------------------------------------------------------
	public function getActionColumnTitle( $strNewValue = null )
	{
		if ( is_null( $this->actionColumnTitle ) )
		{
			return htmlentities( 'A��o',null,'ISO-8859-1' );
		}
		return htmlentities( $this->actionColumnTitle,null,'ISO-8859-1' );
	}

	//---------------------------------------------------------------------------------------
	public function getRowData( $intRow = null )
	{
		$aData = array();

		if ( !is_null( $intRow ) )
		{
			foreach( $this->data as $k => $v )
			{
				$aData[ $k ] = $this->data[ $k ][ $intRow ];
			}
		}
		return $aData;
	}

	//---------------------------------------------------------------------------------------
	function setZebrarColors( $strColor1 = null, $strColor2 = null )
	{
		$this->zebrarColors = array( $strColor1, $strColor2 );
	}

	//---------------------------------------------------------------------------------------
	function getZebrarColors( $intColor = null )
	{
		if ( $intColor == 0 || $intColor == 1 )
		{
			return isset( $this->zebrarColors[ $intColor ] ) ? $this->zebrarColors[ $intColor ] : ( ( $intColor == 0 ) ? '#efefef' : '#ffffff' );
		}
		return $this->zebrarColors;
	}

	//---------------------------------------------------------------------------------------
	public function addTextColumn( $strName, $strTitle = null, $strFieldName = null, $strSize = null, $intMaxLength = null, $strMask = null, $strWidth = null, $strAlign = null, $boolReadOnly = null )
	{
		$col = new TGridEditColumn( $strName, $strTitle, $strFieldName, 'text', $strSize, $intMaxLength, $strMask, $strWidth, $strAlign, $boolReadOnly );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//------------------------------------------------------------------------------------
	public function addAutoCompleteColumn( $strName, $strTitle = null, $strFieldName = null, $strSize = null, $intMaxLength = null, $strTablePackage, $strSearchField, $intMinChars = null, $mixUpdateFields = null, $strWidth = null, $strAlign = null, $boolReadOnly = null )
	{
		$this->autocomplete[ $strName ] = new TAutoComplete( $strFieldName, $strTablePackage, $strSearchField, $mixUpdateFields, null, null, 'callBack', $intMinChars );
		return $this->addTextColumn( $strName, $strTitle, $strFieldName, $strSize, $intMaxLength, $strMask, $strWidth, $strAlign, $boolReadOnly );
	}

	//---------------------------------------------------------------------------------------
	/**
	* Adicionar coluna para entrada de datas no gride
	*
	* @param mixed $strName
	* @param mixed $strTitle
	* @param mixed $strFieldName
	* @param mixed $maskType
	* @param mixed $strWidth
	* @param mixed $strAlign
	* @param mixed $boolReadOnly
	* @return TDateColumn
	*/
	public function addDateColumn( $strName, $strTitle = null, $strFieldName = null, $maskType = null, $strWidth = null, $strAlign = null, $boolReadOnly = null )
	{
		$col = new TGridDateColumn( $strName, $strTitle, $strFieldName, $maskType, $strWidth, $strAlign, $boolReadOnly );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//---------------------------------------------------------------------------------------
	public function addNumberColumn( $strName, $strTitle = null, $strFieldName = null, $intSize = null, $intDecimalPlaces = null, $boolFormatInteger = null, $strWidth = null, $strAlign = null, $boolReadOnly = null )
	{
		$col = new TGridNumberColumn( $strName, $strTitle, $strFieldName, $intSize, $intDecimalPlaces, $boolFormatInteger, $strWidth, $strAlign, $boolReadOnly );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//---------------------------------------------------------------------------------------
	/**
	* coluna tipo checkbox

	*
	* @param string $strName
	* @param string $strTitle
	* @param string $strKeyField
	* @param string $strDescField
	* @param boolean $boolReadOnly
	* @return TCheckColumn
	*/
	public function addCheckColumn( $strName, $strTitle = null, $strKeyField, $strDescField = null, $boolReadOnly = null, $boolAllowCheckAll = null )
	{
		if ( !$strKeyField )
		{
			$strKeyField = strtoupper( $strName );
		}
		$col = new TGridCheckColumn( $strName, $strTitle, $strKeyField, $strDescField, $boolReadOnly, $boolAllowCheckAll );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}
	/**
	* coluna tipo radioButton

	*
	* @param string $strName
	* @param string $strTitle
	* @param string $strKeyField
	* @param string $strDescField
	* @param boolean $boolReadOnly
	* @return TRadioButton
	*/
	public function addRadioColumn( $strName, $strTitle = null, $strKeyField, $strDescField = null, $boolReadOnly = null )
	{
		if ( !$strKeyField )
		{
			$strKeyField = strtoupper( $strName );
		}
		$col = new TGridRadioColumn( $strName, $strTitle, $strKeyField, $strDescField, $boolReadOnly );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}
	/**
	* coluna do tipo select
	*
	* @param string $strName
	* @param string $strTitle
	* @param mixed  $mixOptions
	* @param mixed $width
	* @param boolean $boolReadOnly
	* @return TSelectColumn
	*/
	public function addSelectColumn( $strName, $strTitle = null, $strFieldName = null, $mixOptions = null, $strWidth = null, $boolReadOnly = null, $strFirstOptionText = null, $strFirstOptionValue = null, $strKeyField = null, $strDisplayField = null, $strInitialValueField=null )
	{
		$col = new TGridSelectColumn( $strName, $strTitle, $strFieldName, $mixOptions, $strWidth, $boolReadOnly, $strFirstOptionText, $strFirstOptionValue, $strKeyField, $strDisplayField, $strInitialValueField );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//---------------------------------------------------------------------------------------
	public function addMemoColumn( $strName, $strTitle = null, $strFieldName = null, $intMaxLength = null, $intColumns = null, $intRows = null, $boolReadOnly = null, $boolShowCounter = null )
	{
		$col = new TGridMemoColumn( $strName, $strTitle, $strFieldName, $intMaxLength, $intColumns, $intRows, $boolReadOnly, $boolShowCounter );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//---------------------------------------------------------------------------------------
	public function addRowNumColumn( $strName = null, $strTitle = null, $strWidth = null, $strAlign = null )
	{
		$strName = is_null( $strName ) ? 'grid_rownum' : $strName;
		$strTitle = is_null( $strTitle ) ? 'N�' : $strTitle;
		$strAlign = is_null( $strAlign ) ? 'center' : $strAlign;
		$col = new TGridRowNumColumn( $strName, $strTitle, $strWidth, $strAlign );
		$this->columns[ strtolower( $strName )] = $col;
		return $col;
	}

	//---------------------------------------------------------------------------------------
	public function getRowCount()
	{
		$res = $this->getData();

		if ( $res )
		{
			$keys = array_keys($res);
			return count( $res[ $keys[0] ] );
		}
		return 0;
	}

	//---------------------------------------------------------------------------------------
	public function setReadOnly( $boolNewValue = null )
	{
		$boolNewValue = $boolNewValue === true ? true : false;
		$this->readOnly = $boolNewValue;
	}

	//---------------------------------------------------------------------------------------
	public function getReadOnly()
	{
		return $this->readOnly;
	}

	//---------------------------------------------------------------------------------------
	public function setMaxRows( $intNewValue = null )
	{
		$this->maxRows = $intNewValue;
	}

	//---------------------------------------------------------------------------------------
	public function getMaxRows()
	{
		return ( int ) $this->maxRows;
	}

	//---------------------------------------------------------------------------------------
	protected function setNavButtons( $tbody, $qtdColumns )
	{
		if ( !$this->url || !$this->getMaxRows() || $this->numPages == 1 )
		{
			return;
		}
		/*
			Desabilitei os botoes next, prior etc.. porque quando o clica no titulo
			da coluna para ordenar, os bot�es estavam sendo ordenados tambem, ficando
			na parte superior do gride.
		*/
		/*
		 $prev 				= $this->currentPage -1;
		 $next 				= $this->currentPage +1;
		 //$jsOnClick 			= 'jQuery("#'.$this->getId().'_loading").show();jQuery("#'.$this->getId().'_jumpToPage").attr("disable",true);jQuery("#'.$this->getId().'_first_page").attr("disable",true);jQuery("#'.$this->getId().'_prev_page").attr("disable",true);jQuery("#'.$this->getId().'_next_page").attr("disable",true);jQuery("#'.$this->getId().'_last_page").attr("disable",true);';
		 //sleep(3);
		$jsOnClick 			= 'jQuery("#'.$this->getId().'_loading").show();jQuery("#'.$this->getId().'_jumpToPage").hide();jQuery("#'.$this->getId().'_first_page").hide();jQuery("#'.$this->getId().'_prev_page").hide();jQuery("#'.$this->getId().'_next_page").hide();jQuery("#'.$this->getId().'_last_page").hide();';
		 // se o proprio modulo fizer include da classe banco, config etc, n�o precisa ser chamado pelo index da aplicacao
		 if( defined( APLICATIVO ) )
		 {
			 $urlFirst			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":1});';
			 $urlPrev			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$prev.'});';
			 $urlNext 			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$next.'});';
			 $urlLast			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load("'.$this->url.' tbody>tr",{ "ajax":1,"page":'.$this->numPages.'});';
		}
		else
		{
			 $urlFirst			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":1,"modulo":"'.$this->url.'"});';
			 $urlPrev			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$prev.',"modulo":"'.$this->url.'"});';
			 $urlNext 			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$next.',"modulo":"'.$this->url.'"});';
			 $urlLast			= $jsOnClick.'jQuery("#'.$this->getId().'_table > tbody").load(app_url+app_index_file+" tbody>tr",{ "ajax":1,"page":'.$this->numPages.',"modulo":"'.$this->url.'"});';
		}
		   $btnFirst 			= new TButton($this->getId().'_first_page','<<'	,null,$urlFirst,null,'page-first.png','page-first_disabled.png','Primeira p�gina');
		   $btnPrev 			= new TButton($this->getId().'_prev_page','<'	,null,$urlPrev,null ,'page-prev.png' ,'page-prev_disabled.png','P�gina anterior');
		   $btnNext 			= new TButton($this->getId().'_next_page','>'	,null,$urlNext,null ,'page-next.png' ,'page-next_disabled.png','Pr�xima p�gina');
		   $btnLast 			= new TButton($this->getId().'_last_page','>>'	,null,$urlLast,null ,'page-last.png' ,'page-last_disabled.png','�ltima p�gina');

		   if( $prev == 0 )
		   {
			$btnPrev->setEnabled(false);
			$btnFirst->setEnabled(false);
		   }
		   if( $next == 0 )
		   {
			$btnNext->setEnabled(false);
		   }
		   if( $this->currentPage == $this->numPages)
		   {
			$btnNext->setEnabled(false);
			$btnLast->setEnabled(false);
		   }
		   */
		$select = null;

		if ( $this->numPages > 1 )
		{
			$aPages = array();

			for( $i = 1; $i <= $this->numPages; $i++ )
			{
				$aPages[ $i ] = $i;
			}
			$select = new TSelect( $this->getId() . '_jumpToPage', $aPages, null, true );
			$select->setcss( 'margin-left', '5px' );
			$select->setcss( 'margin-right', '5px' );
			$select->setProperty( 'noClear', 'true' ); // evitar que a fun��o fwClearFields() limpe o seu vavalor
			$select->setValue( $this->currentPage );
			// estes parametros devem ser sempre passados na atualiza��o da p�gina do gride
			//$arrRequest = array( 'ajax' => 1, 'page' => 'this.value', 'TGrid' => 1 );
			$arrRequest = array( 'ajax' => 1, 'TGrid' => 1, 'gridId' => $this->getId() );
			foreach( $_REQUEST as $k => $v )
			{
				if ( $k != 'modulo' && $k != 'ajax' && $k != 'page' && $k != 'PHPSESSID' && $k != 'cookieauth' )
				{
					$arrRequest[ $k ] =$v;
				}
			}
			$arrRequest[ 'gridId' ]=$this->getId();
			$jsOnClick = isset( $jsOnClick ) ? $jsOnClick : '';
			if ( defined( APLICATIVO ) ) // j� fez o includes dos arquivos ncess�rios
			{
				$arrRequest['url'] = $this->url;
			}
			else
			{
				$arrRequest[ 'modulo' ] = $this->getUrl();
			}
			$select->setEvent( 'onChange', $jsOnClick . 'fwGridPageChange(this.value,'.json_encode($arrRequest).')');
			$select->setEvent( 'onKeyUp', 'var key = fwGetKey(event); if( key >= 33 && key <= 40) { this.onchange(); }' );
		}
		$div = new TElement( 'div' );
		$div->setId( $this->getId() . '_div_nav_buttons' );
		$div->setcss( 'text-align', 'left' );
		$div->setcss( 'border', '1px solid gray' );
		$div->setcss( 'padding-top', '2px' );
		$div->setcss( 'width', '100%' );
		$div->setcss( 'float', 'left' );
		$div->add( 'P�gina:' );
		$div->add( $select );

		$btnFirst 			= new TButton($this->getId().'_first_page','<<'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'first') ).')',null,'page-first.png',null,'Primeira p�gina');
		$div->add( $btnFirst,false );
		$btnPrev	= new TButton($this->getId().'_prev_page','<'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'prior') ).')',null ,'page-prev.png' ,null,'P�gina anterior');
		$div->add( $btnPrev,false );
	   	$btnNext 	= new TButton($this->getId().'_next_page','>'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'next') ).')',null ,'page-next.png',null,'Pr�xima p�gina');
		$div->add( $btnNext,false );
		$btnLast 			= new TButton($this->getId().'_last_page','>>'	,null,'fwGridChangePage('. json_encode(array('id'=>$this->getId(),'action'=>'last') ).')',null ,'page-last.png' ,null,'�ltima p�gina');
		$div->add( $btnLast,false );

		$img = new TButton($this->getId().'_loading',null,null,null,null,'carregando.gif');
		$img->setCss('display','none');
		$div->add($img);
		/*
		$div->add($btnFirst);
		$div->add($btnPrev);
		$div->add($select);
		$div->add($btnNext);
		$div->add($btnLast);
		*/

		// imagem processando durante as requisi��es ajax
		/*
		$img = new TElement('img');
		$img->setId($this->getId().'_loading');
		$img->setcss('display'	,'none');
		$img->setcss('float'	,'left');
		$img->setCss('height'	,'20px');
		$img->setCss('width'	,'135px');
		$img->setProperty('src','base/imagens/processando.gif');
		$div->add($img);
		*/
		// criar uma linha <tr> no final do gride para mostrar os bot�es de pagina��o
		$tbody->add( $row = new TTableRow() );
		$row->setId( $this->getId() . '_tr_nav_buttons' );
		$row->clearCss();
		$cell = $row->addCell();
		$cell->setId( $this->getId() . '_td_nav_buttons' );
		$cell->clearCss();
		$cell->setClass( 'fwHeaderBar' );
		$cell->setCss( 'height', '26px' );
		$cell->setProperty( 'colspan', $qtdColumns );
		// adicionar a div no td
		$cell->add( $div );
	}

	//---------------------------------------------------------------------------------------
	public function setBvars( $arrBvars = null )
	{
		$this->bvars = $arrBvars;
	}

	//---------------------------------------------------------------------------------------
	public function getBvars()
	{
		return $this->bvars;
	}

	//---------------------------------------------------------------------------------------
	public function setCache( $intNewValue = null )
	{
		$this->cache = $intNewValue;
	}

	//---------------------------------------------------------------------------------------
	public function getCache()
	{
		return $this->cache;
	}

	//---------------------------------------------------------------------------------------
	/**
	* Define se os botoes Alterar e Excluir ser�o exibidos quando n�o for
	* adicionado nenhum bot�o
	*
	* @param mixed $boolNewValue
	*/
	//public function setUseDefaultButtons($boolNewValue=null)
	//{
	//	$this->useDefaultButtons = $boolNewValue;
	//}
	//---------------------------------------------------------------------------------------
	public function getCreateDefaultButtons()
	{
		return is_null( $this->createDefaultButtons ) ? true : $this->createDefaultButtons;
	}
	/**
	* Define se os botoes Alterar e Excluir ser�o exibidos quando n�o for
	* adicionado nenhum bot�o
	*
	* @param mixed $boolNewValue
	*/
	public function enableDefaultButtons( $boolNewValue = null )
	{
		$this->createDefaultButtons = is_null( $boolNewValue ) ? true : $boolNewValue;
	}

	//---------------------------------------------------------------------------------------
	/**
	* Define a utiliza��o das imagens alterar.gif e lixeira.gif do diretorio base/imagens
	*
	* @param mixed $boolNewValue
	*/
	public function setUseDefaultImages( $boolNewValue = null )
	{
		$this->useDefaultImages = $boolNewValue;
	}

	//---------------------------------------------------------------------------------------
	public function getUseDefaultImages()
	{
		return is_null( $this->useDefaultImages ) ? true : $this->useDefaultImages;
	}

	//---------------------------------------------------------------------------------------
	public function setExportExcel( $boolNewValue = null )
	{
		$this->exportExcel = is_null( $boolNewValue ) ? true : $boolNewValue;
	}

	public function getExportExcel()
	{
		return $this->exportExcel;
	}

	//---------------------------------------------------------------------------------------
	public function autoCreateColumns()
	{
		$res = $this->getData();

		if ( $res )
		{
			$keys = array_keys($res);
			$this->addKeyField( $keys[0] );
			$this->setUpdateFields( $keys[0] );

			foreach( $res as $k => $dados )
			{
				$this->addColumn( $k, $k );
			}
		}
	}

	//---------------------------------------------------------------------------------------
	public function setForm( TForm $frm = null, $boolShowCollapsed = null )
	{
		$this->form = $frm;
		$this->setShowCollapsed( $boolShowCollapsed );
	}

	public function getForm()
	{
		return $this->form;
	}

	//---------------------------------------------------------------------------------------
	public function setUrl( $strNewValue = null )
	{
		$this->url = $strNewValue;
	}

	public function getUrl()
	{
		return $this->url;
	}

	//------------------------------------------------------------------------------------------------
	// Configura��es do grid offline
	//-------------------------------------------------------------------------------------
	protected function configOffLine()
	{
		$frm = $this->getForm();
		if ( isset( $_REQUEST[ $this->getId() . 'Width' ] ) )
		{
			$frm->setWidth( $_REQUEST[ $this->getId() . 'Width' ] );
		}
		$frm->setFormGridOffLine(true);

		$frm->setId( $this->getId() . '_form' );
		$frm->setAttribute( 'idGridOffLine',$this->getId() );
		$frm->setName( $this->getId() . '_form' );
		$frm->setFlat( true );
		$frm->setFade( false );
		$frm->setAction( null );
		$frm->setShowCloseButton( false );
		$frm->setShowHeader( !$frm->getTitle() == "" );
		//$frm->showOnlyTagForm = true;
		$frm->setAutoIncludeJsCss( false );
		$frm->setOverflowY( 'hidden' );
		$frm->setCss( 'border', '0px' );
		$frm->body->setCss( 'border-bottom', '0px' );
		$frm->footer->setCss( 'border', '0px' );
		$frm->cssFiles = null;
		$frm->jsFiles = null;
		$frm->removeMessageArea();

		if ( $this->getShowCollapsed() )
		{
			$frm->addJavascript( 'jQuery("#' . $this->getId() . '_img_show_hide_form").click();' );
		}
		$this->columns = null;
		$strFirstKeyField = null;
		$noClearFields = null;

		// definir a chave prim�ria do gride se n�o tiver sido passada
		if ( $keyField = $this->getKeyField() )
		{
			$strFirstKeyField = strtoupper( $keyField[ 0 ] );

			foreach( $keyField as $v )
			{
				$frm->addHiddenField( strtolower( $v ) );
			}
		}
		else
		{
			if ( $res = $this->getData() )
			{
				$keys = array_keys($res);
				$strFirstKeyField = strtoupper( $keys[0] );
				$frm->addHiddenField( strtolower( $strFirstKeyField ) );
			}
		}
		$this->keyField = null;
		// bot�o de esconder/exibir o formul�rio
		$this->titleCell->add( '<img id="' . $this->getId() . '_img_show_hide_form" onclick="if( jQuery(\'#' . $this->getId() . '_form_area\').is(\':visible\') ){this.src=this.src.replace(\'Collapse\',\'Expand\');jQuery(\'#' . $this->getId() . '_form_area\').hide(\'slow\');jQuery(\'#' . $this->getId() . '_collapsed\').val(1) } else { this.src=this.src.replace(\'Expand\',\'Collapse\');jQuery(\'#' . $this->getId() . '_form_area\').show(\'fast\');jQuery(\'#' . $this->getId() . '_collapsed\').val(0);}" src="' . $this->getBase() . 'imagens/groupCollapse.jpg" width="16px" height="16px" style="float:right;cursor:pointer;" title="Abrir/Fechar">' );

		// legenda do rodap�
		$this->footerCell->add( '<table border="0" style="float:left;border:none;" cellspacing="0" cellpadding="0">
		<tr>
		<td width="8" height="8" bgcolor="' . $this->getSavedRecordColor() . '"></td><td style="font-size:10px;">Salvo</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getEditedRecordColor() . '"></td><td style="font-size:10px;">Alterado</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getNewRecordColor() . '"></td><td style="font-size:10px;">Novo</td><td width="10px"></td>
		<td width="8" height="8" bgcolor="' . $this->getDeletedRecordColor() . '"></td><td style="font-size:10px;">Excluido</td>
		</tr>
		</table>' );
		// coluna de controle de registro incluido, alterado e exclu�do
		$controlAEI = strtoupper( $this->getId() . '_AEI' );

		if ( is_array( $frm->getDisplayControls() ) )
		{
			$strJquery = '';
			$aFieldNames = null;
			$col = $this->addColumn( $controlAEI, '' );
			$col->setSortable(false);

			$fields = $this->extractFormFields($frm);
			// criar as colunas do gride utilizando os campos do formul�rio
			foreach( $fields as $objField )
			{
				$field 		= $objField->field;
				$label 		= $objField->label;
				$fieldName 	= $field->getId();

				$col=null;
				if( $field->getFieldType() == 'hidden'  )
				{

					if ( strtoupper( $fieldName ) != 'FW_BACK_TO' )
					{
						$field->setAttribute( 'gridOfflineField', 'true' );

						// se n�o for campo chave do grid, adicionar tag noClear para a fun��o frm->clearFields() apos a edi��o n�o limpar os campos ocultos
						if ( !preg_match( '/,' . $fieldName . ',/i', ',' . implode( ',', $keyField ) . ',' ) )
						{
							$field->setAttribute( 'noClear', 'true' );
							$noClearFields[] = $fieldName;
						}
						else
						{
							$this->addKeyField( strtoupper( $fieldName ) );
							$aFieldNames[] = $fieldName;
						}

						// considerar o primeiro campo oculto como a chave do gride
						if ( is_null( $strFirstKeyField ) )
						{
							$strFirstKeyField = strtoupper( $fieldName );
						}
					}
					else
					{
						$field->setAttribute( 'noClear', 'true' );
					}
				}
				else if ( $field->getFieldType() == 'edit' || $field->getFieldType() == 'number' || $field->getFieldType() == 'date' || $field->getFieldType() == 'cpf' || $field->getFieldType() == 'cpfcnpj' || $field->getFieldType() == 'cnpj' || $field->getFieldType() == 'fone' || $field->getFieldType() == 'memo' || $field->getFieldType() == 'cep' )
				{
					$field->setAttribute( 'gridOfflineField', 'true' );
					$label = str_replace( ':', '', $label );

					if ( $field->getFieldType() == 'number' && $field->getDecimalPlaces() > 0 )
					{
						$align = 'right';
					}
					$align = $field->getAttribute( 'grid_algin' );
					$col = $this->addColumn( strtoUpper( $fieldName ), $label, null, $align );
					$strJquery .= $strJquery == '' ? ' ' : ',';
					$strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
					$aFieldNames[] = $fieldName;

					// definir o foco para o primeiro campo do formul�rio do grid-offline
					if ( !$frm->getFocusField() )
					{
						$frm->setFocusField( $fieldName );
					}
				}
				else if( $field->getFieldType() == 'select' )
				{
					$field->setAttribute( 'gridOfflineField', 'true' );
					$aFieldNames[] = $fieldName;
					$label = str_replace( ':', '', $label );

                    $c = $field->getAttribute('grid_column');
                    if( $c )
                    {
						$this->addColumn( strtoupper($c) , $label );
						$field->addEvent('onChange',"jQuery(\"#\"+this.id+\"_temp\").val( this.options[this.selectedIndex].text )");
						$strJquery .= $strJquery == '' ? ' ' : ',';
						$strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    }
                    else
                    {
						$col = $this->addColumn( strtoUpper( $fieldName . '_text' ), $label );
						$strJquery .= $strJquery == '' ? ' ' : ',';
						$strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
                    }
				}
				else if( $field->getFieldType() == 'memo' )
				{
					$field->setAttribute( 'gridOfflineField', 'true' );
					$label = str_replace( ':', '', $label );
					$col = $this->addMemoColumn( $fieldName, $label, strtoupper( $fieldName ), $field->getMaxLenght(), $field->getColumns(), $field->getRows(), true, false );
					$strJquery .= $strJquery == '' ? ' ' : ',';
					$strJquery .= '"' . $fieldName . '":jQuery("#' . $fieldName . '").val()';
					$aFieldNames[] = $fieldName;
				}
				if( isset($col) && isset( $field ) && $field->getAttribute('grid_hidden') == 'true' )
				{
					$col->setVisible(false);
				}
			}

			if ( is_null( $strFirstKeyField ) )
			{
				$strFirstKeyField = strtolower( $this->getId() . '_PK' );
				$this->addKeyField( strtoupper( $strFirstKeyField ) );
				$frm->addHiddenField( $strFirstKeyField );
				$aFieldNames[] = $strFirstKeyField;
			}

			// adicionar os campos chave no evento do bot�o Adicionar para enviar o seu valor
			if( is_array( $this->getKeyField() ))
			{
				foreach( $this->getKeyField() as $k => $v )
				{
					if ( !$this->getUpdateFields() )
					{
						$this->setUpdateFields( strtoupper( $v ) );
					}
					$strJquery .= $strJquery == '' ? ' ' : ',';
					$strJquery .= '"' . strtolower( $v ) . '":jQuery("#' . strtolower( $v ) . '").val()';
				}
			}

			// campos ocultos que devem ser sempre submetidos ao executar uma a��o do grid offline
			if ( is_array( $noClearFields ) )
			{
				foreach( $noClearFields as $k => $v )
				{
					$strJquery .= $strJquery == '' ? ' ' : ',';
					$strJquery .= '"' . strtolower( $v ) . '":jQuery("#' . strtolower( $v ) . '").val()';
				}
			}

			if ( !$this->getUpdateFields() )
			{
				$frm->addMessage( 'Para o funcionamento do grid offline, � necess�rio definir um campo chave.\nAdicione um campo oculto no formul�rio anexado ao gride com o nome do campo chave.' );
			}

			if ( $this->getUrl() )
			{
				// postar sempre o width do grid
				$strJquery .= ',"' . $this->getId() . 'Width":"' . $frm->getWidth() . '"';
				// definir a largura do grid
				$this->setWidth( $frm->getWidth() );

				if ( $this->getShowAdicionarButton() )
				{
					$frm->addButton( ($_REQUEST['action']=='edit'?"Salvar Altera��o":"Adicionar"), null, 'btn' . $this->getId() . 'Save', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $_POST[ 'parent_field' ] . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $_POST[ 'parent_field' ] . '","action":"save","subform":1,' . $strJquery . '} );' );
				}
				$frm->addButton( ($_REQUEST['action']=='edit'?"Cancelar Altera��o":"Limpar"), null, 'btn' . $this->getId() . 'Clear', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $_POST[ 'parent_field' ] . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $_POST[ 'parent_field' ] . '","action":"clear","subform":1,' . $strJquery . '} );' );
				$frm->addButton( 'Desfazer', null, 'btn' . $this->getId() . 'ClearAll', 'jQuery("#' . $frm->getId() . '_footer").html(fw_img_processando2);jQuery("#' . $_POST[ 'parent_field' ] . '").load(app_url+app_index_file,{"ajax":0,"gridOffline":"1","modulo":"' . $this->getUrl() . '","parent_field":"' . $_POST[ 'parent_field' ] . '","action":"clearAll","subform":1,' . $strJquery . '} );', 'Esta a��o cancela todas as opera��es de inclus�o, altera��o e exclus�o\nrealizadas no gride antes da �ltima grava��o.\n\n Confirma ?\n', null, null, null, null, 'Desfazer todas as altera��es/inclus�es e voltar os dados para a situa��o original!' );
				$this->bodyCell->add( '<span id="' . $this->getId() . '_form_area">' );
				$this->bodyCell->add( $frm );
				$this->bodyCell->add( '</span>' );

				// adicionar os bot�es de alterar e excluir no gride
				if ( $this->getCreateDefaultEditButton() )
				{
					$this->addButton( 'Alterar', 'edit', 'btn' . $this->getId() . '_edit', '()', null, 'editar.gif', 'alterar_bw.gif', 'Alterar' );

				}

				if ( $this->getCreateDefaultDeleteButton() )
				{
					$this->addButton( 'Excluir', 'delete', 'btn' . $this->getId() . '_delete', '()', 'Confirma exclus�o ?', 'lixeira.gif', 'lixeira_bw.gif', 'Excluir' );
				}
			}
			else
			{
				//$frm->addMessage('Para o funcionamento do grid offline, � necess�rio definir o parametro $strRequestUrl da classe TGrid');
				print 'Para o funcionamento do grid offline,<br>� necess�rio definir o parametro $strRequestUrl da classe TGrid';
			}

			// recuperar da sess�o os dados e definir como $res para o grid
			// fazer a inclus�o, altera��o e exclus�o
			if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'save' )
			{
				if ( $frm->validate() )
				{
					if ( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] )
					{
						$res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
					}
					else
					{
						$res = array();
					}
					// o gride pode ter varias keyfields, assumir a primeira como chave e verificar se a primeira foi postada
					$aKeys = $this->getKeyField();
					$key = strtolower( $aKeys[ 0 ] );
					$k = false;

					if ( isset( $res[ strtoupper( $key )] ) )
					{
						$k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );
					}

					if ( $k === false )
					{
						// inclus�o
						//gravar na sess�o os dados postados
						$lower = 0;

						if ( isset( $res[ $aKeys[ 0 ] ] ) && is_array( $res[ $aKeys[ 0 ] ] ) )
						{
							foreach( $res[ $aKeys[ 0 ] ] as $key => $value )
							{
								if ( $value <= $lower )
								{
									$lower = $value;
								}
							}
						}
						$_POST[ strtolower( $aKeys[ 0 ] )] = ( $lower - 1 );
					}

					foreach( $aFieldNames as $key => $fieldName )
					{
						if ( $k === false ) // inclusao
						{
							$res[ strtoupper( $fieldName )][] = utf8_decode( $_POST[ $fieldName ] );
						}
						else // altera��o
						{
							$res[ strtoupper( $fieldName )][ $k ] = utf8_decode( $_POST[ $fieldName ] );
						}

						$field = $frm->getField( $fieldName );
						if ( $field->getFieldType() == 'select' )
						{
   							$c = $field->getAttribute('grid_column');
							//$opt = $frm->getField($fieldName)->getOptions();
							if ( $k === false )
							{
								//$res[strtoupper($fieldName.'_text')][] = $opt[$frm->getField($fieldName)->getValue()];
								if( $c )
								{
                                	if( $_POST[$fieldName] )
                                	{
                                		$res[strToUpper($c)][] = $_POST[$fieldName.'_temp'];
                                	}
                                	else
                                	{
                                		$res[strToUpper($c)][] = '';
                                	}
								}
								else
								{
								$res[ strtoupper( $fieldName . '_text' )][] = $frm->getField( $fieldName )->getText();
							}
							}
							else
							{
								//$res[strtoupper($fieldName.'_text')][$k] = $opt[$frm->getField($fieldName)->getValue()];
								if( $c )
								{
	                                if( $_POST[$fieldName] )
	                                {
                                		$res[strToUpper($c)][$k] = $_POST[$fieldName.'_temp'];
	                                }
	                                else
	                                {
                                		$res[strToUpper($c)][$k] = '';
	                                }
								}
								else
								{
								$res[ strtoupper( $fieldName . '_text' )][ $k ] = $frm->getField( $fieldName )->getText();
							}
						}
					}
					}

					// adicionar / alterar a coluna de controle de Inc, Alt, Exc
					if ( $k === false )
					{
						$res[ $controlAEI ][] = 'I';
					}
					else
					{
						// marcar como alterado somente registros que j� existirem no banco de dados
						if ( $res[ $strFirstKeyField ][ $k ] > 0 )
						{
							$res[ $controlAEI ][ $k ] = 'A';
						}
					}
					$frm->clearFields();
					$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
				}
			}
			elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'edit' )
			{
				$aKeys = $this->getKeyField();
				$key = strtolower( $aKeys[ 0 ] );
				$res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];

				if ( is_array( $res[ strtoupper( $key )] ) )
				{
					$k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );
				}

				foreach( $aFieldNames as $key => $fieldName )
				{
					$frm->setValue( $fieldName, $res[ strtoupper( $fieldName )][ $k ] );
				}
			}
			elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'clear' )
			{
				$frm->clearFields();
			}
			elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'delete' )
			{
				$aKeys = $this->getKeyField();
				$key = strtolower( $aKeys[ 0 ] );
				$res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
				$k = array_search( $_POST[ $key ], $res[ strtoupper( $key )] );

				// se ja estiver excluido, recuperar o registro
				if ( $res[ $controlAEI ][ $k ] == 'E' )
				{
					$res[ $controlAEI ][ $k ] = 'A';
					$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
					$frm->clearFields();
				}
				else
				{
					if ( $k > -1 )
					{
						// se ainda n�o existir no banco de dados pode excluir do gride, sen�o s� marca para exclus�o quando o gride for processado
						if ( $res[ strtoupper( $key )][ $k ] < 0 )
						{
							foreach( $res as $fieldName => $value )
							{
								$res[ $fieldName ][ $k ] = null;
								unset( $res[ $fieldName ][ $k ] );
							}
							unset( $res[ $controlAEI ][ $k ] );
						}
						else
						{
							$res[ $controlAEI ][ $k ] = 'E';
						}

						$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
						$frm->clearFields();
					}
				}
			}
			elseif( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'clearAll' )
			{
				$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = null;
				$frm->clearFields();
			}
		}

		// se ainda n�o existir na sess�o os dados offline, ler do banco os valores j� gravados e adicionar na sess�o
		if ( !isset( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] ) || !$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] && $this->getData() )
		{

			$data = $this->getData();
			$res = null;

			if ( $data )
			{
				foreach( $data[ $strFirstKeyField ] as $k => $v )
				{
					foreach( $aFieldNames as $key => $fieldName )
					{
						$field = $frm->getField( $fieldName );
						if ( $field->getFieldType() == 'select' )
						{

							$c = $field->getAttribute('grid_column');
							if( $c )
							{
								$res[ strtoupper( $c ) ][] = $data[ strToUpper($c) ][ $k ];
							}
							else
							{
								//echo $fieldName.'='.$frm->getField( $fieldName )->getText( $data[ strtoupper( $fieldName )][ $k ]).'<br>';
							$res[ strtoupper( $fieldName . '_text' )][] = $frm->getField( $fieldName )->getText( $data[ strtoupper( $fieldName )][ $k ] );
						}
						}
						$res[ strtoupper( $fieldName )][] = $data[ strtoupper( $fieldName )][ $k ];
					}
					$res[ $controlAEI ][] = '';
				}
			}
			$_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] = $res;
		}

		if ( isset( $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()] ) )
		{
			$res = $_SESSION[ APLICATIVO ][ 'offline' ][ $this->getId()];
		}

		if ( isset( $res ) )
		{
			$this->setData( $res );
		}
	/*
	if ($res)
	{
		// evitar scroll do formulario
		if( $this->getHeight() == 'auto' || $this->getHeight() == '100%')
		{
			$this->setHeight('120px');
		}
	}
	*/
	}

	//------------------------------------------------------------------------------------------------
	public function setNewRecordColor( $newColor = null )
	{
		$this->newRecordColor = $newColor;
	}

	//------------------------------------------------------------------------------------------------
	public function getNewRecordColor()
	{
		return is_null( $this->newRecordColor ) ? 'blue' : $this->newRecordColor;
	}

	//------------------------------------------------------------------------------------------------
	public function setEditedRecordColor( $strNewValue = null )
	{
		$this->editedRecordColor = $strNewValue;
	}

	public function getEditedRecordColor()
	{
		return is_null( $this->editedRecordColor ) ? '#FF9900' : $this->editedRecordColor;
	}

	//------------------------------------------------------------------------------------------------
	public function setSavedRecordColor( $strNewValue = null )
	{
		$this->savedRecordColor = $strNewValue;
	}

	//------------------------------------------------------------------------------------------------
	public function getSavedRecordColor( $strNewValue = null )
	{
		return is_null( $this->savedRecordColor ) ? '#009933' : $this->savedRecordColor;
	}

	//------------------------------------------------------------------------------------------------
	public function getDeletedRecordColor()
	{
		return is_null( $this->deletedRecordColor ) ? '#FF0000' : $this->deletedRecordColor;
	}

	//------------------------------------------------------------------------------------------------
	/**
	* Define o nome de uma fun��o php que a classe TGrid ir� executar passando a classe TAutocomplete, o array de dados ($res) referente a linha atual, o objeto celula e o objeto coluna
	*
	* @param mixed $strNewValue
	*/
	public function setOnGetAutocompleteParameters( $strNewValue = null )
	{
		$this->onGetAutocompleteParameters = $strNewValue;
	}

	public function getOnGetAutocompleteParameters()
	{
		return $this->onGetAutocompleteParameters;
	}

	//------------------------------------------------------------------------------------------------
	public function getFooter()
	{
		return $this->footerCell;
	}

	//-------------------------------------------------------------------------------------------------
	public function addFooter( $strValor = null )
	{
		if ( !is_null( $strValor ) )
		{
			$this->footerCell->add( $strValor );
		}
	}

	//-------------------------------------------------------------------------------------------------
	public function setFooter( $strValor = null )
	{
		$this->footerCell->clearChildren();
		$this->addFooterCell( $strValor );
	}

	//------------------------------------------------------------------------------------------------
	public function setSortable( $boolNewValue = null )
	{
		$this->sortable = ( bool ) $boolNewValue;
	}

	//------------------------------------------------------------------------------------
	public function getSortable()
	{
		return $this->sortable;
	}

	//------------------------------------------------------------------------------------
	public function addExcelHeadField( $strLabel, $strFieldName )
	{
		$this->excelHeadFields[ $strLabel ] = $strFieldName;
	}

	//------------------------------------------------------------------------------------
	public function getExcelHeadField($boolUtf8=false)
	{
		if( $boolUtf8 && is_array($this->excelHeadFields ) )
		{
		    foreach($this->excelHeadFields as $k=>$v)
		    {
				$arrTemp[utf8_encode($k)] = utf8_encode($v);
			}
			return $arrTemp;
		}
		return $this->excelHeadFields;
	}

	//-------------------------------------------------------------------------------------
	public function getTitleCell()
	{
		return $this->titleCell;
	}

	//------------------------------------------------------------------------------------
	public function setShowCollapsed( $boolNewValue = null )
	{
		$this->showCollapsed = ( $boolNewValue === true ) ? true : false;
	}

	//------------------------------------------------------------------------------------
	public function getShowCollapsed()
	{
		if ( isset( $_REQUEST[ $this->getId() . '_collapsed' ] ) )
		{
			$this->showCollapsed = ( $_REQUEST[ $this->getId() . '_collapsed' ] == '1' );
		}
		return $this->showCollapsed;
	}

	//------------------------------------------------------------------------------------
	public function getData2Excel()
	{
		$res = $this->getData();
        //return $res;

		if ( !is_array( $res ) )
		{
			return null;
		}
		$result = null;
		if( $this->getExportFullData() )
		{
			return $res;
		}
		$keys =  array_keys($res);

/*if( $this->getId() =='idGride')
{
	print_r($res);
	echo '<hr>';
	echo 'key e keys<br>';
	echo '$res[ key( $res )]<br>';
	echo 'Primeira chave =  '.key( $res ).'<br>';
	echo 'ou Primeira chave =  '.$keys[0].'<br>';
	echo '<hr>';
}
*/
		foreach( $res[ $keys[0] ] as $k => $v )
		{
			foreach( $this->getColumns() as $name => $objColumn )
			{
				$colName = strtoupper( $objColumn->getFieldName() );
				if ( isset( $res[ $colName ] ) )
				{
					if ( $objColumn->getColumnType() != 'hidden' && $objColumn->getVisible() )
					{
						$colTitle = $objColumn->getTitle() ? $objColumn->getTitle() : $colName;
						$result[ utf8_encode($colTitle) ][ $k ] = $res[ $colName ][ $k ];
					}
				}
			}
		}
		return $result;
	}

	//------------------------------------------------------------------------------------
	public function setCreateDefaultEditButton( $boolNewValue = null )
	{
		$this->createDefaultEditButton = $boolNewValue;
	}

	public function getCreateDefaultEditButton( $boolNewValue = null )
	{
		return is_null( $this->createDefaultEditButton ) ? true : $this->createDefaultEditButton;
	}

	//------------------------------------------------------------------------------------
	public function setCreateDefaultDeleteButton( $boolNewValue = null )
	{
		$this->createDefaultDeleteButton = $boolNewValue;
	}

	public function getCreateDefaultDeleteButton( $boolNewValue = null )
	{
		return is_null( $this->createDefaultDeleteButton ) ? true : $this->createDefaultDeleteButton;
	}

	//------------------------------------------------------------------------------------
	function setShowAdicionarButton( $boolNewValue = null )
	{
		$this->showAdicionarButton = $boolNewValue;
	}

	function getShowAdicionarButton()
	{
		return ( $this->showAdicionarButton === false ? false : true );
	}

	//------------------------------------------------------------------------------------
	public function setNoWrap( $boolNewValue = null )
	{
		$this->noWrap = $boolNewValue;
	}

	public function getNoWrap()
	{
		return ( $this->noWrap === true ) ? true : $this->noWrap;
	}
	public function setNoDataMessage($strNewValue=null)
	{
		$this->noDataMessage = $strNewValue;
	}
	public function getNoDataMessage()
	{
		return $this->noDataMessage;
	}
	/**
	* Ordenar arrays
	* $order pode ser: up ou down
	*
	* @param array $array
	* @param string $coluna
	* @param string $order
	*/
	public function sortArray($array=null,$coluna=null,$order=null)
	{
		if(!is_array($array) || is_null( $coluna ) || $coluna == '' )
		{
			return $array;
		}
		if(!$array[$coluna])
		{
			$coluna = strtoupper( $coluna );
			if( !$array[$coluna])
			{
				return $array;
			}
		}
		$order = is_null($order) ? 'up': $order;

		if( count($array[$coluna])==1)
			return $array;

		if($tipoString || $tipoString === null)
			$tipo = 'SORT_STRING';
		else
			$tipo = 'SORT_NUMERIC';

		if($order == 'up' )
			$ordem = 'SORT_DESC';
		else
			$ordem = 'SORT_ASC';
	    // tratamento para colunas tipo DATA
		$aDataInvertida=null;
		if( substr($array[$coluna][0],2,1).substr($array[$coluna][0],5,1) == '//') {
		    foreach ($array[$coluna] as $k=>$v){
		        $aDataInvertida[$coluna][$k] = substr($v,6,4).'/'.substr($v,3,2).'/'.substr($v,0,2).' '.substr($v,11,8);
		    }
		    $expressao= 'array_multisort($aDataInvertida["'.$coluna.'"], '.$tipo.', '.$ordem;
		    $coluna='';
		} else if( preg_match('/^\s*[+-]?(\d+|[1-9]\d?(\.\d{3,3})*)(,\d+)?\s*$/',$array[$coluna][0])) {
			$tipo = 'SORT_NUMERIC';
		    foreach ($array[$coluna] as $k=>$v){
		        $aNumeroPonto[$coluna][$k] = preg_replace('/,/','.',preg_replace('/\./','',$v));
		    }
		    $expressao= 'array_multisort($aNumeroPonto["'.$coluna.'"], '.$tipo.', '.$ordem;
		    $coluna='';
		} else {
		    $expressao= 'array_multisort($array["'.$coluna.'"], '.$tipo.', '.$ordem;
		}
		foreach ($array as $k=>$col){
			$array[$k][0] = $array[$k][0]; // para corrigir o bug de n�o alterar os dados da sessao
			if( $k != $coluna ){
				$expressao.=' ,$array["'.$k.'"]';
			}
		}
	    reset( $array);
		$expressao.=');';
	    eval($expressao);
		return $array;
	}
	/**
	* Definir a imagem que ser� exibida no lugar de um bot�o desabilitado quando
	* o pr�prio bot�o n�o tiver a sua imagem desabilitada definida
	*
	* ex: $g->setDisabledButtonImage('fwDisabled.png');
	*
	* @param string $strNewImage
	*/
	public function setDisabledButtonImage($strNewImage=null)
	{
		$this->disableButtonImage = $strNewImage;
	}
	public function getDisabledButtonImage()
	{
		return $this->disableButtonImage;
	}
	public function setExportFullData($boolNewValue=null)
	{
		$this->exportFullData = $boolNewValue;
	}
	public function getExportFullData()
	{
		return $this->exportFullData;
	}
	/**
	* Retorna um array de objeto com os campos do formul�rio
	*
	* @param object $frm
	*/
	public function extractFormFields($frm=null)
	{
		$fields=array();
  		if( ! $frm )
  		{
  			return $fields;
  		}
  		//echo 'qdt fields:'.count($frm->getDisplayControls()).',';
		foreach( $frm->getDisplayControls() as $fieldName => $dc )
		{
			//echo $fieldName.'<br>';
			$field = $dc->getField();
			//echo $field->getFieldType().', ';
			if( $field->getFieldType() == 'group' )
			{
             	$fields = array_merge($fields, (array) $this->extractFormFields($field) );
			}
			else if( preg_match('/edit|memo|hidden|select|number|date|cpf|cpfcnpj|cnpj/i',$field->getFieldType() ) )
			{
				$label=null;
				if( method_exists($dc->getLabel(),'getValue'))
				{
					$label =$dc->getLabel()->getValue();
				}
				$fields[] = (object) array('field'=>$field,'label'=>$label);
			}
		}
		return $fields;
	}
//xxx------------------------------------------------------------------------------------
}
?>