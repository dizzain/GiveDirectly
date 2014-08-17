<section class="simple-section with-header">
    <header>
        <h1>Investment opportunity</h1>
    </header>
    <div class="content-block">
        <div class="row">
            <div class="fullwidth-col">
                <div class="top-opportunity-part">
                    <div class="overview-part">
                        <div class="name">round:</div>
                        <div class="description"><?php echo $opportunity['amount_formatted'] && !empty($opportunity['amount_formatted']) ? $opportunity['amount_formatted'] : 'undisclosed'; ?></div>
                    </div>
                    <div class="overview-part">
                        <div class="name">track record:</div>
                        <div class="description">
                            <?php echo $opportunity['track_record'] && !empty($opportunity['track_record']) ? $opportunity['track_record'] : 'undisclosed'; ?>
                        </div>
                    </div>
                    <div class="overview-part">
                        <div class="name">traction:</div>
                        <div class="description">
                            <?php echo $opportunity['traction'] && !empty($opportunity['traction']) ? $opportunity['traction'] : 'undisclosed'; ?>
                        </div>
                    </div>
                    <div class="overview-part">
                        <div class="name">investors:</div>
                        <div class="description">
                            <?php if (empty($opportunity['investors']['existed']) && empty($opportunity['investors']['this_round'])) { ?>
                                undisclosed
                            <?php } else {
                                if ($opportunity['investors']['existed'] && !empty($opportunity['investors']['existed'])) { ?>
                                    <strong>existing:</strong>
                                    <?php foreach ($opportunity['investors']['existed'] as $key=>$investor) {
                                        echo $investor['name'] . ($key < count($opportunity['investors']['existed'])-1 ? ', ' : '');
                                    } ?>
                                    <br />
                                <?php }
                                if ($opportunity['investors']['opportunity'] && !empty($opportunity['investors']['opportunity'])) { ?>
                                    <strong>new this round:</strong>
                                    <?php foreach ($opportunity['investors']['opportunity'] as $key=>$investor) {
                                        echo $investor['name'] . ($key < count($opportunity['investors']['opportunity'])-1 ? ', ' : '');
                                    } ?>
                                <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="overview-part">
                        <div class="name">dataroom files:</div>
                        <div class="description">
                            <?php echo isset($files_num) && $files_num > 0 ? 'yes' : 'no'; ?>
                        </div>
                    </div>
                </div>

                <?php if ($show_dataroom) { ?>
                    <div class="bottom-opportunity-part">
                        <?php if ($user_status == 'active') { ?>
                            <a href="<?php echo $url; ?>" class="origin-button right">enter dataroom</a>
                        <?php } else if ($user_status == 'can_request') { ?>
                            <a href="#" class="origin-button right do-dataroom-request-ext blue-button" data-dataroom-id="<?php echo $dataroom_id; ?>">request dataroom access</a>
                        <?php } else if ($user_status == 'pending') { ?>
                            <span class="button right track-button">pending</span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <!-- <div class="col-2">
                <div class="top-opportunity-part">

                </div>
            </div> -->
        </div>
    </div>
</section>