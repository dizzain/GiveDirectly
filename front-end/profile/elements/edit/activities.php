<section class="simple-section with-header">
    <header>
        <h1><?php echo $activity_title; ?></h1>
    </header>
    <div class="content-part">
        <ul class="updates-list" id="<?php echo $type; ?>-activity">
            <li class="activity-first" style="display: none;">
                <p></p>
                <span class="time"></span>
                <div class="link-option">
                    <a class="edit-link icon-pen-blue edit-activity" href="#"></a>
                    <a class="delete-link icon-garbage-blue delete-activity" href="#"></a>
                </div>
            </li>
            <li class="activity-list" style="display:none;">
                <ul class="updates-list hide-text" data-text="more-info">
                    <li>
                        <p></p>
                        <span class="time"></span>
                        <div class="link-option">
                            <a class="edit-link icon-pen-blue edit-activity" href="#"></a>
                            <a class="delete-link icon-garbage-blue delete-activity" href="#"></a>
                        </div>
                    </li>
                </ul>
                <a href="#" data-original-text="view all updates" class="activity-toggle">view all updates</a>
            </li>
            <li>
                <form class="updates-form activity-add">
                    <textarea name="activity_text" class="base-input"></textarea><p class="count count_f2">250</p>
                    <a href="#" class="origin-button add-activity">publish</a>
                    <a href="#" class="origin-button undo-activity">undo</a>
                </form>
            </li>
        </ul>


    </div>

</section>