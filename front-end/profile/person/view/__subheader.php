<section class="simple-section with-padding">
        <div class="head-info">
            <div class="photo-block">
                <img src="<?php echo $user_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($user_profile['avatar_url'], 'avatar_98', 'user') : Utils::get_null_image('avatar_98','user'); ?>" alt=""/>
            </div>
            <div class="info-part">
                <div class="about-part">
                    <h2><?php echo $user_profile['name']; ?></h2>
                    <p><?php echo !empty($user_profile['tagline']) ? $user_profile['tagline'] : '&nbsp;'; ?></p>
                    <?php echo View::factory('app/profile/elements/view/contact')->set('text','contact me')->set('to_bobject_id',$user_bobject_id)->set('name',$user_profile['name'])->render(); ?>
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$user_bobject_id)) { ?>
                            <a href="#" class="origin-button do-track" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>track<span class="tooltip">follow every move of <?php echo $user_profile['name']; ?>’s companies</span></a>
                            <a href="#" class="origin-button do-untrack track-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>tracking<span class="tooltip">stop tracking</span></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#login" class="origin-button" data-popup="true">track me</a>
                    <?php } ?>
                    <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?> <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p>
                </div>
                <div class="social-part">
                    <ul class="block-list">
                        <li>
                            <?php echo !empty($user_profile['google']) && $user_profile['google'] !== null ? '<a href="'.(strpos($user_profile['google'],'http') === 0 ? $user_profile['google'] : 'http://'.$user_profile['google']).'" class="g-plus icon-gplus" target="_blank"></a>' : ''; ?>
                            <?php echo !empty($user_profile['twitter']) && $user_profile['twitter'] !== null ? '<a href="'.(strpos($user_profile['twitter'],'http') === 0 ? $user_profile['twitter'] : 'http://'.$user_profile['twitter']).'" class="twitter icon-twitter" target="_blank"></a>' : ''; ?>
                            <?php echo !empty($user_profile['facebook']) && $user_profile['facebook'] !== null ? '<a href="'.(strpos($user_profile['facebook'],'http') === 0 ? $user_profile['facebook'] : 'http://'.$user_profile['facebook']).'" class="facebook icon-facebook" target="_blank"></a>' : ''; ?>
                            <?php echo !empty($user_profile['linkedin']) && $user_profile['linkedin'] !== null ? '<a href="'.(strpos($user_profile['linkedin'],'http') === 0 ? $user_profile['linkedin'] : 'http://'.$user_profile['linkedin']).'" class="linkedin icon-linkedin" target="_blank"></a>' : ''; ?>
                        </li>
                    </ul>
                </div>
        </div>
    </div>
</section>
    <div class="narrow-part right">
        <a href="<?php echo Navigator::get_search_link('users'); ?>" class="grey-button big-button button">search more people »</a>
    </div>
</div>