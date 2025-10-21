<?php

use Adianti\Control\TPage;
use Adianti\Widget\Form\TEntry;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TLabel;
use Adianti\Control\TAction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Form\TNumeric;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Util\TDropDown;
use Adianti\Widget\Util\TXMLBreadCrumb;

/**
 * ExcecoesPortalList Listing
 * 
 */
class ExcecoesPortalList extends TPage
{
	protected $form;
	protected $datagrid;
	protected $pageNavigation;

	use Adianti\base\AdiantiStandardListTrait;

	/**
	 * Page constructor
	 */
	public function __construct()
	{
		parent::__construct();

		$this->setDatabase('SUADATABASE'); //INSIRA AQUI SUA DATABASE
		$this->setActiveRecord('ExcecaoPortal');
		$this->setDefaultOrder('id', 'desc');
		$this->setLimit(30);

		$this->addFilterField('id', '=', 'id');
		$this->addFilterField('classe', 'like', 'classe');
		$this->addFilterField('metodo', 'like', 'metodo');
		$this->addFilterField('data_hora', '>=', 'data_de');
		$this->addFilterField('data_hora', '<=', 'data_ate');

		$this->setFormularioFiltro();
		$this->setDatagrid();
		$this->setPaginacao();

		$vbox = new TVBox;
		$vbox->style = 'width: 100%';
		$vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
		$vbox->add($this->form);
		$vbox->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));

		parent::add($vbox);
	}

	/**
	 * Define o formulário de filtro
	 */
	private function setFormularioFiltro()
	{
		$id = new TNumeric('id', 0, ',', '.');
		$id->setSize(120);

		$classe = new TEntry('classe');
		$classe->setSize(240);

		$metodo = new TEntry('metodo');
		$metodo->setSize(240);

		$data_de = new TDate('data_de');
		$data_de->setMask('dd/mm/yyyy');
		$data_de->setDatabaseMask('yyyymmdd');
		$data_de->setSize('50%');

		$data_ate = new TDate('data_ate');
		$data_ate->setMask('dd/mm/yyyy');
		$data_ate->setDatabaseMask('yyyymmdd');
		$data_ate->setSize('50%');

		$this->form = new BootstrapFormBuilder('filter_form_ExcecaoPortal');
		$this->form->setFormTitle('Filtro de Exceções ocorridas no Portal');

		$this->form->addFields([new TLabel('ID')], [$id]);
		$this->form->addFields([new TLabel('Classe')], [$classe]);
		$this->form->addFields([new TLabel('Método / Função')], [$metodo]);
		$this->form->addFields(
			[new TLabel('Data De')],
			[$data_de],
			[new TLabel('Data até')],
			[$data_ate]
		);
		
		// keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

		// header actions
        $dropdown = new TDropDown(_t('Export'), 'fa:list');
        $dropdown->setPullSide('right');
        $dropdown->setButtonClass('btn btn-info waves-effect dropdown-toggle animated bounceIn');
        $dropdown->addAction( _t('Save as CSV'), new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table blue' );
        $dropdown->addAction( _t('Save as PDF'), new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf red' );
        $this->form->addHeaderWidget( $dropdown );

		$this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search white')->class = 'btn btn-sm btn-primary';
		$this->form->addAction(_t('Clear'), new TAction([$this, 'onReload']), 'fa:eraser')->class = 'btn btn-sm btn-warning';
	}

	/**
	 * Define a datagrid
	 */
	private function setDatagrid()
	{
		$this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
		$this->datagrid->style = 'width: 100%';
		$this->datagrid->datatable = 'true';

		$this->datagrid->addColumn(new TDataGridColumn('id', 'ID', 'center'));
		// Formatando a coluna 'data'
		$this->datagrid->addColumn(new TDataGridColumn('data_hora', 'Data/hora', 'left'))->setTransformer(function ($value, $object, $row) {
			$dateTime = new DateTime($value);
			return $dateTime->format('d/m/Y H:i:s');
		});
		$this->datagrid->addColumn(new TDataGridColumn('classe', 'Classe', 'left'));
		$this->datagrid->addColumn(new TDataGridColumn('metodo', 'Método / Função', 'left'));
		$this->datagrid->addColumn(new TDataGridColumn('detalhes', 'Detalhes da Exceção', 'left'));

		

		$this->datagrid->createModel();
	}


	/**
	 * Define a paginação
	 */
	private function setPaginacao()
	{
		$this->pageNavigation = new TPageNavigation;
		$this->pageNavigation->setAction(new TAction([$this, 'onReload']));
		$this->pageNavigation->setWidth($this->datagrid->getWidth());
	}
}
