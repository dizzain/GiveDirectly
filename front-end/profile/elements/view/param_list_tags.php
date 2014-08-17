<?php if (isset($items) && !empty($items)) { ?>
<div class="tags-part <?php echo isset($additional_class) && !empty($additional_class) ? $additional_class : ''; ?>">
    <?php foreach ($items as $item) { ?>
        <a href="<?php echo Navigator::get_search_link($search_type,array('params'=>$param_cap.':'.$item['name'])); ?>"><?php echo $item['name']; ?></a>
    <?php } ?>
</div>
<?php } ?>