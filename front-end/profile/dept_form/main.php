<div class="container">
<section class="simple-section with-header">
<header>
    <h1>Company information</h1>
</header>
<div class="content-part">
<form class="register-form venture-form" method="post" enctype="multipart/form-data">
<div class="top-block about-company">
    <div class="container-585">
        <div class="about-block">
            <img src="<?php echo $user_profile['info']['image']['avatar_98'] == '' ? Utils::get_null_image('avatar_98','user') : $user_profile['info']['image']['avatar_98'];?>" alt=""/>
            <div class="info-block">
                <p class="company-name"><?php echo HTML::chars($company_profile['name']);?>
                    <?php echo Utils::replace_links($company_profile['website']);?>
                </p>
                <?php if($company_profile['tagline'] != ''){?>
                <p><?php echo HTML::chars($company_profile['tagline']);?></p>
                <?php }?>
                <div class="person-block">
                    <p class="text-black">contact person</p>
                    <p class="name"><?php echo HTML::chars($user_profile['info']['name']);?></p>
                    <?php foreach($user_profile['companies'] as $c){ if($c['name'] == $company_profile['name']){?>
                    <p><?php echo HTML::chars($c['title']);?></p>
                    <?php } break;}?>
                </div>
            </div>
        </div>
        <div class="overiew-block">
            <div class="top-part">
                <p><?php foreach($company_profile['growth_stages'] as $s){ echo HTML::chars($s['name']) . ' ';}?><br>
                <?php if(count($company_profile['locations'])){?>
                    located in
                    <?php foreach($company_profile['locations'] as $l){$locs[] = $l['name'];} echo implode(', ', $locs);?>
                <?php }?>
                </p>
            </div>
            <div class="bottom-part">
                <?php echo View::factory('app/profile/elements/view/param_list_dept_form')->set('search_type','companies')->set('cap','target geographies')->set('param_cap','tg_locations')->set('items',$company_profile['tg_locations'])->render(); ?>
                <?php echo View::factory('app/profile/elements/view/param_list_dept_form')->set('search_type','companies')->set('cap','ownership')->set('param_cap','ownerships')->set('items',$company_profile['ownerships'])->render(); ?>
                <?php echo View::factory('app/profile/elements/view/param_list_dept_form')->set('search_type','companies')->set('cap','sector')->set('param_cap','sectors')->set('items',$company_profile['sectors'])->set('additional',$company_profile['client_focus'])->render(); ?>
                <?php echo View::factory('app/profile/elements/view/param_list_dept_form')->set('search_type','companies')->set('cap','revenue model')->set('param_cap','revenues')->set('items',$company_profile['revenues'])->render(); ?>
                <?php echo View::factory('app/profile/elements/view/param_text_debt_form')->set('cap','launch date')->set('item',$company_profile['launch_date'])->render(); ?>
            </div>
        </div>

        <div class="yellow-tooltip">
            You may edit company information by changing your original Dealroom profile <a href="<?php echo Navigator::get_bobject_link(2, $company_profile['url'], 'edit');?>">here</a>. <br/>Please note that this information is included into your application form.
        </div>
    </div>
</div>
<fieldset>
<p class="form-head" id="scroll-to-error">company financial statements (note: please provide all financial figures in thousands)</p>
<div class="form-part">

    <div class="alert" id="error-cont" style="display: <?php echo isset($errors) && !empty($errors) ? 'block' : 'none'; ?>;">
        <ul>
            <?php if (isset($errors) && !empty($errors)) { ?>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
    <?php echo $messages; ?>

    <div class="left-label">
        <label>currency of financial statements</label>
    </div>
    <div class="right-form-content">
        <div class="radio-form required">
            <div class="yellow-tooltip">Required text</div>
            <ul>
                <?php foreach ($statements['main'] as $key=>$value) { ?>
                    <li>
                        <input type="radio" name="statment" id="s<?php echo $key; ?>" value="<?php echo $value['key']; ?>"<?php echo Arr::get($postdata,'statement') == $value['key'] ? ' checked="checked' : ''; ?><?php echo Arr::get($postdata,'statement') == null && $key == 0 ? ' checked="checked"' : ''; ?>>
                        <label for="s<?php echo $key; ?>"><?php echo $value['key']; ?></label>
                    </li>
                <?php } ?>
                <li>
                    <input type="radio" name="statment" id="s4" value="Other"<?php echo Arr::get($postdata,'statement') == 'Other' ? ' checked="checked' : ''; ?>>
                    <label for="s4">Other</label>
                </li>
                <li>
                    <div class="select-part">
                        <div class="js-select" name="other_statment" data-select="true" onchange="$('#s4').prop('checked', true)">
                            <?php foreach ($statements['other'] as $key=>$value) { ?>
                                <option value="<?php echo $value['key']; ?>"<?php echo (Arr::get($postdata,'statement') == $value['key']) || (Arr::get($postdata,'statement') == null && $key == 0) ? ' selected="selected"' : ''; ?>><?php echo $value['key']; ?> - <?php echo $value['title']; ?></option>
                            <?php } ?>
                        </select>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>




<div class="form-part">
    <div class="left-label">
        <label>revenues</label>
    </div>
    <div class="right-form-content">
        <div class="slide-part not-required">
            <div class="amount-block">
                <div class="label-part">
                    <span class="line-label">last month </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input " name="data_res_rev_0" value="<?php echo Arr::get($postdata,'data_res_rev_0'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part">
                    <div class="full-width">
                        <select class="js-select" name="debt_needed_res_sign" data-select="true">
                            <option value="">Positive</option>
                            <option value="-" <?php if(Arr::get($postdata,'data_res_rev_0_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                        </select>
                    </div>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_rev_0" value="1" <?php echo Arr::get($postdata,'no_filling_rev_0') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block">
                <div class="label-part">
                    <span class="line-label">last year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_rev_1" value="<?php echo Arr::get($postdata,'data_res_rev_1'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part">
                    <div class="full-width">
                        <select class="js-select" name="data_res_rev_1_sign" data-select="true">
                            <option value="">Positive</option>
                            <option value="-"<?php if(Arr::get($postdata,'data_res_rev_1_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                        </select>
                    </div>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_rev_1" value="1" <?php echo Arr::get($postdata,'no_filling_rev_1') == 1 ? ' checked="checked"' : '' ; ?> ><span>N/A</span>
                </div>
            </div>
            <div class="amount-block">
                <div class="label-part">
                    <span class="line-label">current year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_rev_2" value="<?php echo Arr::get($postdata,'data_res_rev_2'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part">
                    <div class="full-width">
                        <select class="js-select" name="data_res_rev_2_sign" data-select="true">
                            <option value="">Positive</option>
                            <option value="-" <?php if(Arr::get($postdata,'data_res_rev_2_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                        </select>
                    </div>
                </div>
                <div class="select-part origin-check">
                    <input type="checkbox" name="no_filling_rev_2" value="1" <?php echo Arr::get($postdata,'no_filling_rev_2') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block">
                <div class="label-part">
                    <span class="line-label">projected next year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_rev_3" value="<?php echo Arr::get($postdata,'data_res_rev_3'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part">
                    <div class="full-width">
                        <select class="js-select" name="data_res_rev_3_sign" data-select="true">
                            <option value="">Positive</option>
                            <option value="-" <?php if(Arr::get($postdata,'data_res_rev_3_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                        </select>
                    </div>
                </div>
                <div class="select-part origin-check">
                    <input type="checkbox" name="no_filling_rev_3" value="1" <?php echo Arr::get($postdata,'no_filling_rev_3') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
        </div>
    </div>
</div>














<div class="form-part">
    <div class="left-label">
        <label>EBITDA</label>
    </div>
    <div class="right-form-content">
        <div class="slide-part not-required">
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">last month </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_ebi_0" value="<?php echo Arr::get($postdata,'data_res_ebi_0'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_ebi_0_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_ebi_0_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_ebi_0" value="1" <?php echo Arr::get($postdata,'no_filling_ebi_0') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">last year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_ebi_1" value="<?php echo Arr::get($postdata,'data_res_ebi_1'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_ebi_1_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-"<?php if(Arr::get($postdata,'data_res_ebi_1_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_ebi_1" value="1" <?php echo Arr::get($postdata,'no_filling_ebi_1') == 1 ? ' checked="checked"' : '' ; ?> ><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">current year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_ebi_2" value="<?php echo Arr::get($postdata,'data_res_ebi_2'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_ebi_2_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_ebi_2_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_ebi_2" value="1" <?php echo Arr::get($postdata,'no_filling_ebi_2') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">projected next year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_ebi_3" value="<?php echo Arr::get($postdata,'data_res_ebi_3'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_ebi_3_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_ebi_3_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_ebi_3" value="1" <?php echo Arr::get($postdata,'no_filling_ebi_3') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="form-part clearfix">
    <div class="left-label">
        <label>estimated cash burn</label>
    </div>
    <div class="right-form-content">
        <div class="slide-part not-required">
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">last month </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_cash_0" value="<?php echo Arr::get($postdata,'data_res_cash_0'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_cash_0_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_cash_0_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_cash_0" value="1" <?php echo Arr::get($postdata,'no_filling_cash_0') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">last year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_cash_1" value="<?php echo Arr::get($postdata,'data_res_cash_1'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_cash_1_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-"<?php if(Arr::get($postdata,'data_res_cash_1_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_cash_1" value="1" <?php echo Arr::get($postdata,'no_filling_cash_1') == 1 ? ' checked="checked"' : '' ; ?> ><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">current year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_cash_2" value="<?php echo Arr::get($postdata,'data_res_cash_2'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_cash_2_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_cash_2_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_cash_2" value="1" <?php echo Arr::get($postdata,'no_filling_cash_2') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
            <div class="amount-block clearfix">
                <div class="label-part">
                    <span class="line-label">projected next year </span>
                </div>
                <div class="select-part field input-thousand">
                    <input type="text" class="text-input" name="data_res_cash_3" value="<?php echo Arr::get($postdata,'data_res_cash_3'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
                </div>
                <div class="select-part select">
                    <select class="select-edit" name="data_res_cash_3_sign" data-select="true">
                        <option value="">Positive</option>
                        <option value="-" <?php if(Arr::get($postdata,'data_res_cash_3_sign') == '-'){ echo ' selected ';}?>>Negative</option>
                    </select>
                </div>
                <div class="select-part check">
                    <input type="checkbox" name="no_filling_cash_3" value="1" <?php echo Arr::get($postdata,'no_filling_cash_3') == 1 ? ' checked="checked"' : '' ; ?>><span>N/A</span>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="form-part clearfix">
    <div class="left-label">
        <label>if negative cash-flow: projected number of months to break-even</label>
    </div>
    <div class="right-form-content">
        <div class="select-part big-select">
            <select class="select-edit width-437" name="negative_cash_flow" data-select="true">
                <?php for ($i=1;$i<=24;$i++) { ?>
                    <option value="<?php echo $i; ?>"<?php echo Arr::get($postdata,'negative_cash_flow') == $i ? ' selected="selected"' : ''; ?>><?php echo $i; ?> month<?php echo $i > 1 ? 's' : ''; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="yellow-tooltip">
            Number of months from today to break-even. Required field
        </div>
    </div>

</div>
<div class="form-part clearfix">
    <div class="left-label">
        <label>comments</label>
    </div>
    <div class="right-form-content">
        <textarea name="comments"><?php echo Arr::get($postdata,'comments'); ?></textarea>
        <div class="grey-tooltip">
            Please comment on any seasonality or other extraordinary items
        </div>
    </div>
</div>
</fieldset>
<fieldset>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>outstanding financial debt</label>
        </div>
        <div class="right-form-content required input-thousand">
                    <input type="text" class="text-input necessary-field" name="outstanding_financial_debt_res" value="<?php echo Arr::get($postdata,'outstanding_financial_debt_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>



        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>leases and other long-term operating liabilities</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field" name="leases_res" value="<?php echo Arr::get($postdata,'leases_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>cash &amp; equivalents</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field" name="cash_res" value="<?php echo Arr::get($postdata,'cash_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>book equity today</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field" name="book_res" value="<?php echo Arr::get($postdata,'book_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
        </div>
    </div>
</fieldset>
<fieldset>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>amount of venture debt needed</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field" name="debt_needed_res" value="<?php echo Arr::get($postdata,'debt_needed_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>

            <div class="yellow-tooltip">
                Please indicate the amount of venture debt needed. Required field
            </div>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>new equity investment alongside venture debt</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field" name="new_equity_res" value="<?php echo Arr::get($postdata,'new_equity_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>

            <div class="yellow-tooltip">
                Most venture debt providers prefer new equity to be invested concurrent with the venture debt<br/> investment. Please give an estimate. Required field
            </div>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>existing equity</label>
        </div>
        <div class="right-form-content required input-thousand">
            <input type="text" class="text-input necessary-field js-k-input" name="existing_equity_res" value="<?php echo Arr::get($postdata,'existing_equity_res'); ?>" onkeyup="return check_number_field(this);" onchange="check_number_field(this);"/>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>providers of new equity</label>
        </div>
        <div class="right-form-content check-list">
            <div class="form-part origin-check">
                <input type="checkbox" value="1" name="providers_founders" id="egs" class="necessary-field"<?php echo Arr::get($postdata,'providers_founders') == 1 ? ' checked="checked"' : ''; ?>/>
                <label for="egs">Founders</label>

            </div>
            <div class="form-part origin-check">
                <input type="checkbox" id="lgs" value="1" name="providers_existing_shareholders" class="necessary-field"<?php echo Arr::get($postdata,'providers_existing_shareholders') == 1 ? ' checked="checked"' : ''; ?>/>
                <label for="lgs">Existing shareholders</label>

            </div>
            <div class="form-part origin-check">
                <input type="checkbox" value="1" id="ms" name="providers_new_investor" class="necessary-field"<?php echo Arr::get($postdata,'providers_new_investor') == 1 ? ' checked="checked"' : ''; ?>/>
                <label for="ms">New investor</label>

            </div>
        </div>
    </div>

    <div class="form-part clearfix">
        <div class="left-label">
            <label>use of proceeds</label>
        </div>
        <div class="right-form-content">
            <textarea class="necessary-field" name="use_of_proceeds"><?php echo Arr::get($postdata,'use_of_proceeds'); ?></textarea>
            <div class="yellow-tooltip">
                Use venture loan for instance for refinancing, growth, working capital, other. Required
            </div>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>funds needed by (date)</label>
        </div>
        <div class="right-form-content required">
            <input type="text" class="text-input necessary-field" name="date_needed" value="<?php echo Arr::get($postdata,'date_needed'); ?>"/>
            <div class="yellow-tooltip">
                When is the final date you need funds on the account. Required field
            </div>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>other comment</label>
        </div>
        <div class="right-form-content ">
            <textarea name="other_comment"><?php echo Arr::get($postdata,'other_comment'); ?></textarea>
        </div>
    </div>
    <div class="form-part clearfix">
        <div class="left-label">
            <label>upload financial statements</label>
        </div>
        <div class="right-form-content">
            <?php /*if ($file_link) { */?><!--
                <a href="<?php /*echo $file_link; */?>" target="_blank">Uploaded file link</a><br />
                <input type="hidden" name="file_link" value="<?php /*echo $file_link; */?>" />
                or upload another
            --><?php /*}*/ ?>
            <div class="fileform">
                <div id="fileformlabel"></div>
                <div class="origin-button" id="plupload-upload-button">browse</div><!-- onchange="getName(this.value);"-->
                <!--<input type="file" name="upload" id="upload"  onchange="getName(this.value);" />-->

            </div>
            <div id="plupload-errors"></div>
            <ul class="file-list" id="plupload-filelist">
                <?php $debt_files = Arr::get($postdata,'dept_files'); ?>
                <?php if ($debt_files && !empty($debt_files)) { ?>
                    <?php foreach ($debt_files as $file) { ?>
                        <?php $file_data = explode('||',$file); ?>
                        <li>
                            <img src="<?php echo Navigator::getUrl('asset/layouts/app_default/img/loader.gif'); ?>" class="plupload-loader" style="opacity: 0;" />
                            <a href="#"><?php echo $file[0]; ?></a>
                            <a class="del-link icon-delete do-delete-file" href="#"></a>
                            <input type="hidden" name="debt_files[]" value="<?php echo $file; ?>" />
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
            <!--<div id="plupload-hidden">
                <?php /*if ($debt_files && !empty($debt_files)) { */?>
                    <?php /*foreach ($debt_files as $file) { */?>
                    <?php /*} */?>
                <?php /*} */?>
            </div>-->


        </div>
    </div>
</fieldset>
<fieldset>
    <div class="form-part text-part clearfix">
        <div class="left-label origin-check">
            <input type="checkbox" id="confidentiality_submit" name="confidentiality_submit" value="1"/>
        </div>
        <div class="right-form-content">
            By submitting this form, I understand that I allow Dealroom to submit the abovementioned information (“Confidential Information”) to any of the Venture Debt funds active on Dealroom. Both Dealroom and the Venture Debt funds (the “Receiving Party”) will treat the Confidential Information I provide confidentially and handle it with a commercially reasonable degree of care.
        </div>
    </div>
    <div class="form-part text-part clearfix">
        <div class="left-label">
            <label>confidentiality clause</label>
        </div>
        <div class="right-form-content">
            <p>The Confidential Information disclosed by you (the “Information Owner”) to the Receiving Party will be used by the Receiving Party solely for the purpose of a <i>preliminary evaluation</i> of your company in the context of a potential Venture Debt loan, or otherwise for the benefit of the Information Owner pursuant to a written agreement with Information Owner and will not, without the prior written consent of the Information Owner, be divulged, furnished or otherwise disclosed, orally or in writing, except that the Confidential Information or portions thereof may be disclosed to the Receiving Party’s employees, officers, directors, legal counsel  and employees, officers, directors, and legal counsel of its parent or any subsidiary or affiliated companies with a legitimate need to know such Confidential Information for the above-stated purpose and who are subject to an appropriate non-disclosure obligation. The Receiving Party shall use the same measures to avoid publication, disclosure or dissemination as the Receiving Party uses with similar information of its own which it desires not to have published, disclosed or disseminated (but no less than a commercially reasonable degree of care).</p>
        </div>
    </div>
</fieldset>
<div class='form-part button-part'>
    <input type="submit" class="blue-button" value="send the application form &raquo;" />

</div>
</form>
</div>
</section>
</div>
<script>
function check_number_field(input) {
    //alert(accounting.formatNumber(5318008));
    input.value = input.value.replace(/[^\d\.]/g, '');
    input.value = accounting.formatNumber(input.value, 0);
    if(input.value == 0){
        input.value = '';
    }

    //input.value = input.value.replace(/[^\d\.]/g, '');
};
</script>