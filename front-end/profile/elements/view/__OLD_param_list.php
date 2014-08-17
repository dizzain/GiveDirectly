<?php if (isset($items) && !empty($items)) { ?>
    <div class="shot-desc-inside">
        <ul class="desc-list">
            <li><span><?php echo $cap; ?></span></li>
            <?php foreach ($items as $key=>$item) { ?>
                <li><a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$item['name'])); ?>"><?php echo $item['name']; ?><?php echo $key < count($items)-1 ? ', ' : ''; ?></a></li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <div class="shot-desc-inside">
        <ul class="desc-list shot-desc-empty">
            <li><span><?php echo $cap; ?></span></li>
            <li>N/A</li>
        </ul>
    </div>
<?php } ?>