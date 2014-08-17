<!-- <div class="yellow-tooltip fixed clearfix edit-top-block" style="display: none;">
    <div class="container">
        <div class="left container-715">
            <span class="draft-unsaved-notice">You haven’t published your previous changes. Please see the highlighted cards below. </span>
            <span class="draft-unsaved2-notice">You have edited some of the cards. Please publish the changes to make them appear on your public profile.</span>
            <span class="draft-required-notice">The highlighted fields are required, please edit them.</span>
            <span class="draft-name-exists-notice">We already have a company with such name in our database. Please check the name again or <a href="mailto:support@dealroom.co">contact us</a> if you have any questions.</span>
        </div>
        <div class="right">
            <a class="blue-button button do-global-undo" href="#">undo all the changes</a>
            <a class="orange-primary-button button do-global-save" href="#">publish profile</a>
        </div>
    </div>
</div> -->

<div class="container">
    <div class="container-223">
        <a href="<?php echo $profile_url; ?>" class="origin-button wide-button blue-button">View profile</a>
    </div>

<div class="container-956">
    <section class="simple-section with-padding">
        <div class="row">
            <div class="col-2">
                
                    <div class="info-part-edit">

                        <?php echo View::factory('app/profile/elements/edit/photo')->set('type','fund')->render(); ?>

                        <div class="form-right edit-profile">
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','name')->set('item_type','fund')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','tagline')->set('item_type','fund')->render(); ?>
                            <?php echo View::factory('app/profile/elements/edit/info')->set('type','website')->set('item_type','fund')->render(); ?>
                        </div>
                    </div>
                

            </div>
            <div class="col-2">
                <div class="edit">
                    <?php echo View::factory('app/profile/elements/edit/social')->set('type','google')->set('class','gplus')->set('item_type','fund')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/social')->set('type','twitter')->set('class','twitter')->set('item_type','fund')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/social')->set('type','facebook')->set('class','facebook')->set('item_type','fund')->render(); ?>
                    <?php echo View::factory('app/profile/elements/edit/social')->set('type','linkedin')->set('class','linkedin')->set('item_type','fund')->render(); ?>
                </div>
            </div>

        </div>
    </section>
    </div>
    
</div>