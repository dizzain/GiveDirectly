<div class="popup-outside addcompany-pop" data-modal="true" id="select_company">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>Select company</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error" style="display: none;"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part">
                    <label class="left">Choose company:</label>
                    <div class="right-form-content companies-radio">
                        <?php foreach ($user_companies as $key=>$company) { ?>
                            <input type="radio" value="<?php echo $company['bobject_id']; ?>" name="company_id" id="company_<?php echo $key; ?>"<?php echo $key == 0 ? ' checked="checked"' : ''; ?> />
                            <label for="company_<?php echo $key; ?>" class="inline-label"><?php echo $company['name']; ?></label><br />
                        <?php } ?>
                    </div>
                </div>
                <input type="hidden" name="venture_dept_link" value="<?php echo $venture_dept_link; ?>" />
                <div class="button-block">
                    <a href="<?php echo $venture_dept_link; ?>?f=<?php echo $user_companies[0]['bobject_id']; ?>" class="origin-button do-venture-form">add</a>
                    <a href="#" class="origin-button" data-closebtn="true">cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>