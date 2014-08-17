<div class="popup-outside loading" data-modal="true" id="add-picture">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>add new image</h3>
            <a href='#' class="closebtn" data-closeBtn='true'><i class="icon icons-close"></i></a>
        </div>
        <div class="tooltip-error"></div>
        <div class="popup-body">
            <form class="popup-form two-colum-form">
                <div class="form-part">
                    <div class="image-preview">
                        <img src="" alt="" />
                        <a href="#" class='delete-people'><i class="icon icons-trash-black"></i></a>
                        <input type="hidden" name="image_id" />
                    </div>
                    <div class="image-load">
                        <div class="drag-here" id="plupload-drop-area">
                            <p class="big-text">Drag Image Here to Upload</p>
                            <p>
                                or
                                <a href="#" id="plupload-upload-button">choose file</a>
                            </p>
                        </div>
                        <span class="notes">Use an image file on your computer (10M,jpg, png, gif, tiff)</span>
                    </div>
                </div>
                <div class="button-block">
                    <a href='#' class="do-photo-add origin-button">add</a>
                    <a href='#' class="origin-button" data-closeBtn="true">cancel</a>
                </div>
            </form>
        </div>
        <div class="big-loader loaderImageBig"></div>
    </div>
</div>