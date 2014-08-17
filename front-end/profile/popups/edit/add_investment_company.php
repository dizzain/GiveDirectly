<div class="popup-outside addcompany-pop loading" data-modal="true" id="add_investment_company">
    <div class="popup-inside">
        <div class="popup-top">
            <h3>add company</h3>
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
                        <div class="drag-here" id="plupload-investment-drop-area">
                            <p class="big-text">Drag Image Here to Upload</p>
                            <p>
                                or
                                <a href="#" id="plupload-investment-upload-button">choose file</a>
                            </p>
                        </div>
                        <span class="notes">Use an image file on your computer (300K,jpg, png, gif, tiff)</span>
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>Name:</label>
                    </div>
                    <div class="right-form-content">
                        <input type="text" name="name" class="text-input" />
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>main sectors</label>
                    </div>
                    <div class="right-form-content">
                        <div class="select-part big-select">
                            <select class="select-edit" name="sectors-combobox" id="investment-sectors-combobox"></select>
                            <a href="#" class="add-link-small add-param-small" data-param-id="" data-param-value=""></a>
                            <div id="investment-sectors-list"></div>
                        </div>
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>main locations </label>
                    </div>
                    <div class="right-form-content">
                        <div class="select-part big-select">
                            <select class="select-edit" name="locations-combobox" id="investment-locations-combobox"></select>
                            <a href="#" class="add-link-small add-param-small" data-param-id="" data-param-value=""></a>
                            <div id="investment-locations-list"></div>
                        </div>
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>target geographies</label>
                    </div>
                    <div class="right-form-content">
                        <div class="select-part big-select">
                            <select class="select-edit" name="tg_locations-combobox" id="investment-tg_locations-combobox"></select>
                            <a href="#" class="add-link-small add-param-small" data-param-id="" data-param-value=""></a>
                            <div id="investment-tg_locations-list"></div>
                        </div>
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>growth stage</label>
                    </div>
                    <div class="right-form-content">
                        <div class="select-part small-select">
                            <?php $growth_stages = Utils::get_growth_stages(); ?>
                            <select name="growth_stage" data-select="true">
                                <?php foreach ($growth_stages as $key=>$gs) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $gs; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-part">
                    <div class="left-label">
                        <label>revenue models</label>
                    </div>
                    <div class="right-form-content">
                        <div class="select-part big-select">
                            <select class="select-edit" name="revenues-combobox" id="investment-revenues-combobox"></select>
                            <a href="#" class="add-link-small add-param-small" data-param-id="" data-param-value=""></a>
                            <div id="investment-revenues-list"></div>
                        </div>
                    </div>
                </div>
                <div class="button-block">
                    <a href='#' class="origin-button do-add-investment-company">add</a>
                    <a href='#' class="origin-button" data-closeBtn="true">cancel</a>
                </div>
            </form>
        </div>
        <div class="big-loader loaderImageBig"></div>
    </div>
</div>