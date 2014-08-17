<div class="section-content">

    <section class="simple-section with-padding">
        <div class="head-info">
            <div class="photo-block">
                <img src="<?php echo $investor_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($investor_profile['avatar_url'], 'avatar_98', 'user') : Utils::get_null_image('avatar_98','user'); ?>" alt=""/>
            </div>
            <div class="info-part">
                <div class="about-part">
                    <h2><?php echo $investor_profile['name']; ?></h2>
                    <?php echo Auth::instance()->logged_in('admin') ? $investor_profile['email'] : ''; ?>
                    <p><?php echo !empty($investor_profile['tagline']) ? $investor_profile['tagline'] : '&nbsp;'; ?></p>
                    <?php echo View::factory('app/profile/elements/view/contact')->set('text','contact me')->set('to_bobject_id',$user_bobject_id)->set('name',$investor_profile['name'])->render(); ?>
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$user_bobject_id)) { ?>
                            <span class="with-tooltip">
                                <a href="#" class="origin-button do-track track-button blue-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>track</a>
                                <span class="tooltip right-position one-line">stay posted on <?php echo $investor_profile['name']; ?>’s investment activities</span>
                            </span>
                            <a href="#" class="origin-button do-untrack track-button" data-bobject-id="<?php echo $user_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$user_bobject_id) ? ' style="display:none;"' : ''; ?>>&#10003; tracking<span class="tooltip">stop tracking</span></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" class="origin-button pp-login">track me</a>
                    <?php } ?>
                    <!-- <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?> <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p> -->
                </div>
                <div class="social-part">
                    <ul class="block-list">
                        <li>
                            <?php echo !empty($investor_profile['google']) && $investor_profile['google'] !== null ? '<a href="'.(strpos($investor_profile['google'],'http') === 0 ? $investor_profile['google'] : 'http://'.$investor_profile['google']).'" class="social-link" target="_blank"><i class="icon icons-gplus"></i></a>' : ''; ?>
                            <?php echo !empty($investor_profile['twitter']) && $investor_profile['twitter'] !== null ? '<a href="'.(strpos($investor_profile['twitter'],'http') === 0 ? $investor_profile['twitter'] : 'http://'.$investor_profile['twitter']).'" class="social-link" target="_blank"><i class="icon icons-twitter"></i></a>' : ''; ?>
                            <?php echo !empty($investor_profile['facebook']) && $investor_profile['facebook'] !== null ? '<a href="'.(strpos($investor_profile['facebook'],'http') === 0 ? $investor_profile['facebook'] : 'http://'.$investor_profile['facebook']).'" class="social-link" target="_blank"><i class="icon icons-facebook"></i></a>' : ''; ?>
                            <?php echo !empty($investor_profile['linkedin']) && $investor_profile['linkedin'] !== null ? '<a href="'.(strpos($investor_profile['linkedin'],'http') === 0 ? $investor_profile['linkedin'] : 'http://'.$investor_profile['linkedin']).'" class="social-link" target="_blank"><i class="icon icons-linkedin"></i></a>' : ''; ?>
                        </li>
                        <li>
                            <?php echo Utils::make_link($investor_profile['website'],true,null,'<br />'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="half-col">

            <section class="simple-section with-header">
                <header>
                    <h1>Investment strategy</h1>
                </header>
                <div class="content-part">
                    <p><?php echo Utils::make_profile_text('investor',$investor_profile['deal_size'],$investor_profile['investment_stages'],'',$investor_profile['locations'] !== null ? $investor_profile['locations'] : array()); ?></p>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','target geographies')->set('param_cap','tg_locations')->set('items',$investor_profile['tg_locations'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','target industries')->set('param_cap','categories')->set('items',$investor_profile['categories'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','deal structure')->set('param_cap','deal_structures')->set('items',$investor_profile['deal_structures_default'])->set('additional',$investor_profile['deal_structures_additional'])->render(); ?>
                    <!--                --><?php //echo View::factory('app/profile/elements/view/param_text')->set('cap','client focus')->set('item',$investor_profile['client_focus'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','interested in')->set('param_cap','sectors')->set('items',$investor_profile['sectors'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','b2b / b2c')->set('param_cap','client_focus')->set('items',$investor_profile['client_focus'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','revenue models of interest')->set('param_cap','revenues')->set('items',$investor_profile['revenues'])->render(); ?>
                </div>

            </section>

            <?php echo View::factory('app/profile/elements/view/companies')->set('name',$investor_profile['name'])->set('items',$companies)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/person_board_companies')->set('name',$investor_profile['name'])->set('board_companies',$board_companies)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/recent_fundings')->set('name','Recent funding rounds')->set('items',$recent_fundings)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/activity')->set('activities',$activities)->set('name',$investor_profile['name'])->render(); ?>

            <!--<section class="simple-section">
                <ul class="about-list">
                    <?php /*if (!empty($investor_profile['occupations']) && !empty($investor_profile['skills'])) { */?>
                        <li>
                            <p class='about-part'>occupations</p>
                            <p>
                                <?php /*foreach ($investor_profile['occupations'] as $key=>$occupation) { */?>
                                    <a href="<?php /*echo Navigator::get_search_link('users',array('params'=>'occupations:'.$occupation['name'])); */?>"><?php /*echo $occupation['name']; */?><?php /*echo $key+1 < count($investor_profile['occupations']) ? ', ': ''; */?></a>
                                <?php /*} */?>
                            </p>
                        </li>
                    <?php /*} */?>
                    <?php /*if (!empty($investor_profile['skills'])) { */?>
                        <li>
                            <p class='about-part'>skills</p>
                            <p>
                                <?php /*foreach ($investor_profile['skills'] as $key=>$skill) { */?>
                                    <span><?php /*echo $skill['name']; */?><?php /*echo $key+1 < count($investor_profile['skills']) ? ', ': ''; */?></span>
                                <?php /*} */?>
                            </p>
                        </li>
                    <?php /*} */?>
                </ul>
            </section>-->

        </div>
        <div class="half-col">

            <?php /*echo View::factory('app/profile/elements/view/venture_dept')->set('accept_venture_dept',$investor_profile['accept_venture_dept'])->set('company_name',$investor_profile['name'])->set('can_send_venture_dept',$can_send_venture_dept)->set('user_companies',$user_companies)->set('venture_dept_link',$venture_dept_link)->render(); */?>
            <?php echo View::factory('app/profile/elements/view/investments')->set('name',$investor_profile['name'])->set('items',$investments)->set('investments_link',$investments_link)->set('title',$investor_profile['name'] . ' investments')->render(); ?>
            <?php echo View::factory('app/profile/elements/view/investments')->set('name',$investor_profile['name'])->set('items',$co_investments)->set('investments_link',$co_investments_link)->set('title','Has co-investments with')->render(); ?>
            <?php echo View::factory('app/profile/elements/view/about')->set('about',$investor_profile['about'])->render(); ?>
            <?php echo View::factory('app/profile/elements/view/media')->set('media',$media)->render(); ?>

        </div>
    </div>
</div>


<?php if ($investor_profile['accept_venture_dept'] && $can_send_venture_dept) { ?>
    <?php if (count($user_companies) > 1) { ?>
        <?php echo View::factory('app/profile/popups/view/select_company')->set('user_companies',$user_companies)->set('venture_dept_link',$venture_dept_link)->render(); ?>
    <?php } ?>
<?php } ?>