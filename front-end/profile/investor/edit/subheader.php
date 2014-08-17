<div class="container">
    <div class="row">
        <div class="container-223">
             <a href="<?php echo $profile_url; ?>" class="origin-button wide-button blue-button">View profile</a>
        </div>
        <div class="container-956">
            <section class="simple-section without-header">
                <div class="row">
                    <div class="col-2">
                        <div class="info-part-edit">

                            <?php echo View::factory('app/profile/elements/edit/photo')->set('type','investor')->render(); ?>
                        </div>
                        <div class="edit-profile">
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','name')->set('item_type','investor')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','tagline')->set('item_type','investor')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','website')->set('item_type','investor')->render(); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="edit">
                            <?php echo View::factory('app/profile/elements/edit/social')->set('type','google')->set('class','gplus')->set('item_type','investor')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/social')->set('type','twitter')->set('class','twitter')->set('item_type','investor')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/social')->set('type','facebook')->set('class','facebook')->set('item_type','investor')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/social')->set('type','linkedin')->set('class','linkedin')->set('item_type','investor')->render(); ?>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        
    </div>
</div>