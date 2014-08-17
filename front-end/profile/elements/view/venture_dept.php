<?php if ($accept_venture_dept) { ?>
    <?php if (Auth::instance()->logged_in('login')) { ?>
        <?php if ($can_send_venture_dept) { ?>
            <section class="simple-section with-header">
                <header>
                    <h1>Venture debt</h1>
                </header>
                <div class="content-part">
                    <p class="v-debt left"><?php echo $company_name; ?> is a venture debt provider and accepts applications for a venture loan. To learn more, request a proposal</p>
                    <?php if (count($user_companies) > 1) { ?>
                        <a href="#select_company" class="origin-button" data-popup="true">apply</a>
                    <?php } else { ?>
                        <a href="<?php echo $venture_dept_link; ?>?f=<?php echo $user_companies[0]['bobject_id']; ?>" class="origin-button">apply</a>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>
    <?php } else { ?>
        <section class="simple-section with-header">
            <header>
                <h1>Venture debt</h1>
            </header>
            <div class="content-part">
                <p class="v-debt left"><?php echo $company_name; ?> is a venture debt provider and accepts applications for a venture loan. To learn more, request a proposal</p>
                <a href="<?php echo Navigator::get_redirect_back_url('login',Navigator::get_current_url()); ?>" class="origin-button">apply</a>
            </div>
        </section>
    <?php } ?>
<?php } ?>