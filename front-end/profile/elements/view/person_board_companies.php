<?php if (isset($board_companies) && !empty($board_companies)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1><?php echo $name; ?>'s board/advisory companies</h1>
        </header>
        <div class="content-part">
            <?php $total = count($board_companies); ?>
            <ul class="people-list">
                <?php for ($i=0;$i<=($total > 4 ? 3 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($board_companies[$i]['type'],$board_companies[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $board_companies[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($board_companies[$i]['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
                            </span>
                            <?php echo $board_companies[$i]['name']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 4) { ?>
                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=4;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($board_companies[$i]['type'],$board_companies[$i]['url']); ?>">
                            <span class="logo-link">
                                 <img src="<?php echo $board_companies[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($board_companies[$i]['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
                            </span>
                                <?php echo $board_companies[$i]['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <?php if ($total > 4) { ?>
            <footer>
                <a href="#"  data-link="more-info" data-original-text="view all companies">view all companies</a>
            </footer>
        <?php } ?>
    </section>
<?php } ?>