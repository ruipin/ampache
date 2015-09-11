<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2015 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

$thcount = 5;
?>
<script language="javascript" type="text/javascript">
    public function getSelectionArray()
    {
        var checked = []
        $("input[name='pvmsg_select[]']:checked").each(function () {
            checked.push(parseInt($(this).val()));
        });
        return checked.join(",");
    }
</script>
<div id="information_actions">
    <ul>
        <li><a href="<?php echo AmpConfig::get('web_path'); ?>/pvmsg.php?action=show_add_message"><?php echo UI::get_icon('mail', T_('Compose')); ?> <?php echo T_('Compose a new message'); ?></a></li>
        <li><a href="javascript:NavigateTo('<?php echo AmpConfig::get('web_path'); ?>/pvmsg.php?action=set_is_read&read=1&msgs=' + getSelectionArray());"><?php echo T_('Set as read'); ?></a></li>
        <li><a href="javascript:NavigateTo('<?php echo AmpConfig::get('web_path'); ?>/pvmsg.php?action=set_is_read&read=0&msgs=' + getSelectionArray());"><?php echo T_('Set as unread'); ?></a></li>
        <li><a href="javascript:NavigateTo('<?php echo AmpConfig::get('web_path'); ?>/pvmsg.php?action=delete&msgs=' + getSelectionArray());"><?php echo UI::get_icon('delete', T_('Delete')); ?> <?php echo T_('Delete'); ?></a></li>
    </ul>
</div>
<?php if ($browse->get_show_header()) {
    require AmpConfig::get('prefix') . UI::find_template('list_header.inc.php');
} ?>
<table class="tabledata" cellpadding="0" cellspacing="0" data-objecttype="label">
    <thead>
        <tr class="th-top">
            <th class="cel_select essential persist"></th>
            <th class="cel_subject essential persist"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=subject', T_('Subject'),'pvmsg_sort_subject'); ?></th>
            <th class="cel_from_user essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=from_user', T_('Sender'),'pvmsg_sort_from_user'); ?></th>
            <th class="cel_to_user essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=to_user', T_('Recipient'),'pvmsg_sort_to_user'); ?></th>
            <th class="cel_creation_date essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=creation_date', T_('Date'),'pvmsg_sort_creation_date'); ?></th>
            <th class="cel_action essential"><?php echo T_('Action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* Foreach through every label that has been passed to us */
        foreach ($object_ids as $pvmg_id) {
            $libitem = new PrivateMsg($pvmg_id);
            $libitem->format();
            ?>
        <tr id="label_<?php echo $libitem->id;
            ?>" class="<?php echo UI::flip_class();
            ?> <?php echo (!$libitem->is_read) ? "unread" : "" ?>">
            <?php require AmpConfig::get('prefix') . UI::find_template('show_pvmsg_row.inc.php');
            ?>
        </tr>
        <?php 
        } ?>
        <?php if (!count($object_ids)) {
    ?>
        <tr class="<?php echo UI::flip_class();
    ?>">
            <td colspan="<?php echo $thcount;
    ?>"><span class="nodata"><?php echo T_('No message found');
    ?></span></td>
        </tr>
        <?php 
} ?>
    </tbody>
    <tfoot>
        <tr class="th-bottom">
            <th class="cel_select essential persist"></th>
            <th class="cel_subject essential persist"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=subject', T_('Subject'),'pvmsg_sort_subject'); ?></th>
            <th class="cel_from_user essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=from_user', T_('Sender'),'pvmsg_sort_from_user'); ?></th>
            <th class="cel_to_user essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=to_user', T_('Recipient'),'pvmsg_sort_to_user'); ?></th>
            <th class="cel_creation_date essential"><?php echo Ajax::text('?page=browse&action=set_sort&browse_id=' . $browse->id . '&type=pvmsg&sort=creation_date', T_('Date'),'pvmsg_sort_creation_date'); ?></th>
            <th class="cel_action essential"><?php echo T_('Action'); ?></th>
        </tr>
    </tfoot>
</table>

<?php show_table_render(); ?>
<?php if ($browse->get_show_header()) {
    require AmpConfig::get('prefix') . UI::find_template('list_header.inc.php');
} ?>