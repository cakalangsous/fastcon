<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Front {

    public function __construct()
	{
		parent::__construct();
		$this->data['active'] = 'news';
	}

	public function index()
	{
		$this->data['title'] 	= lang('news');
		$this->data['news'] 	= db_get_all_data('fastcon_news', false, false, false, false, 'id desc');

		$this->render('news-list', $this->data);
	}

    public function details($id=false, $slug=false)
    {
    	if (!$id) {
    		$this->not_found();
    		return;
    	}
    	$news = db_get_row_data('fastcon_news', ['id' => $id]);
        $this->data['title'] 	= $this->data['lang']=='indonesian'?ucwords(strtolower($news->title)):ucwords(strtolower($news->title_en));
        $this->data['news'] 	= $news;
		$this->render('news-details', $this->data);
    }

}

/* End of file News.php */
/* Location: ./application/controllers/News.php */