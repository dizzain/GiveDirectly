<section class="simple-section with-header company-stats">
    <header>
        <h1>Stats</h1>
    </header>
    <div class="content-part">

        <div class="bottom-part">

            <div class="wrap-cols">
                <div class="overview-part">
                    <div class="name">
                        <span>growth stage</span>
                    </div>
                    <div class="description">
                        <ul class="inner-cols">
                            <?php foreach (Utils::get_growth_stages_shortest() as $key=>$stage) { ?>
                                <li<?php echo $key == $company_profile['fund_stage'] ? ' class="active"' : ''; ?>><?php echo $stage; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="overview-part">
                    <div class="name">
                        <span>performance</span>
                    </div>
                    <div class="description"><ul class="inner-cols"><li>top half</li><li>top 25%</li><li class="active">top 10%</li><li>top 5%</li></ul>
                    </div>
                </div>
            </div>

            <?php if (isset($company_profile['traffic']) && !empty($company_profile['traffic'])) { ?>
                <div class="overview-part">
                    <div class="name">
                        <span>traffic</span>
                    </div>
                    <div class="description"><?php echo $company_profile['traffic']; ?></div>
                </div>
            <?php } ?>
            <?php if (isset($company_profile['tr_number_empl']) && !empty($company_profile['tr_number_empl'])) { ?>
                <div class="overview-part">
                    <div class="name">
                        <span>employees</span>
                    </div>
                    <div class="description"><?php echo $company_profile['tr_number_empl']; ?></div>
                </div>
            <?php } ?>
            <?php if (isset($company_profile['launch_date']) && !empty($company_profile['launch_date'])) { ?>
                <div class="overview-part">
                    <div class="name">
                        <span>launch date</span>
                    </div>
                    <div class="description"><?php echo $company_profile['launch_date']; ?></div>
                </div>
            <?php } ?>
            <?php if (isset($company_profile['total_fundings']) && !empty($company_profile['total_fundings'])) { ?>
                <div class="overview-part">
                    <div class="name">
                        <span>total funding</span>
                    </div>
                    <div class="description"><?php echo $company_profile['total_fundings']; ?></div>
                </div>
            <?php } ?>
            <?php if (isset($company_profile['last_funding']) && !empty($company_profile['last_funding'])) { ?>
                <div class="overview-part">
                    <div class="name">
                        <span>last funding</span>
                    </div>
                    <div class="description"><?php echo $company_profile['last_funding']['round'] && !empty($company_profile['last_funding']['round']) ? $company_profile['last_funding']['round'].'-round, ' : ''; ?><?php echo $company_profile['last_funding']['date_formatted']; ?></div>
                </div>
            <?php } ?>

            <?php if ($kpi) { ?>

                <?php if (isset($kpi['users_formatted']) && !empty($kpi['users_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>users</span>
                        </div>
                        <div class="description"><?php echo $kpi['users_formatted']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['users_growth_formatted']) && !empty($kpi['users_growth_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>annual user growth</span>
                        </div>
                        <div class="description"><?php echo $kpi['users_growth_formatted']; ?> %</div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['paying_customers_formatted']) && !empty($kpi['paying_customers_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>paying customers</span>
                        </div>
                        <div class="description"><?php echo $kpi['paying_customers_formatted']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['volume_formatted']) && !empty($kpi['volume_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>volume</span>
                        </div>
                        <div class="description"><?php echo $kpi['volume_formatted']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['avg_price_formatted']) && !empty($kpi['avg_price_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>average price per sale</span>
                        </div>
                        <div class="description"><?php echo $kpi['avg_price_formatted']; ?> <?php echo $kpi['currency']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['revenues_formatted']) && !empty($kpi['revenues_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>annual revenues</span>
                        </div>
                        <div class="description"><?php echo $kpi['revenues_formatted']; ?> <?php echo $kpi['currency']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['yoy_growth_formatted']) && !empty($kpi['yoy_growth_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>annual growth rate</span>
                        </div>
                        <div class="description"><?php echo $kpi['yoy_growth_formatted']; ?> %</div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['gross_margin_formatted']) && !empty($kpi['gross_margin_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>gross margin</span>
                        </div>
                        <div class="description"><?php echo $kpi['gross_margin_formatted']; ?> %</div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['operating_margin_formatted']) && !empty($kpi['operating_margin_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>operating margin</span>
                        </div>
                        <div class="description"><?php echo $kpi['operating_margin_formatted']; ?> %</div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['source_formatted']) && !empty($kpi['source_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>source</span>
                        </div>
                        <div class="description"><?php echo $kpi['source_formatted']; ?></div>
                    </div>
                <?php } ?>
                <?php if (isset($kpi['last_update_formatted']) && !empty($kpi['last_update_formatted'])) { ?>
                    <div class="overview-part">
                        <div class="name">
                            <span>last updated</span>
                        </div>
                        <div class="description"><?php echo $kpi['last_update_formatted']; ?></div>
                    </div>
                <?php } ?>

            <?php } ?>

        </div>
    </div>
</section>