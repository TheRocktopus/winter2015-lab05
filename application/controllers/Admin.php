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
	
	function confirm()
	{
		$record = $this->quotes->create();
		
		// assign form fields
		$id = $this->input->post('id');
		$record->who = $this->input->post('who');
		$record->mug = $this->input->post('mug');
		$record->what = $this->input->post('what');
		
		// validate field content
		if( empty($record->who) )
		{
			$this->errors[] = 'You must specify an author';
		}
		if( strlen($record->what) < 20 )
		{
			$this->errors[] = 'A quotation must be at least 20 characters long.';
		}
		
		// redisplay page if there are errors
		if( count($this->errors) > 0)
		{
			$this->present($record);
			return;
		}
		
		// save the record
		if( empty($id) )
		{
			// initialize id and vote fields
			$record->id = $this->quotes->highest() + 1;
			$record->vote_total = 0;
			$record->vote_count = 0;
			
			// add new quote
			$this->quotes->add($record);
			
		}
		else
		{
			// update quote
			$record->id = $id;
			$this->quotes->update($record);
		}
		
		redirect('/admin');
	}
	
	// present a quote
	function present($quote)
	{
		// error formatting
		$message = '';
		if( count($this->errors) > 0 )
		{
			foreach( $this->errors as $error )
			{
				$message .= $error . BR;
			}
		}
		
		// make quote form fields
		$this->data['fid'] = makeTextField('ID#', 'id', $quote->id, "Unique quote identifier, system-assigned",10,10,true);
		$this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
		$this->data['fmug'] = makeTextField('Picture', 'mug', $quote->mug);
		$this->data['fwhat'] = makeTextField('The Quote', 'what', $quote->what);
		$this->data['message'] = $message;
		
		// form submit button
		$this->data['fsubmit'] = makeSubmitButton('Process Quote', 
			"Click here to validate the quotation data", 'btn-success');
		
		$this->data['pagebody'] = 'quote_edit';
		$this->render();
	}

}

/* End of file Welcome.php */
/* Location: application/controllers/Welcome.php */