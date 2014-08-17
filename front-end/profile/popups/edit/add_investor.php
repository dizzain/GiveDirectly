<div class="popup-outside" data-modal="true" id="add_investor">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>Please enter the name of the investor</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part ui-widget autocomplete-box">
                    <input type="text" class="text-input" name="investor_name" id="investors-autocomplete" />
                    <p id="investor-not-found" class="note" style="display: none;">Looks like <span></span> is not yet in our database. Don't worry, our editorial team will add it. Click Add to confirm.</p>
                    <input type="hidden" id="investor-id" name="investor_bobject_id" />
                </div>
                <div class="form-part">
                    <label>Exited:</label> <input type="checkbox" name="is_exit" value="1" />
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button" id="do-add-investor">add</a>
                </div>
            </form>
        </div>
    </div>
</div>