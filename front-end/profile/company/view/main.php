
<div class="section-content container-956">

    <section class="simple-section with-padding">
        <div class="head-info">
            <div class="photo-block">
                <img src="<?php echo $company_profile['avatar_url'] !== null ? Files::factory('image','s3')->get_image_url($company_profile['avatar_url'], 'avatar_98', 'company') : Utils::get_null_image('avatar_98','company'); ?>" alt=""/>
            </div>
            <div class="info-part">
                <div class="about-part">
                    <h2 class="<?php echo $company_profile['seeking_financing'] == 1 ? 'deal-flag' : ''; ?> <?php echo $company_profile['is_press'] == 0 ? '' : 'label-press';?>"><?php echo $company_profile['name']; ?></h2>
                    <p><?php echo !empty($company_profile['tagline']) ? $company_profile['tagline'] : '&nbsp;'; ?></p>

                <div>
                    <ul class="block-list">
                        <li>
                            <?php echo !empty($company_profile['google']) && $company_profile['google'] !== null ? '<a href="'.(strpos($company_profile['google'],'http') === 0 ? $company_profile['google'] : 'http://'.$company_profile['google']).'" class="social-link" target="_blank"><i class="icon icons-gplus"></i></a>' : ''; ?>
                            <?php echo !empty($company_profile['twitter']) && $company_profile['twitter'] !== null ? '<a href="'.(strpos($company_profile['twitter'],'http') === 0 ? $company_profile['twitter'] : 'http://'.$company_profile['twitter']).'" class="social-link" target="_blank"><i class="icon icons-twitter"></i></a>' : ''; ?>
                            <?php echo !empty($company_profile['facebook']) && $company_profile['facebook'] !== null ? '<a href="'.(strpos($company_profile['facebook'],'http') === 0 ? $company_profile['facebook'] : 'http://'.$company_profile['facebook']).'" class="social-link" target="_blank"><i class="icon icons-facebook"></i></a>' : ''; ?>
                            <?php echo !empty($company_profile['linkedin']) && $company_profile['linkedin'] !== null ? '<a href="'.(strpos($company_profile['linkedin'],'http') === 0 ? $company_profile['linkedin'] : 'http://'.$company_profile['linkedin']).'" class="social-link" target="_blank"><i class="icon icons-linkedin"></i></a>' : ''; ?>
                            <?php echo !empty($company_profile['crunchbase']) && $company_profile['crunchbase'] !== null ? '<a href="'.(strpos($company_profile['crunchbase'],'http') === 0 ? $company_profile['crunchbase'] : 'http://'.$company_profile['crunchbase']).'" class="social-link" target="_blank"><i class="icon icons-crunchbase"></i></a>' : ''; ?>
                            <?php if (empty($company_profile['google']) and empty($company_profile['twitter']) and empty($company_profile['facebook']) and empty($company_profile['linkedin']) and empty($company_profile['crunchbase'])) {
                                    echo '<span class="empty-icons">&nbsp;</span>';
                            }
                            ?>
                        </li>
                        <li>
                            <?php echo Utils::make_link($company_profile['website'],true,null,'<br />'); ?>
                        </li>
                    </ul>
                </div>


                    <!-- <p class="inline-text">tracked by <span id="followers_num"><?php echo $followers_num; ?></span> <span id="person_people"><?php echo ($followers_num == 1 ? 'person' : 'people');?></span>, tracking <?php echo $followings_num; ?>  <span class="tooltip">dealroom.co does not disclose who are tracking this profile, except to the owner of the profile</span></p> -->
                </div>

                <div class="social-part">
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <?php if (Utils::can_follow(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
                            <span class="with-tooltip">
                            <a href="#" class="origin-button blue-button do-track" data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?>>+ add to tracking list<span class="tooltip one-line right-position">follow every move of <?php echo $company_profile['name']; ?></span></a>
                            <!--<span class="tooltip one-line right-position">follow every move of <?php echo $company_profile['name']; ?></span>-->
                            <a href="#" class="origin-button do-untrack " data-bobject-id="<?php echo $company_bobject_id; ?>"<?php echo !Utils::check_follow(BData::instance()->get('bobject_id'),$company_bobject_id) ? ' style="display:none;"' : ''; ?> style="width: 160px; text-align: center;"> &#10003; tracking<span class="tooltip one-line right-position">stop tracking</span></a>
                            </span>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#" class="origin-button pp-login">track us</a>
                    <?php } ?>
                    <?php if (Auth::instance()->logged_in('login')) { ?>
                        <span class="introduction-button-spacer">
                            <a href="#" class="origin-button do-get-introduction center-text" data-company-id="<?php echo $company_bobject_id; ?>" style="width: 160px;">
                                <?php if (BData::instance()->get('bobject_type') == 1 || BData::instance()->get('has_funds')) { ?>
                                    request info
                                <?php } else { ?>
                                    get an introduction
                                <?php } ?>
                            </a>
                        </span>
                    <?php } ?>
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

            <section class="simple-section with-header with-tags">
                <header>
                    <h1>Overview</h1>
                     <?php if ($company_profile['momentums'] && !empty($company_profile['momentums'])) { ?>
                        <ul class="tags-list">
                            <?php foreach ($company_profile['momentums'] as $momentum) { ?>
                                <li>
                                    <span>#<?php echo $momentum['name']; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </header>
                <div class="content-block">
                    <!--<p><?php /*echo Utils::make_profile_text('company','',$company_profile['growth_stages'],$company_profile['tr_number_empl'],$company_profile['locations'] !== null ? $company_profile['locations'] : array()); */?></p>-->

                    <?php echo View::factory('app/profile/elements/view/param_list_tags')->set('search_type','companies')->set('param_cap','categories')->set('items',$company_profile['categories_company'])->set('additional_class','industry-tags')->render();  ?>
                    <?php echo View::factory('app/profile/elements/view/param_list_tags')->set('search_type','companies')->set('param_cap','sectors')->set('items',$company_profile['sectors'])->render();  ?>

                    <div class="bottom-part">
                        <?php /*echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','industry')->set('param_cap','categories')->set('items',$company_profile['categories_company'])->render();  */?><!--
                        --><?php /*echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','tags')->set('param_cap','sectors')->set('items',$company_profile['sectors'])->render(); */?>
                        <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','location')->set('param_cap','locations')->set('items',$company_profile['locations'])->set('check_country_clickable',true)->render(); ?>
                        <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','target markets')->set('param_cap','tg_locations')->set('items',$company_profile['tg_locations'])->set('check_country_clickable',true)->render(); ?>
                        <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','ownership')->set('param_cap','ownerships')->set('items',$company_profile['ownerships'])->render(); ?>
                        <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','b2b / b2c')->set('param_cap','client_focus')->set('items',$company_profile['client_focus'])->render(); ?>
                        <?php echo View::factory('app/profile/elements/view/param_list')->set('search_type','companies')->set('cap','revenue model')->set('param_cap','revenues')->set('items',$company_profile['revenues'])->render(); ?>
                        <?php /*echo View::factory('app/profile/elements/view/param_text')->set('cap','launch date')->set('item',$company_profile['launch_date'])->render(); */?>
                        <?php echo View::factory('app/profile/elements/view/param_text_ext')->set('search_type','companies')->set('cap','delivery method')->set('search_key','delivery_methodss')->set('item',$company_profile['delivery_method'])->render(); ?>
                    </div>
                </div>

            </section>


            <?php
            if (!empty($visitors) or !empty($sources) or !empty($top_countries) or !empty($related_sites)) {
            ?>
            <section class="simple-section with-header with-tags">
                <header>
                    <h1>Traffic stats</h1>
                </header>
                <div class="content-block">
                    <div class="bottom-part">
                        <div class="overview-part">
                        <?php
                            if (!empty($visitors)) {
                        ?>
                            <div class="name"><span>visitors</span></div>
                            <div class="description">
                                <?php
                                    if (!empty($date)) {
                                        $date = explode('/', $date);
                                        $date = '(' . date('M Y', strtotime("{$date[1]}/{$date[0]}/01")) . ')';
                                    }
                                    echo "{$visitors} {$date}"; 
                                ?>
                            </div>
                        <?php } ?>
                        </div>

                        <div class="overview-part">
                            <?php
                                if (!empty($growth) and is_numeric($growth)) {
                            ?>
                                <div class="name"><span>annual growth</span></div>
                                <div class="description">
                                    <?php
                                        echo number_format($growth, 1) . '%';
                                    ?>
                                </div>
                            <?php
                                }
                            ?>
                        </div> 
                        
                        <div class="overview-part">
                            <?php
                                if (!empty($sources) and is_array($sources)) {                            
                            ?>
                                <div class="name"><span>sources</span></div>
                                <div class="description">
                                    <?php
                                     $display_sources = null;
                                     foreach($sources as $source => $value) {
                                        $value = number_format($value, 2);
                                        $source = strtolower($source);
                                        $display_sources .= "{$source} {$value}%, ";
                                     }
                                     // display the string, remove the last comma
                                     echo rtrim($display_sources, ', ');
                                    ?>
                                </div>
                            <?php 
                                } 
                            ?>
                        </div>
                        <div class="overview-part">
                            <?php
                                if (!empty($top_countries) and is_array($top_countries)) {
                            ?>
                                <div class="name"><span>top countries</span></div>
                                <div class="description">
                                    <?php
                                        $display_countries = null;
                                        foreach($top_countries as $country => $value) {
                                            $value = number_format($value, 1);
                                            $display_countries .= "{$country} ({$value}%), ";
                                        }
                                        // display the string, remove the last comma
                                        echo rtrim($display_countries, ', ');
                                    ?>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="overview-part">
                            <?php
                                if (!empty($related_sites) and is_array($related_sites)) {
                            ?>
                                <div class="name"><span>related sites</span></div>
                                <div class="description">
                                    <?php
                                        $display_sites = null;
                                        foreach ($related_sites as $site) {
                                             $display_sites .= "<a href=\"http://{$site}\" target=\"_blank\">{$site}</a>, ";
                                        }
                                        // display the string, remove the last comma
                                        echo rtrim($display_sites, ', ');
                                    ?>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <br /><br />
                        <p align="right">
                        Data provided by <img src="/asset/images/similar-web-logo.png" alt="Similar Web API" /> 
                        (<a href="http://similarweb.com/website/<?php echo $domain; ?>" target="_blank">full report</a>)
                        </p>
                    </div>
                </div>                
            </section>
            <?php } ?>

            <?php echo View::factory('app/profile/elements/view/fundings')->set('name','Funding')->set('items',$company_profile['fundings'])->render(); ?>
            <?php echo View::factory('app/profile/elements/view/recent_fundings')->set('name','Recent funding in this industry')->set('items',$recent_fundings)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/news')->set('name',$company_profile['name'])->set('items',$ee_news)->set('news_link',$news_link)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/media')->set('media',$media)->render(); ?>
        </div>
        <div class="half-col">

            <?php echo View::factory('app/profile/elements/view/kpi_new')->set('company_profile',$company_profile)->set('kpi',$kpi_summary)->render(); ?>

            <?php /*if ($kpi_summary) { */?>
                <?php /*if ($kpi_summary['is_public'] == 1) {*/
                    /*echo View::factory('app/profile/elements/view/kpi_summary')->set('kpi_summary',$kpi_summary)->render();*/
                /*} else { */?><!--
                    <?php /*if ($can_see_dataroom && $has_live_dataroom && (!$can_see_opportunity || !$opportunity)) { */?>
                        <?php /*echo View::factory('app/profile/elements/view/dataroom')->set('files_num',$dataroom_files_num)->set('user_status',$dataroom_user_status)->set('profile',$company_profile)->set('url',$dataroom_url)->set('dataroom_id',$dataroom_id)->render(); */?>
                    <?php /*} */?>
                --><?php /*}*/
            /*} */?>
            <?php echo View::factory('app/profile/elements/view/team')->set('company_name',$company_profile['name'])
                                                                      ->set('team',$team)
                                                                      ->set('company_bobject_id',$company_bobject_id)
                                                                      ->set('is_editorial', $is_editorial)
                                                                      ->render(); ?>

            <?php echo View::factory('app/profile/elements/view/investors')->set('investors',$investors)->set('company_bobject_id',$company_bobject_id)->set('company_name',$company_profile['name'])->render(); ?>
            <?php /*if (!$is_editorial || !empty($board_members)) { */?>
                <?php echo View::factory('app/profile/elements/view/company_board_members')->set('name',$company_profile['name'])->set('board_members',$board_members)->set('company_bobject_id',$company_bobject_id)->render(); ?>
            <?php /*} */?>
            <?php echo View::factory('app/profile/elements/view/trading_multiples')->set('trading_multiples',$trading_multiples)->set('company_bobject_id',$company_bobject_id)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/transaction_multiples')->set('transaction_multiples',$transaction_multiples)->set('company_bobject_id',$company_bobject_id)->render(); ?>
            <?php echo View::factory('app/profile/elements/view/activity')->set('activities',$activities)->set('name',$company_profile['name'])->render(); ?>
            <?php echo View::factory('app/profile/elements/view/about')->set('about',$company_profile['about'])->set('crunchbase_id', $company_profile['crunchbase_id'])->render(); ?>
            <?php echo View::factory('app/profile/elements/view/followers')->set('followers',$followers)->set('can_see_followers',$can_see_followers)->set('company_name',$company_profile['name'])->render(); ?>

        </div>
    </div>
</div>

<?php echo View::factory('app/profile/popups/view/add_as_investor')->render(); ?>
<?php if (Auth::instance()->logged_in('login')) { ?>
    <?php if (!Utils::check_user_company_relation(BData::instance()->get('bobject_id'),$company_bobject_id)) { ?>
        <?php echo View::factory('app/profile/popups/view/add_me_to_team')->set('company_id',$company_bobject_id)->set('company_name',$company_profile['name'])->render(); ?>
    <?php } ?>
<?php } ?>