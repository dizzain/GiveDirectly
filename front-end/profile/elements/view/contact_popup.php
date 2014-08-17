<div class="popup-outside" data-modal="true" id="send-message">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>send message to <?php echo $name; ?></h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error" style="display: none;"></div>
        <div class="popup-body">
            <form class="popup-form">
                <div class="form-part">
                    <textarea name="message"></textarea>
                    <input type="hidden" name="to_bobject_id" value="<?php echo $to_bobject_id; ?>" />
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button do-send-message">send</a>
                    <a href='#' class="origin-button" data-closeBtn="true">cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>