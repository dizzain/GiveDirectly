<div class="overview-part with-tooltip">
    <form id="<?php echo $type; ?>-<?php echo $item; ?>"<?php echo $required ? ' data-required="required"' : ' data-required="none"'; ?>>
        <div class="name">
            <span><?php echo $title; ?></span>
        </div>
        <div class="description require-here">

            <div class="<?php echo $item; ?>-add-container param-container" style="display: none;">
                <a href="#" class="add-link-small add-link-small-disabler <?php echo $item; ?>-add-button"><i class="icon icons-plus-black"></i></a>
            </div>
            <div class="<?php echo $item; ?>-show-container param-container" style="display: none;">
                <a href="#" class="edit-link"><i class="icon icons-pen-black"></i></a>
                <div class="<?php echo $item; ?>-show-list inline-part"></div>
                
            </div>

            <div class="<?php echo $item; ?>-edit-container param-container" style="display: none;">

                <div class="part-form">
                    <input type="text" class="text-input small-input" name="<?php echo $item; ?>" id="<?php echo $type; ?>-<?php echo $item; ?>-input" />
                </div>
                <div class="button-block">
                    <a href="#" class="origin-button small-button do-item-save" data-item-type="<?php echo $item; ?>">save</a>
                    <a href="#" class="origin-button small-button do-item-undo" data-item-type="<?php echo $item; ?>">undo</a>
                </div>
            </div>


        </div>

        <div class="tooltip top-position">
            <div class="head">Compare with your public profile</div>
            <div class="text-center">
                <div class="row">
                    <div class="name">
                        <span><?php echo $title; ?></span>
                    </div>
                    <div class="description <?php echo $item; ?>-tooltip"></div>
                </div>
            </div>
        </div> 

    </form>
</div>