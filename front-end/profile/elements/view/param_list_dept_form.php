<div class="overview-part">
    <div class="name">
        <span><?php echo $cap; ?></span>
    </div>
    <div class="description">
        <?php if (isset($items) && !empty($items)) { ?>
            <?php foreach ($items as $key=>$item) { ?>
                <a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$item['name'])); ?>"><?php echo $item['name']; ?><?php echo $key < count($items)-1 ? ', ' : ''; ?><?php echo $key == count($items)-1 && isset($additional) && !empty($additional) ? ', ' : ''; ?></a>
            <?php } ?>
            <?php if (isset($additional) && !empty($additional)) { ?>
                <?php foreach($additional as $val){ echo $val['name'] . ' ';} ?>
            <?php } ?>
        <?php } else { ?>
            N/A
        <?php } ?>
    </div>
</div>