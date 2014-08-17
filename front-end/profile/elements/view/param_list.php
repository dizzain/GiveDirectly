<div class="overview-part">
    <div class="name">
        <span><?php echo $cap; ?></span>
    </div>
    <div class="description">
        <?php if ((isset($items) && !empty($items)) || (isset($additional) && $additional)) { ?>
            <?php if (isset($items) && !empty($items)) { ?>
                <?php foreach ($items as $key=>$item) { ?>
                    <?php if (isset($check_country_clickable)) { ?>
                        <?php if ($check_country_clickable && isset($item['is_country']) && $item['is_country']) { ?>
                            <a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$item['name'])); ?>"><?php echo $item['name']; ?><?php echo $key < count($items)-1 ? ', ' : ''; ?><?php echo $key == count($items)-1 && isset($additional) && !empty($additional) ? ', ' : ''; ?></a>
                        <?php } else { ?>
                            <span><?php echo $item['name']; ?><?php echo $key < count($items)-1 ? ', ' : ''; ?><?php echo $key == count($items)-1 && isset($additional) && !empty($additional) ? ', ' : ''; ?></span>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$item['name'])); ?>"><?php echo $item['name']; ?><?php echo $key < count($items)-1 ? ', ' : ''; ?><?php echo $key == count($items)-1 && isset($additional) && !empty($additional) ? ', ' : ''; ?></a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php if (isset($additional) && !empty($additional)) { ?>
                <?php echo $additional; ?>
            <?php } ?>
        <?php } else { ?>
            N/A
        <?php } ?>
    </div>
</div>