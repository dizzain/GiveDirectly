<div class="row">
    <div class="half-col">
        <section class="simple-section with-header">
            <header>
                <h3>Overview</h3>
            </header>
            <div class="content-part">
                <ul class="about-list">
                    <?php echo View::factory('app/profile/elements/edit/combobox_small')->set('title','locations')->set('type','person')->set('item','locations')->render(); ?>
                    <?php /*echo View::factory('app/profile/elements/edit/combobox_small')->set('title','occupations')->set('type','person')->set('item','occupations')->render(); */?>
                </ul>
            </div>
        </section>
        
        <?php echo View::factory('app/profile/elements/edit/board_companies')->set('item','person')->render(); ?>
    </div>
    <div class="half-col">
        <?php echo View::factory('app/profile/elements/edit/about')->set('title','about')->set('type','person')->set('item','about')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/companies')->set('item','person')->render(); ?>
        <?php echo View::factory('app/profile/elements/edit/activities')->set('activity_title',$activity_title)->set('type','person')->render(); ?>
    </div>
</div>


<!--POPUPS-->
<?php /*echo View::factory('app/profile/popups/edit/remove_company')->render(); */?><!--
--><?php /*echo View::factory('app/profile/popups/edit/edit_team_title')->render(); */?>

<?php echo View::factory('app/profile/popups/edit/remove_board_company')->render(); ?>
<?php echo View::factory('app/profile/popups/edit/add_board_company')->render(); ?>
<?php /*echo View::factory('app/profile/popups/edit/add_company')->render(); */?>