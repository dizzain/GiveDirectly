<div class="popup-outside" data-modal="true" id="add_investment">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>enter the name of the company</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part ui-widget autocomplete-box">
                    <input type="text" class="text-input" name="investment_name" id="investment-autocomplete" />
                    <p class="note" id="investment-not-found" style="display: none;">Seems like <span></span> company is not yet in our database. Please add it!</p>
                    <input type="hidden" id="investment-id" name="investment_bobject_id" />
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button" id="do-add-investment">add</a>
                </div>
            </form>
        </div>
    </div>
</div>