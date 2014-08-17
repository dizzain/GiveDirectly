<div class="container head-info">
    <div class="wide-part">
        <div class="photo-block">
            <img src="<?php echo $investor_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($investor_profile['avatar_url'], 'avatar_98', 'user') : Utils::get_null_image('avatar_98','user'); ?>" alt=""/>
        </div>
        <div class="info-part">
            <h2 class="investor-flag"><?php echo $investor_profile['name']; ?></h2>
            <p><?php echo !empty($investor_profile['tagline']) ? $investor_profile['tagline'] : '&nbsp;'; ?></p>
            <?php echo View::factory('app/profile/elements/view/contact')->set('text','contact me')->set('to_bobject_id',$user_bobject_id)->set('name',$investor_profile['name'])->render(); ?>
            <?php if (Auth::instance()->logged_in('login')) { ?>
                <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$user_bobject_id)) { ?>
                    <a href="#" class="blue-button button do-track" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>track<span class="tooltip">stay posted on <?php echo $investor_profile['name']; ?>’s investment activities</span></a>
                    <a href="#" class="button do-untrack track-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>tracking<span class="tooltip">stop tracking</span></a>
                <?php } ?>
            <?php } else { ?>
                <a href="#login" class="button blue-button" data-popup="true">track me</a>
            <?php } ?>
            <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?> <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p>
            <div class="social-button">
                <?php echo !empty($investor_profile['google']) && $investor_profile['google'] !== null ? '<a href="'.(strpos($investor_profile['google'],'http') === 0 ? $investor_profile['google'] : 'http://'.$investor_profile['google']).'" class="g-plus icon-gplus" target="_blank"></a>' : ''; ?>
                <?php echo !empty($investor_profile['twitter']) && $investor_profile['twitter'] !== null ? '<a href="'.(strpos($investor_profile['twitter'],'http') === 0 ? $investor_profile['twitter'] : 'http://'.$investor_profile['twitter']).'" class="twitter icon-twitter" target="_blank"></a>' : ''; ?>
                <?php echo !empty($investor_profile['facebook']) && $investor_profile['facebook'] !== null ? '<a href="'.(strpos($investor_profile['facebook'],'http') === 0 ? $investor_profile['facebook'] : 'http://'.$investor_profile['facebook']).'" class="facebook icon-facebook" target="_blank"></a>' : ''; ?>
                <?php echo !empty($investor_profile['linkedin']) && $investor_profile['linkedin'] !== null ? '<a href="'.(strpos($investor_profile['linkedin'],'http') === 0 ? $investor_profile['linkedin'] : 'http://'.$investor_profile['linkedin']).'" class="linkedin icon-linkedin" target="_blank"></a>' : ''; ?>
            </div>
        </div>
    </div>
    <div class="narrow-part right">
        <a href="<?php echo Navigator::get_search_link('investors'); ?>" class="origin-button wide-button">search more investors »</a>
    </div>
</div>