<?php if ($item) { ?>
    <div class="overview-part">
        <div class="name">
            <span><?php echo $cap; ?></span>
        </div>
        <div class="description">
            <a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$search_key.':'.$item)); ?>"><?php echo $item; ?></a>
        </div>
    </div>
<?php } ?>