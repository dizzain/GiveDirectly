<section class="simple-section with-header dataroom-sidebar">
    <header>
        <h1>My projects</h1>
    </header>
    <div class="content-part">
        <ul class="dataroom-list">
            <?php foreach ($my_datarooms as $d) { ?>
                <li<?php echo $d['dataroom_id'] == $dataroom['dataroom_id'] ? '  class="active"' : ''; ?>>
                    <div class="message-body">
                    <img src="<?php echo $d['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($d['avatar_url'], 'avatar_32', 'company') : Utils::get_null_image('avatar_32','company'); ?>" alt=""/>
                    <div class="message-block">
                        <a href="<?php echo Navigator::get_bobject_link(2,$d['company_url'],'dataroom'); ?>" class="name<?php echo $d['dataroom_id'] == $dataroom['dataroom_id'] ? ' dataroom-title' : ''; ?>"><?php echo $d['name']; ?></a>
                        <?php /*if ($d['role'] == Model_Dataroom::DATAROOM_ROLE_TEAM) { */?>
                            <!--None-->
                        <?php /*} else if ($d['role'] == Model_Dataroom::DATAROOM_ROLE_INVESTOR) { */?>
                            <!--<a href="#" class="origin-button little-button do-dataroom-preexit" data-dataroom-name="<?php /*echo $d['name']; */?>" data-dataroom-id="<?php /*echo $d['dataroom_id']; */?>">exit</a>-->
                        <?php /*} else { */?>
                            <a href="<?php echo Navigator::get_bobject_link(2,$d['company_url'],'dataroom'); ?>" class="origin-button little-button ">enter</a>
                            <!--<a href="#" class="button grey-button small-button do-dataroom-preclose" data-dataroom-id="<?php /*echo $d['dataroom_id']; */?>" data-button-type="<?php /*echo $d['dataroom_id'] == $dataroom['dataroom_id'] ? 'self' : 'etc'; */?>">close</a>-->
                        <?php /*} */?>
                    </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php if (($dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_INVESTOR || $dataroom_access['role'] == Model_Dataroom::DATAROOM_ROLE_ADMIN_INVESTOR) && !empty($other_datarooms)) { ?>
    <section class="simple-section with-header dataroom-sidebar">
        <header>
            <h1>Other datarooms</h1>
        </header>
        <div class="content-part">
            <ul class="dataroom-list">
                <?php foreach ($other_datarooms as $d) { ?>
                    <li>
                        <div class="message-body">
                        <img src="<?php echo $d['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($d['avatar_url'], 'avatar_32', 'company') : Utils::get_null_image('avatar_32','company'); ?>" alt=""/>
                        <div class="message-block">
                            <a href="<?php echo Navigator::get_bobject_link(2,$d['company_url'],'dataroom'); ?>" class="name"><?php echo $d['name']; ?></a>
                            <a href="#" class="origin-button little-button do-dataroom-request" data-dataroom-id="<?php echo $d['dataroom_id']; ?>">request access</a>
                        </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <footer>
            <a class="origin-button view-all-btn" href="<?php echo Navigator::getUrl('datarooms'); ?>">view all</a>
        </footer>
    </section>
<?php } ?>
