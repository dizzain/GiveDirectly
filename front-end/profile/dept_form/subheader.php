    <div class="container head-info text-head">
        <a href="<?php echo $back_link;?>">« back to <?php echo HTML::chars($name);?> profile</a><br /><br />
        <h2>venture debt application form</h2>
        <p>Please fill in this form to request a venture debt loan proposal</p>
    </div>

    <?php if($is_successful == 1){?>


    <div class="popup-outside sucsess-popup" data-modal="true" id="successful_popup" style="display: block;">
        <div class="popup-inside">

            <a href='<?php echo Navigator::getUrl('newsfeed')?>' class="closebtn js-close"><i class="icon icons-close"></i></a>

            <div class="popup-body">
                <p>application was sent successfuly</p>
                <div class="button-block">
                    <a href='<?php echo Navigator::getUrl('newsfeed')?>' class="origin-button js-close">ok</a>
                </div>


            </div>
        </div>
    </div>

    <script>
        var popup1 = $('#successful_popup');
        popup1.show();
        $('body').append('<div id="fade"></div>');
        $('#fade').css({'filter' : 'alpha(opacity=60)'}).fadeIn();

        $('.js-close').on('click', function(){
            $('[data-modal]').hide();
            $('#fade').remove();
        });
    </script>

    <?php }?>