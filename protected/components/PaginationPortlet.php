<?php
/**
 * Pagination portlet
 * @author Markus J Doetsch
 */

Yii::import('zii.widgets.CPortlet');

class PaginationPortlet extends CPortlet
{
	public $defaults = array(
		'showPages' => true,
		'showFirst' => false,
		'showLast'  => false,
		'showNext'	=> true,
		'showPrev'	=> true,
	);

	public $options = array();
	public $pagination;

	public function init(){
	    $this->options = array_merge($this->defaults, $this->options);
	    parent::init();
	  }

	protected function renderContent ()
	{
		$this->render('pagination', array('pagination' => $this->pagination));
	}
}
