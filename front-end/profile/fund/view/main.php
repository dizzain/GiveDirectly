
<div class="section-content">

    <section class="simple-section with-padding">
        <div class="head-info">
            <div class="photo-block">
                <img src="<?php echo $fund_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($fund_profile['avatar_url'], 'avatar_98', 'company') : Utils::get_null_image('avatar_98','company'); ?>" alt=""/>
            </div>
            <div class="info-part">
                <div class="about-part">
                <h2 class="label-<?php echo $fund_profile['is_advisor'] == 0 ? /*'investor'*/ '' : 'advisor';?>"><?php echo $fund_profile['name']; ?></h2>
                <p><?php echo !empty($fund_profile['tagline']) ? $fund_profile['tagline'] : '&nbsp;'; ?></p>

                <ul class="block-list">
                    <li><?php echo !empty($fund_profile['google']) && $fund_profile['google'] !== null ? '<a href="'.(strpos($fund_profile['google'],'http') === 0 ? $fund_profile['google'] : 'http://'.$fund_profile['google']).'" class="social-link" target="_blank"><i class="icon icons-gplus"></i></a>' : ''; ?>
                        <?php echo !empty($fund_profile['twitter']) && $fund_profile['twitter'] !== null ? '<a href="'.(strpos($fund_profile['twitter'],'http') === 0 ? $fund_profile['twitter'] : 'http://'.$fund_profile['twitter']).'" class="social-link" target="_blank"><i class="icon icons-twitter"></i></a>' : ''; ?>
                        <?php echo !empty($fund_profile['facebook']) && $fund_profile['facebook'] !== null ? '<a href="'.(strpos($fund_profile['facebook'],'http') === 0 ? $fund_profile['facebook'] : 'http://'.$fund_profile['facebook']).'" class="social-link" target="_blank"><i class="icon icons-facebook"></i></a>' : ''; ?>
                        <?php echo !empty($fund_profile['linkedin']) && $fund_profile['linkedin'] !== null ? '<a href="'.(strpos($fund_profile['linkedin'],'http') === 0 ? $fund_profile['linkedin'] : 'http://'.$fund_profile['linkedin']).'" class="social-link" target="_blank"><i class="icon icons-linkedin"></i></a>' : ''; ?></li>
                    <li>
                        <?php echo Utils::make_link($fund_profile['website'],true,null,'<br />'); ?>
                    </li>
                </ul>

                <!-- <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?>  <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p> -->
                </div>
                <div class="social-part">
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                            <span class="with-tooltip">
                                <a href="#" class="origin-button do-track track-button blue-button" data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?> style="width: 160px;">+ add to tracking list<span class="tooltip one-line right-position" style="text-align: center;">follow every move of <?php echo $fund_profile['name']; ?></span></a>
                                <a href="#" class="origin-button do-untrack track-button" data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?>>&#10003; tracking<span class="tooltip one-line right-position" style="width: 160px; text-align: center;">stop tracking</span></a>
                            </span>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" class="origin-button pp-login">+ add to tracking list</a>
                    <?php } ?>

                    <ul class="block-list">
                        <li><?php if (Auth::instance()->logged_in('login')) { ?>
                            <a href="#" class="origin-button do-get-introduction center-text" data-company-id="<?php echo $company_bobject_id; ?>" style="width: 160px;">
                                <?php if (BData::instance()->get('bobject_type') == 1 || BData::instance()->get('has_funds')) { ?>
                                    request info
                                <?php } else { ?>
                                    get an introduction
                                <?php } ?>
                            </a>
                        <?php } ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php if ($can_see_opportunity && $opportunity) {
        if ($has_live_dataroom) {
            echo View::factory('app/profile/elements/view/opportunity')->set('opportunity',$opportunity)->set('show_dataroom',true)->set('files_num',$dataroom_files_num)->set('user_status',$dataroom_user_status)->set('url',$dataroom_url)->set('dataroom_id',$dataroom_id)->render();
        } else {
            echo View::factory('app/profile/elements/view/opportunity')->set('opportunity',$opportunity)->set('show_dataroom',true)->render();
        }
    } ?>

    <div class="row">
        <div class="half-col">

            <section class="simple-section with-header">
                <header>
                    <h1>Investment strategy</h1>
                </header>
                
                <div class="content-part">
                    <p><?php echo Utils::make_profile_text('investor',$fund_profile['deal_size'],$fund_profile['investment_stages'],$fund_profile['tr_number_empl'],$fund_profile['locations'] !== null ? $fund_profile['locations'] : array()); ?></p>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','target geographies')->set('param_cap','tg_locations')->set('items',$fund_profile['tg_locations'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','target industries')->set('param_cap','categories')->set('items',$fund_profile['categories'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','deal structure')->set('param_cap','deal_structures')->set('items',$fund_profile['deal_structures_default'])->set('additional',$fund_profile['deal_structures_additional'])->render(); ?>
                    <?php /*echo View::factory('app/profile/elements/view/param_text')->set('cap','client focus')->set('item',$fund_profile['client_focus'])->render(); */?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','interested in')->set('param_cap','sectors')->set('items',$fund_profile['sectors'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','b2b / b2c')->set('param_cap','client_focus')->set('items',$fund_profile['client_focus'])->render(); ?>
                    <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','investors')->set('cap','revenue models of interest')->set('param_cap','revenues')->set('items',$fund_profile['revenues'])->render(); ?>
                </div>

            </section>

            <?php echo View::factory('app/profile/elements/view/news')->set('name',$fund_profile['name'])->set('items',$ee_news)->set('news_link',$news_link)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/recent_fundings')->set('name','Recent funding rounds')->set('items',$recent_fundings)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/media')->set('media',$media)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/activity')->set('activities',$activities)->set('name',$fund_profile['name'])->render(); ?>
        </div>
        <div class="half-col">
            <?php if ($kpi_summary) { ?>
                <?php /*if ($kpi_summary['is_public'] == 1) {*/
                    echo View::factory('app/profile/elements/view/kpi_summary')->set('kpi_summary',$kpi_summary)->render();
                /*} else { */?><!--
                    <?php /*if ($can_see_dataroom && $has_live_dataroom && (!$can_see_opportunity || !$opportunity)) { */?>
                        <?php /*echo View::factory('app/profile/elements/view/dataroom')->set('files_num',$dataroom_files_num)->set('user_status',$dataroom_user_status)->set('profile',$company_profile)->set('url',$dataroom_url)->set('dataroom_id',$dataroom_id)->render(); */?>
                    <?php /*} */?>
                --><?php /*}*/
            } ?>
            <?php /*echo View::factory('app/profile/elements/view/investments')->set('name',$fund_profile['name'])->set('items',$fund_portfolio)->render(); */?>
            <?php /*echo View::factory('app/profile/elements/view/venture_dept')->set('accept_venture_dept',$fund_profile['accept_venture_dept'])->set('company_name',$fund_profile['name'])->set('can_send_venture_dept',$can_send_venture_dept)->set('user_companies',$user_companies)->set('venture_dept_link',$venture_dept_link)->render(); */?>
            <?php /*if (!$is_editorial) { */?>
                <?php echo View::factory('app/profile/elements/view/team')->set('team',$team)->set('company_bobject_id',$company_bobject_id)->set('company_name',$fund_profile['name'])->set('is_editorial',$is_editorial)->render(); ?>
            <?php /*} */?>
            <?php echo View::factory('app/profile/elements/view/investments')->set('name',$fund_profile['name'])->set('items',$investments)->set('investments_link',$investments_link)->set('title',$fund_profile['name'] . ' investments')->render(); ?>
            <?php echo View::factory('app/profile/elements/view/investments')->set('name',$fund_profile['name'])->set('items',$co_investments)->set('investments_link',$co_investments_link)->set('title','Has co-investments with')->render(); ?>
            <?php /*echo View::factory('app/profile/elements/view/co_investments')->set('name',$fund_profile['name'])->set('items',$co_investments)->render(); */?>
            <?php /*if (!$is_editorial || !empty($board_members)) { */?>
                <?php echo View::factory('app/profile/elements/view/company_board_members')->set('name',$fund_profile['name'])->set('board_members',$board_members)->set('company_bobject_id',$company_bobject_id)->render(); ?>
            <?php /*} */?>
            <?php echo View::factory('app/profile/elements/view/about')->set('about',$fund_profile['about'])->set('crunchbase_id', $fund_profile['crunchbase_id'])->render(); ?>

        </div>
    </div>
</div>


<?php if ($fund_profile['accept_venture_dept'] && $can_send_venture_dept) { ?>
    <?php if (count($user_companies) > 1) { ?>
        <?php echo View::factory('app/profile/popups/view/select_company')->set('user_companies',$user_companies)->set('venture_dept_link',$venture_dept_link)->render(); ?>
    <?php } ?>
<?php } ?>
<?php if (Auth::instance()->logged_in('login')) { ?>
    <?php if (!Utils::check_user_company_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
        <?php echo View::factory('app/profile/popups/view/add_me_to_team')->set('company_id',$company_bobject_id)->set('company_name',$fund_profile['name'])->render(); ?>
    <?php } ?>
<?php } ?>