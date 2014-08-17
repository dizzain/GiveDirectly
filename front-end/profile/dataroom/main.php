<div class='with-padding simple-section less-bottom-space'>
    <div class="head-info">
        <div class="photo-block">
            <img src="<?php echo $dataroom['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($dataroom['avatar_url'], 'avatar_98', 'company') : Utils::get_null_image('avatar_98','company'); ?>" alt=""/>
        </div>
        <div class="info-part">
            <h2><?php echo $dataroom['company_name']; ?></h2>
            <?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
                <!--<a href="#" class="origin-button blue-button dataroom-close pp-investment-opportunity">Add transaction summary</a>-->
                <!--<a href="#" class="dataroom-close do-dataroom-preclose" data-dataroom-id="<?php /*echo $dataroom['dataroom_id']; */?>" data-button-type="self">permanently close</a>-->
                <!--<div class="origin-check hidden-mode">
                    <input type="checkbox" id="change-dataroom-hidden" <?php /*echo $dataroom['is_public'] == 1 ? 'checked="checked"' : ''; */?>/>
                    <label for="change-dataroom-hidden">Publish now</label>
                    <div class="yellow-tooltip">If hidden mode is enabled, only users that you have invited can see that you have an active dataroom</div>
                </div>-->
            <?php } ?>
        </div>
    </div>
</div>

<?php if ($dataroom_investment_opportunity || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
    <div class='with-header simple-section less-bottom-space'>
        <header>
            <h1 class="pending-transaction">Transaction summary</h1>
            <span class="pending-approval"<?php echo ($dataroom_investment_opportunity && $dataroom_investment_opportunity['status'] != Model_InvestmentOpportunity::INVESTMENT_OPPORTUNITY_STATUS_ACTIVE ? '' : ' style="display:none;"'); ?>>pending approval</span>
        </header>
        <div class="content-part">
            <div id="investment_opportunity_container" class="transaction-summary-part"></div>
        </div>
    </div>
<?php } ?>

<div class="section-content">
    <div class="row">
        <div class="container-223 left-float">

            <?php if ($dataroom_access['role'] != Model_Dataroom::DATAROOM_ROLE_INVESTOR) { ?>
                <section class="simple-section with-header">
                    <header>
                        <h1>Participants</h1>
                        <?php if (($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) && $requests_num > 0) { ?>
                            <span class="participant-link">
                                <i class="icon icons-user"></i>
                                <span>+<?php echo $requests_num; ?></span>
                            </span>
                        <?php } ?>
                    </header>
                    <div class="content-part">
                        <ul class="dataroom-list" id="dataroom_participants"></ul>
                    </div>
                    <?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
                        <footer>
                            <a href="#" class="blue-button origin-button wide-button pp-notify-followers">notify followers</a>
                            <a href="#" class="blue-button origin-button wide-button build-group-invitation">select target audience</a>
                            <a href="#add_dataroom_investor" class="blue-button origin-button wide-button" data-popup="true">invite individually</a>
                        </footer>
                    <?php } ?>

                </section>
            <?php } ?>

            <?php //if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
                <section class="simple-section with-header">
                    <header>
                        <h1>Project Managers</h1>
                    </header>
                    <div class="content-part">
                        <ul class="dataroom-list" id="dataroom_admins"></ul>
                    </div>
                    <?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
                        <footer>
                            <a href="#add_dataroom_admin" class="origin-button wide-button" data-popup="true">add administrator</a>
                        </footer>
                    <?php } ?>
                </section>
            <? //} ?>

        </div>

        <div class='container-715 right-float'>
            <?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR || $dataroom_kpi_summary) { ?>
                <section class='simple-section with-header'>
                    <header><h1>KPI summary</h1></header>
                    <div class="content-part">
                        <div id="kpi_summary_container" class="transaction-summary-part kpi-summary-part"></div>
                    </div>
                </section>
            <?php } ?>
            <section class='simple-section with-header'>
                <header><h1>Files</h1></header>
                <div class="content-part">
                    <ul class="files-list" id="dataroom_files"></ul>
                </div>
            </section>
            <section class="simple-section with-header update-section">
                <header>
                    <h1>Updates</h1>
                </header>
                <div class="content-part">
                    <ul class="updates-list" id="dataroom-updates"></ul>
                </div>
                <?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
                    <footer>
                        <form id="update-form">
                            <textarea name="update_text" placeholder="Type your update..."></textarea>
                            <a href="#" class="origin-button do-publish-update">publish</a>
                        </form>
                    </footer>
                <?php } ?>
            </section>
        </div>

    </div>
</div>



<!--POPUPS-->
<!--#add_dataroom_admin-->
<?php echo View::factory('app/profile/dataroom/popups/message')->render(); ?>
<?php if ($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) { ?>
    <?php echo View::factory('app/profile/dataroom/popups/add_admin')->render(); ?>
    <?php echo View::factory('app/profile/dataroom/popups/add_investor')->render(); ?>
    <?php echo View::factory('app/profile/dataroom/popups/edit_file')->render(); ?>
    <?php echo View::factory('app/profile/dataroom/popups/add_file')/*->set('dataroom_id',$dataroom['dataroom_id'])*/->render(); ?>
<?php } ?>
<?php echo View::factory('app/profile/dataroom/popups/exit_dataroom')->set('type','dataroom')->render(); ?>
<?php echo View::factory('app/profile/dataroom/popups/close_dataroom')->render(); ?>