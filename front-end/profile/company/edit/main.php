<div class="section-content">

    <?php if ($has_investment_opportunity) {
        echo View::factory('app/profile/elements/edit/opportunity')->set('type','company')->set('item','opportunity')->render();
    } ?>

    <div class="row">
        <div class="half-col">
        <section class="simple-section with-header">
            <header>
                <h1>Overview</h1>
            </header>
            <div class="content-part edit-part">
                <?php echo View::factory('app/profile/elements/edit/select_2')->set('item','category')->set('type','company')->set('title','industry')->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','sectors')->set('type','company')->set('title','tags')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','tg_locations')->set('type','company')->set('title','target markets')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','locations')->set('type','company')->set('title','main location')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','revenues')->set('type','company')->set('title','revenue model')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','ownerships')->set('type','company')->set('title','ownership')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/select')->set('item','growth_stage')->set('type','company')->set('title','growth stage')->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','client_focus')->set('type','company')->set('title','b2b / b2c')->set('required',false)->render(); ?>
                <?php /*echo View::factory('app/profile/elements/edit/datepicker')->set('item','launch_date')->set('type','company')->set('title','launch date')->set('required',false)->render(); */?>
                <?php echo View::factory('app/profile/elements/edit/select_double')->set('item','launch_date')->set('type','company')->set('title','launch date')->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/select')->set('item','employees')->set('type','company')->set('title','employees')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/select')->set('item','delivery_method')->set('type','company')->set('title','delivery method')->set('required',false)->render(); ?>
            </div>

        </section>

            <?php echo View::factory('app/profile/elements/edit/funding')->set('title','funding')->set('type','company')->set('item','fundings')->render(); ?>
            <?php echo View::factory('app/profile/elements/edit/about')->set('title','about')->set('type','company')->set('item','about')->render(); ?>
            <?php echo View::factory('app/profile/elements/edit/media')->set('type','company')->render(); ?>

        </div>
        <div class="half-col">
            <section class="simple-section with-header">
                <header>
                    <h1>Stats</h1>
                </header>
                <div class="content-part edit-part">

                    <?php echo $company_profile['traffic'] && !empty($company_profile['traffic']) ? View::factory('app/profile/elements/view/param_text')->set('cap','traffic')->set('item',$company_profile['traffic'])->render() : ''; ?>
                    <?php echo $company_profile['total_fundings'] && !empty($company_profile['total_fundings']) ? View::factory('app/profile/elements/view/param_text')->set('cap','total funding')->set('item',$company_profile['total_fundings'])->render() : ''; ?>
                    <?php echo $company_profile['last_funding'] && !empty($company_profile['last_funding']) ? View::factory('app/profile/elements/view/param_text')->set('cap','last funding')->set('item',$company_profile['last_funding']['amount_formatted'].'M')->render() : ''; ?>

                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_users')->set('type','company')->set('title','users')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_users_growth')->set('type','company')->set('title','annual user growth')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_paying_customers')->set('type','company')->set('title','paying customers')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_volume')->set('type','company')->set('title','volume')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_avg_price')->set('type','company')->set('title','average price per sale')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_revenues')->set('type','company')->set('title','annual revenues')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/select')->set('item','kpi_currency')->set('type','company')->set('title','currency')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_yoy_growth')->set('type','company')->set('title','annual growth rate')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_gross_margin')->set('type','company')->set('title','gross margin')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/text')->set('item','kpi_operating_margin')->set('type','company')->set('title','operating margin')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/select')->set('item','kpi_source')->set('type','company')->set('title','source')->render(); ?>
                </div>
            </section>
            <?php /*echo View::factory('app/profile/elements/edit/kpi_summary')->set('item','company')->render(); */?>
            <?php echo View::factory('app/profile/elements/edit/team')->set('item','company')->render(); ?>
            <?php echo View::factory('app/profile/elements/edit/board_members')->set('item','company')->render(); ?>
            <?php echo View::factory('app/profile/elements/edit/investors')->set('item','company')->render(); ?>
            <?php if (!$board_member_access) { ?>
                <?php echo View::factory('app/profile/elements/edit/activities')->set('activity_title',$activity_title)->set('type','company')->render(); ?>
            <?php } ?>
        </div>
    </div>


</div>