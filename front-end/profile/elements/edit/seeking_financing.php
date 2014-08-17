<div class="form-part" class="with-tooltip">
    <form id="<?php echo $item_type; ?>-<?php echo $type; ?>">

        <div class="label-part">
            <label><?php echo $title; ?></label>
            <a class="<?php echo $type; ?>-edit-button" href="#"><i class="icon icons-pen-black"></i></a>
        </div>

        <div class="<?php echo $type; ?>-edit-container" style="display: none;">

            <div class="text-part">
                <input type="radio" name="<?php echo $type; ?>" value="1" class="<?php echo $type; ?>-checkbox-1" id="sf1"><label for="sf1">seeking financing</label><br/>
                <input type="radio" name="<?php echo $type; ?>" value="2" class="<?php echo $type; ?>-checkbox-0" id="sf2"><label for="sf2">not seeking financing</label>
            </div>

            <div class='link-block'>
                <a href="#" class="origin-button do-item-save small-button" data-item-type="<?php echo $type; ?>">save</a>
                <a href="#" class="origin-button do-item-undo small-button" data-item-type="<?php echo $type; ?>">undo</a>
            </div>

        </div>
        <div class="<?php echo $type; ?>-show-container" style="display: none;">
            <div class="text-part">
                <span class="y-block" style="display: none;">yes</span>
                <span class="n-block" style="display: none;">no</span>
            </div>
        </div>

        <div class="tooltip top-position <?php echo $type; ?>-tooltip">
            <div class="head">Compare with your public profile</div>
            <div class="text-center"></div>
        </div>

    </form>
</div>