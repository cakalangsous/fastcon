<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Front {

    public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'News';
		$this->render('news-list', $this->data);
	}

    public function details($id=false, $slug=false)
    {
        $this->data['title'] = 'News Details';
		$this->render('news-details', $this->data);
    }

}

/* End of file News.php */
/* Location: ./application/controllers/News.php */