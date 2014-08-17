<?php if (isset($items) && !empty($items)) { ?>
    <div class="shot-desc-inside">
        <?php $total = count($items); ?>
        <ul class="desc-list">
            <li><span><?php echo $cap; ?></span></li>
            <?php if ($total > 0) { ?>
                <?php for ($i=0;$i<=($total>5 ? 4 : $total-1);$i++) { ?>
                    <li><a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$items[$i]['name'])); ?>"><?php echo $items[$i]['name']; ?></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
        <?php if ($total > 5) { ?>
            <ul class="desc-list hide-text"  data-text="more-info">
                <?php for ($i=5;$i<=$total-1;$i++) { ?>
                    <li><a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$items[$i]['name'])); ?>"><?php echo $items[$i]['name']; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="shot-desc-inside">
        <ul class="desc-list shot-desc-empty">
            <li><span><?php echo $cap; ?></span></li>
        </ul>
    </div>
<?php } ?>