<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application {

    function __construct()
    {
		parent::__construct();
		
		// load formfield helper
		$this->load->helper('formfields');
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index()
    {
		$this->data['title'] = 'Quotations Maintenance';
		$this->data['quotes'] = $this->quotes->all();
		$this->data['pagebody'] = 'admin_list';    // this is the view we want shown
		
		$this->render();
    }
	
	// add a new quote!
	function add()
	{
		$quote = $this->quotes->create();
		$this->present($quote);
	}
	
	// present a quote
	function present($quote)
	{
		// make quote form fields
		$this->data['fid'] = makeTextField('ID#', 'id', $quote->id);
		$this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
		$this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
		$this->data['fwhat'] = makeTextField('The Quote', 'what', $quote->what);
		
		// form submit button
		$this->data['fsubmit'] = makeSubmitButton('Process Quote', 
			"Click here to validate the quotation data", 'btn-success');
		
		$this->data['pagebody'] = 'quote_edit';
		$this->render();
	}

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */