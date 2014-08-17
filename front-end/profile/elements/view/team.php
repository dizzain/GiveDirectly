<?php /*if (isset($team) && !empty($team)) { */?>
    <section class="simple-section with-header">
        <header>
            <h1>Team</h1>
        </header>
        <div class="content-part">

        <?php if ($is_editorial) { ?>
            <div class='editorial-tooltip row' data-tooltip="true">
                <?php if (Auth::instance()->logged_in('login')) { ?>
                    This profile was created by the dealroom.co team or by a VC. To request ownership of this profile, please <a href="#add_me_to_team" data-popup="true">click here</a>
                <?php } else { ?>
                    This profile was created by the dealroom.co team or by a VC. To request ownership of this profile, please <a href="<?php echo Navigator::getUrl('register'); ?>">click here</a>
                <?php } ?>
            </div>
        <?php } ?>

            <?php $total = count($team); ?>
            <ul class="people-list">
                <?php for ($i=0;$i<=($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($team[$i]['type'],$team[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $team[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($team[$i]['avatar_url'], 'avatar_74', 'user') : Utils::get_null_image('avatar_74','user'); ?>" alt=""/>
                            </span>
                            <?php echo $team[$i]['name']; ?>
                            <?php if (!empty($team[$i]['job_title'])) { ?>
                                <span class="grey-position"><?php echo $team[$i]['job_title']; ?></span>
                            <?php } ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($total < 4 && Auth::instance()->logged_in('login') && !Utils::check_user_company_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                    <li>
                        <a href="#add_me_to_team" class="add-link-big" data-popup="true" id="add_me_to_team_button">
                            <i class="icon icons-plus-w"></i><span>add</span></a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total >= 4) { ?>
                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=4;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($team[$i]['type'],$team[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $team[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($team[$i]['avatar_url'], 'avatar_74', 'user') : Utils::get_null_image('avatar_74','user'); ?>" alt=""/>
                            </span>
                                <?php echo $team[$i]['name']; ?>
                                <?php if (!empty($team[$i]['job_title'])) { ?>
                                    <span class="grey-position"><?php echo $team[$i]['job_title']; ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (Auth::instance()->logged_in('login') && !Utils::check_user_company_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                        <li>
                            <a href="#add_me_to_team" class="add-link-big" data-popup="true" id="add_me_to_team_button">
                            <i class="icon icons-plus-w"></i><span>add</span></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <footer>
            <a href="#"  data-link="more-info" data-original-text="view all team members">view all team members &raquo;</a>
        </footer>
    </section>

<?php /*} */?>