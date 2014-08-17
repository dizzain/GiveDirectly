<li>
    <p class='about-part'><?php echo $title; ?></p>
    <form id="<?php echo $type; ?>-<?php echo $item; ?>">

        <div class="<?php echo $item; ?>-add-container" style="display: none;">
            <a href="#" class="add-link-big <?php echo $item; ?>-add-button"><i class="icon icons-plus-w"></i><span>add</span></a>
        </div>
        <div class="<?php echo $item; ?>-show-container" style="display: none;">
            <div class="link-option">
                <a href="#" class="edit-link">
                    <i class="icon icons-pen-black"></i>
                </a>
            </div>
            <p class="<?php echo $item; ?>-show-list"></p>
        </div>
        <div class="<?php echo $item; ?>-edit-container" style="display: none;">

            <div class="select-part">
                <div class="select-part small-combobox">
                    <select class="select-edit" name="<?php echo $item; ?>" id="<?php echo $type; ?>-<?php echo $item; ?>-combobox"></select>
                    <a href="#" class="add-param-small" data-param-id="" data-param-value="">
                        <i class="icon icons-pen-black"></i>
                    </a>
                </div>
            </div>

            <p class="<?php echo $item; ?>-edit-list"></p>
            <div class="edit-button">
                <a href="#" class="origin-button do-item-save" data-item-type="<?php echo $item; ?>">save</a>
                <a href="#" class="origin-button do-item-undo" data-item-type="<?php echo $item; ?>">undo</a>
            </div>
        </div>
    </form>
</li>