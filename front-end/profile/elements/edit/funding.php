<section class="simple-section with-header" id="<?php echo $type; ?>-<?php echo $item; ?>">
    <header>
        <h1><?php echo $title; ?></h1>
        <a href="#" class="add-link-small add-link-small-disabler header-link <?php echo $item; ?>-add-button"><i class="icon icons-plus-black"></i></a>
    </header>
    <div class="content-part with-table <?php echo $item; ?>-show-container" style="display: none;">
        <table class="funding-table <?php echo $item; ?>-table-container origin-table" style="display: none;">
            <thead>
                <tr class="<?php echo $item; ?>-table-header">
                    <th><span class="date">date</span></th>
                    <th><span class="round">round</span></th>
                    <th><span class="investor">investors</span></th>
                    <th><span class="money-td">amount</span></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="<?php echo $item; ?>-table-total-row" style="display: none;">
                    <td colspan="3" class="bottom-td total">total funding:</td>
                    <td class="bottom-td cost"><span class="money-td"><span class="total-currency"></span> <span class="total-amount"></span></span></td>
                    <td class="bottom-td"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>