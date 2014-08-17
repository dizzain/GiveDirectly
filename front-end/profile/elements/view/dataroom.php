<section class="simple-section with-header">
    <header>
        <h1>Live dataroom</h1>
    </header>
    <div class="content-part">
        <p class="v-debt">
            <?php if ($files_num > 0) { ?>
                There are <?php echo $files_num; ?> files in dataroom.
            <?php } ?>
        </p>
        <?php if ($user_status == 'active') { ?>
            <a href="<?php echo $url; ?>" class="origin-button">enter</a>
        <?php } else if ($user_status == 'can_request') { ?>
            <a href="#" class="origin-button do-dataroom-request-ext blue-button" data-dataroom-id="<?php echo $dataroom_id; ?>">request access</a>
        <?php } else if ($user_status == 'pending') { ?>
            <!--<span class="right">pending</span>-->
            <span class="origin-button track-button">pending</span>
        <?php } ?>
    </div>
</section>