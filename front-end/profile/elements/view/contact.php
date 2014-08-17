<?php if (Auth::instance()->logged_in('login') && BData::instance()->get('bobject_id') != $to_bobject_id) { ?>

    <?php if (Utils::can_contact(BData::instance()->get('bobject_id'),$to_bobject_id)) { ?>
        <a href="#send-message" data-popup="true" class="origin-button do-contact" data-to-bobject-id="<?php echo $to_bobject_id; ?>"><?php echo $text; ?></a>

        <?php echo View::factory('app/profile/elements/view/contact_popup')->set('name',$name)->set('to_bobject_id',$to_bobject_id)->render(); ?>

    <?php } else { ?>
        <a href="#" class="origin-button button-disabled"><?php echo $text; ?><span class="tooltip"><?php echo $name; ?> needs to track you or your company before you can send direct messages</span></a>
    <?php } ?>
<?php } ?>