<?php if (!empty($items)) { ?>
    <section class="simple-section with-header">
        <header>
            <h1>Has co-invested with</h1>
        </header>
        <div class="content-part">
            <ul class="people-list">
                <?php $total = count($items); for ($i=0;$i<= ($total > 8 ? 7 : $total-1);$i++) { ?>
                    <li>
                        <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>">
                            <span class="logo-link">
                                <img src="<?php echo $items[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($items[$i]['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
                            </span>
                            <?php echo $items[$i]['name']; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php if ($total > 8) { ?>

                <ul class="people-list hide-text"  data-text="more-info">
                    <?php for ($i=8;$i<=$total-1;$i++) { ?>
                        <li>
                            <a href="<?php echo Navigator::get_bobject_link($items[$i]['type'],$items[$i]['url']); ?>">
                                <span class="logo-link">
                                     <img src="<?php echo $items[$i]['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($items[$i]['avatar_url'], 'avatar_74', Utils::get_bobject_type_by_int($items[$i]['type'])) : Utils::get_null_image('avatar_74',Utils::get_bobject_type_by_int($items[$i]['type'])); ?>" alt=""/>
                                </span>
                                <?php echo $items[$i]['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

            <?php } ?>
        </div>
        <footer>
            <a href="#" data-link="more-info" data-original-text="view all co-investments">view all</a>
        </footer>
    </section>

<?php } ?>