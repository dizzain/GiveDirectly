
<div class="section-content">

    <section class="simple-section with-padding">
        <div class="head-info">
            <div class="photo-block">
                <img src="<?php echo $user_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($user_profile['avatar_url'], 'avatar_98', 'user') : Utils::get_null_image('avatar_98','user'); ?>" alt=""/>
            </div>
            <div class="info-part">
                <div class="about-part">
                    <h2><?php echo $user_profile['name']; ?></h2>
                    <?php echo Auth::instance()->logged_in('admin') ? $user_profile['email'] : ''; ?>
                    <p><?php echo !empty($user_profile['tagline']) ? $user_profile['tagline'] : '&nbsp;'; ?>
                    <?php if (/*!empty($user_profile['ocupations']) || */!empty($user_profile['locations'])) { ?>
                                <?php /*if (!empty($user_profile['occupations'])) { */?><!--
                            <li>
                                <p class='about-part'>occupations</p>
                                <p>
                                    <?php /*foreach ($user_profile['occupations'] as $key=>$occupation) { */?>
                                        <a href="<?php /*echo Navigator::get_search_link('users',array('params'=>'occupations:'.$occupation['name'])); */?>"><?php /*echo $occupation['name']; */?><?php /*echo $key+1 < count($user_profile['occupations']) ? ', ': ''; */?></a>
                                    <?php /*} */?>
                                </p>
                            </li>
                        --><?php /*} */?>
                                <?php if (!empty($user_profile['locations'])) { ?>
                                <br /><br />
                                            <?php foreach ($user_profile['locations'] as $key=>$locations) { ?>
                                                <a href="<?php echo Navigator::get_search_link('users',array('params'=>'locations:'.$locations['name'])); ?>"><?php echo $locations['name']; ?><?php echo $key+1 < count($user_profile['locations']) ? ', ': ''; ?></a>
                                            <?php } ?>

                                <?php } ?>
                    <?php } ?>
                    </p>
                    <?php echo View::factory('app/profile/elements/view/contact')->set('text','contact me')->set('to_bobject_id',$user_bobject_id)->set('name',$user_profile['name'])->render(); ?>
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$user_bobject_id)) { ?>
                            <span class="with-tooltip">
                                <a href="#" class="origin-button do-track track-button blue-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>track us</a>
                                <span class="tooltip right-position one-line">follow every move of <?php echo $user_profile['name']; ?>’s companies</span>
                            </span>
                            <a href="#" class="origin-button do-untrack track-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>&#10003; tracking<span class="tooltip">stop tracking</span></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" class="origin-button pp-login">track me</a>
                    <?php } ?>
                </div>
                <!-- <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?> <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p> -->
                <div class="social-part">
                    <ul class="block-list">
                        <li>
                            <?php echo !empty($user_profile['google']) && $user_profile['google'] !== null ? '<a href="'.(strpos($user_profile['google'],'http') === 0 ? $user_profile['google'] : 'http://'.$user_profile['google']).'" class="social-link" target="_blank"><i class="icon icons-gplus"></i></a>' : ''; ?>
                            <?php echo !empty($user_profile['twitter']) && $user_profile['twitter'] !== null ? '<a href="'.(strpos($user_profile['twitter'],'http') === 0 ? $user_profile['twitter'] : 'http://'.$user_profile['twitter']).'" class="social-link" target="_blank"><i class="icon icons-twitter"></i></a>' : ''; ?>
                            <?php echo !empty($user_profile['facebook']) && $user_profile['facebook'] !== null ? '<a href="'.(strpos($user_profile['facebook'],'http') === 0 ? $user_profile['facebook'] : 'http://'.$user_profile['facebook']).'" class="social-link" target="_blank"><i class="icon icons-facebook"></i></a>' : ''; ?>
                            <?php echo !empty($user_profile['linkedin']) && $user_profile['linkedin'] !== null ? '<a href="'.(strpos($user_profile['linkedin'],'http') === 0 ? $user_profile['linkedin'] : 'http://'.$user_profile['linkedin']).'" class="social-link" target="_blank"><i class="icon icons-linkedin"></i></a>' : ''; ?>
                        </li>
                        <li>
                            <?php echo Utils::make_link($user_profile['website'],true,null,'<br />'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="half-col">

            <?php if (!empty($companies)) { ?>
                <section class="simple-section with-header">
                    <header>
                        <h1>Companies</h1>
                    </header>
                    <div class="content-part">
                        <ul class="people-list">
                            <?php foreach ($companies as $company) { ?>
                                <li>
                                    <a href="<?php echo Navigator::get_bobject_link($company['type'],$company['url']); ?>">
												<span class="logo-link">
													<img src="<?php echo $company['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($company['avatar_url'], 'avatar_74', 'company') : Utils::get_null_image('avatar_74','company'); ?>" alt=""/>
												</span>
                                        <?php echo $company['name']; ?>
                                    </a>
                                    <span class="grey-position"><?php echo strtolower($company['title']) == 'other' || empty($company['title']) ? 'No title' : $company['title']; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </section>
            <?php } ?>
            <?php /*echo View::factory('app/profile/elements/view/activity')->set('activities',$activities)->set('name',$user_profile['name'])->render(); */?>
            <?php echo View::factory('app/profile/elements/view/activity_with_images')->set('activities',$activities)->set('name',$user_profile['name'])->render(); ?>

        </div>
        <div class="half-col">

            <?php echo View::factory('app/profile/elements/view/about')->set('about',$user_profile['about'])->render(); ?>
            <?php echo View::factory('app/profile/elements/view/person_team')->set('name',$user_profile['name'])->set('team',$team)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/person_board_companies')->set('name',$user_profile['name'])->set('board_companies',$board_companies)->render(); ?>
        </div>
    </div>
</div>