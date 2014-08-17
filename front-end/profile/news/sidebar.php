<?php
if ($bobject_type == 2) {
    echo View::factory('app/profile/elements/view/similar')->set('title','Similar companies')->set('link',$similar_link)->set('items',$similar_items)->set('type',$bobject_type)->set('search_type','companies')->render();
} else {
    echo View::factory('app/profile/elements/view/similar')->set('title','Similar companies')->set('link',$similar_link)->set('items',$similar_items)->set('type',$bobject_type)->set('search_type','investors')->render();
}
?>