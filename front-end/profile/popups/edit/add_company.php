<div class="popup-outside" data-modal="true" id="add_company">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>add your company</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error" style="display: none;"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part ui-widget autocomplete-box">
                    <input type="text" class="text-input" name="company_name" id="company-autocomplete" />
                    <p class="note" id="company-not-found" style="display: none;">Seems like <span></span> company is not yet in our database. You can add it!</p>
                    <input type="hidden" id="company-id" name="company_bobject_id" />
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button do-add-company">add</a>
                </div>
            </form>
        </div>
    </div>
</div>