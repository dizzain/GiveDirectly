<?php /*if (isset($board_members) && !empty($board_members)) { */?>
<?php if (!empty($board_members) || !Utils::check_user_company_board_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?>'s board/advisory members</h1>
        </header>
        <div class="content-part">
            <?php $total = count($board_members); ?>
            <ul class="people-list">
                <?php for ($i=0;$i<=($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($board_members[$i]['type'],$board_members[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $board_members[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($board_members[$i]['avatar_url'], 'avatar_74', 'user') : Utils::get_null_image('avatar_74','user'); ?>" alt=""/>
                            </span>
                            <?php echo $board_members[$i]['name']; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($total < 4 && Auth::instance()->logged_in('login') && !Utils::check_user_company_board_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                    <li>
                        <a href="#" class="add-link-big add_me_to_board_members" data-company-id="<?php echo $company_bobject_id; ?>" data-company-name="<?php echo $name; ?>">
                            <i class="icon icons-plus-w"></i>
                            <span>add me</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 4) { ?>
                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=4;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($board_members[$i]['type'],$board_members[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $board_members[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($board_members[$i]['avatar_url'], 'avatar_74', 'user') : Utils::get_null_image('avatar_74','user'); ?>" alt=""/>
                            </span>
                                <?php echo $board_members[$i]['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (Auth::instance()->logged_in('login') && !Utils::check_user_company_board_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                        <li>
                            <a href="#" class="add-link-big add_me_to_board_members" data-company-id="<?php echo $company_bobject_id; ?>" data-company-name="<?php echo $name; ?>">
                                <i class="icon icons-plus-w"></i>
                                <span>add me</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <?php if ($total > 4) { ?>
            <footer>
                <a href="#"  data-link="more-info" data-original-text="view all members">view all members</a>
            </footer>
        <?php } ?>
    </section>
<?php } ?>
<?php /*} */?>