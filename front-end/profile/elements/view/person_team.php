<?php if (isset($team) && !empty($team)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?>'s team</h1>
        </header>
        <div class="content-part">
            <?php $total = count($team); ?>
            <ul class="people-list">
                <?php for ($i=0;$i<=($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($team[$i]['type'],$team[$i]['profile_url']); ?>">
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
            </ul>
            <?php if ($total > 4) { ?>
                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=4;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($team[$i]['type'],$team[$i]['profile_url']); ?>">
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
                </ul>
            <?php } ?>
        </div>
        <?php if ($total > 4) { ?>
            <footer>
                <a href="#"  data-link="more-info" data-original-text="view all team members">view all team members &raquo;</a>
            </footer>
        <?php } ?>
    </section>
<?php } ?>