<?php
	echo View::factory('app/profile/elements/view/similar')->set('title', $is_advisor == 1 ? 'other advisors' : 'other investors')
	->set('link',$similar_link)->set('items',$similar_items)
	->set('type',1)
	->set('search_type','investors')
	->render(); 
?>