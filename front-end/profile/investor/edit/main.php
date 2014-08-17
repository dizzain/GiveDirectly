<div class="section-content">

    <div class="row">
    <div class="half-col">

        <section class="simple-section with-header">
            <header>
                <h1>Investment strategy</h1>
            </header>
            <div class="content-part edit-part">
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','tg_locations')->set('type','investor')->set('title','target geographies')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','categories')->set('type','investor')->set('title','target industries')->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','sectors')->set('type','investor')->set('title','interested in')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','revenues')->set('type','investor')->set('title','revenue models of interest')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/combobox')->set('item','locations')->set('type','investor')->set('title','my main location(s)')->set('required',true)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','growth_stage')->set('type','investor')->set('title','investment stage')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','deal_structure')->set('type','investor')->set('title','deal structure')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/checkbox')->set('item','client_focus')->set('type','investor')->set('title','b2b / b2c')->set('required',false)->render(); ?>
                <?php echo View::factory('app/profile/elements/edit/deal_size')->set('item','deal_size')->set('type','investor')->set('title','deal size range')->set('required',false)->render(); ?>
            </div>

        </section>

        <!--<section class="simple-section">
            <ul class="about-list">
                <?php /*echo View::factory('app/profile/elements/edit/combobox_small')->set('title','occupations')->set('type','investor')->set('item','occupations')->render(); */?>
            </ul>
        </section>-->

        <?php echo View::factory('app/profile/elements/edit/board_companies')->set('item','investor')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/media')->set('type','investor')->render(); ?>

    </div>
    <div class="half-col">
        <?php echo View::factory('app/profile/elements/edit/investments')->set('item','investor')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/companies')->set('item','investor')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/activities')->set('activity_title',$activity_title)->set('type','investor')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/about')->set('title','about')->set('type','investor')->set('item','about')->render(); ?>

    </div>
    </div>


</div>

<!--POPUPS-->
<?php echo View::factory('app/profile/popups/edit/remove_company')->render(); ?>
<?php echo View::factory('app/profile/popups/edit/edit_team_title')->render(); ?>

<?php echo View::factory('app/profile/popups/edit/remove_board_company')->render(); ?>
<?php echo View::factory('app/profile/popups/edit/add_board_company')->render(); ?>
<?php echo View::factory('app/profile/popups/edit/add_company')->render(); ?>
