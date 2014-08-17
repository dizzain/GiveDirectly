<?php if ($has_investment_opportunity) {
    echo View::factory('app/profile/elements/edit/opportunity')->set('type','fund')->set('item','opportunity')->render();
} ?>

<div class="section-content">

    <div class="row">
    <div class="half-col">

        <section class="simple-section with-header">
            <header>
                <h1>Investment strategy</h1>
            </header>
            <div class="content-part edit-part">
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','growth_stage')->set('type','fund')->set('title','investment stage')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','sectors')->set('type','fund')->set('title','interested in')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','tg_locations')->set('type','fund')->set('title','target geographies')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','categories')->set('type','fund')->set('title','target industries')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','revenues')->set('type','fund')->set('title','revenue models of interest')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','deal_structure')->set('type','fund')->set('title','deal structure')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','locations')->set('type','fund')->set('title','main locations')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','client_focus')->set('type','fund')->set('title','b2b / b2c')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/select')->set('item','employees')->set('type','fund')->set('title','employees')->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/deal_size')->set('item','deal_size')->set('type','fund')->set('title','deal size range')->set('required',false)->render(); ?>
            </div>

        </section>

        <?php echo View::factory('app/profile/elements/edit/investments')->set('item','fund')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/media')->set('type','fund')->render(); ?>

    </div>
    <div class="half-col">
        <?php echo View::factory('app/profile/elements/edit/team')->set('item','fund')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/board_members')->set('item','fund')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/about')->set('title','about')->set('type','fund')->set('item','about')->render(); ?>
        <?php if (!$board_member_access) { ?>
            <?php echo View::factory('app/profile/elements/edit/activities')->set('activity_title',$activity_title)->set('type','fund')->render(); ?>
        <?php } ?>
    </div>
    </div>


</div>
