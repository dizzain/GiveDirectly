<div class="popup-outside" data-modal="true" id="add_team">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>add new team member</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error"></div>
        <div class="popup-body">
            <form class="popup-form two-colum-form">
                <div class="form-part">
                    <label class="left">name</label>
                    <input type="text" class="text-input input-middle-inline " name="name" id="user-autocomplete" />
                    <p class="note" id="user-not-found" style="display: none;">Invite your colleague via email</p>
                    <input type="hidden" id="user-id" name="user_bobject_id" />
                </div>
                <div class="form-part">
                    <label class="left">title</label>
                    <input type="text" class="text-input input-middle-inline" name="title" />
                </div>
                <div class="form-part email-container" style="display: none;">
                    <label class="left">email</label>
                    <input type="email" class="text-input input-middle-inline" name="email" />
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button small-button blue-button do-add-team">add</a>
                    <a href='#' class="origin-button small-button blue-button" data-closeBtn='true'>cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>