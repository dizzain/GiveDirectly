<?php if ($is_editorial) { ?>
    <div class='yellow-tooltip fixed' data-tooltip="true">
        This is an editorial profile, created by the dealroom team rather than a user. If you would like to request ownership of this profile, please <a href='mailto:team@dealroom.co'>click here</a>
    </div>
<?php } ?>
<section class="simple-section with-padding">
    <div class="head-info">
        <div class="photo-block">
            <img src="<?php echo $company_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($company_profile['avatar_url'], 'avatar_98', 'company') : Utils::get_null_image('avatar_98','company'); ?>" alt=""/>
        </div>

    </div>
    <div class="info-part">
        <div class="about-part">
            <h2><?php echo $company_profile['name']; ?></h2>
            <p><?php echo !empty($company_profile['tagline']) ? $company_profile['tagline'] : '&nbsp;'; ?></p>
            <?php if (Auth::instance()->logged_in('login')) { ?>
                <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                    <a href="#" class="origin-button do-track" data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?>>track us<span class="tooltip">follow every move of <?php echo $company_profile['name']; ?></span></a>
                    <a href="#" class="origin-button do-untrack track-button" data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?>>tracking<span class="tooltip">stop tracking</span></a>
                <?php } ?>
            <?php } else { ?>
                <a href="#login" class="origin-button" data-popup="true">track us</a>
            <?php } ?>
            <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?>  <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p>
        </div>
        <div class="social-part">
            <ul class="block-list">
                <li>
                    <?php echo !empty($company_profile['website']) ? '<a href="'.(strpos($company_profile['website'],'http') === 0 ? $company_profile['website'] : 'http://'.$company_profile['website']).'" target="_blank">www.'.rtrim(str_replace(array('http://','https://','www.'),'',$company_profile['website']),'/').'</a>' : ''; ?>
                </li>
                <li>
                    <?php echo !empty($company_profile['google']) && $company_profile['google'] !== null ? '<a href="'.(strpos($company_profile['google'],'http') === 0 ? $company_profile['google'] : 'http://'.$company_profile['google']).'" class="g-plus icon-gplus" target="_blank"></a>' : ''; ?>
                    <?php echo !empty($company_profile['twitter']) && $company_profile['twitter'] !== null ? '<a href="'.(strpos($company_profile['twitter'],'http') === 0 ? $company_profile['twitter'] : 'http://'.$company_profile['twitter']).'" class="twitter icon-twitter" target="_blank"></a>' : ''; ?>
                    <?php echo !empty($company_profile['facebook']) && $company_profile['facebook'] !== null ? '<a href="'.(strpos($company_profile['facebook'],'http') === 0 ? $company_profile['facebook'] : 'http://'.$company_profile['facebook']).'" class="facebook icon-facebook" target="_blank"></a>' : ''; ?>
                    <?php echo !empty($company_profile['linkedin']) && $company_profile['linkedin'] !== null ? '<a href="'.(strpos($company_profile['linkedin'],'http') === 0 ? $company_profile['linkedin'] : 'http://'.$company_profile['linkedin']).'" class="linkedin icon-linkedin" target="_blank"></a>' : ''; ?>
                </li>
            </ul>
        </div>
    </div>
</section>
<div class="narrow-part">
    <a href="<?php echo Navigator::get_search_link('companies'); ?>" class="grey-button big-button button">search more companies »</a>
</div>