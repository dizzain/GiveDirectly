<div class="popup-outside addcompany-pop" data-modal="true" id="add_me_to_team">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>Add me to team</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error" style="display: none;"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part">
                    <label class="left">Title:</label>
                    <input type="text" class="text-input" name="title" />
                </div>
                <input type="hidden" name="company_id" value="<?php echo $company_id; ?>" />
                <input type="hidden" name="company_name" value="<?php echo $company_name; ?>" />
                <div class="button-block">
                    <a href="#" class="origin-button do-add-me-to-team">add</a>
                    <a href="#" class="origin-button" data-closebtn="true">cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>