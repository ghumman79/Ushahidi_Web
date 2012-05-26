application/controllers/admin/settings.php

Line #331 

$this->template->content->items_per_page_array = array('5'=>'5 Items','10'=>'10 Items','20'=>'20 Items','30'=>'30 Items','50'=>'50 Items',
              '100'=>'100 Items','250'=>'250 Items','500'=>'500 Items','1000'=>'1000 Items');

Line #107 

$post->add_rules('items_per_page','required','between[5,1000]');