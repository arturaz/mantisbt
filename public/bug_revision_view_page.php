<?php
# Mantis - a php based bugtracking system

# Mantis is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# Mantis is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Mantis.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team   - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses bug_api.php
 * @uses bugnote_api.php
 * @uses bug_revision_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses form_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses string_api.php
 * @uses user_api.php
 */

use MantisBT\Exception\UnspecifiedException;

/**
 * MantisBT Core API's
 */
require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'bug_api.php' );
require_api( 'bugnote_api.php' );
require_api( 'bug_revision_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'form_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );
require_api( 'string_api.php' );
require_api( 'user_api.php' );

$f_bug_id = gpc_get_int( 'bug_id', 0 );
$f_bugnote_id = gpc_get_int( 'bugnote_id', 0 );
$f_rev_id = gpc_get_int( 'rev_id', 0 );

$t_title = '';

if ( $f_bug_id ) {
	$t_bug_id = $f_bug_id;
	$t_bug_data = bug_get( $t_bug_id, true );
	$t_bug_revisions = array_reverse( bug_revision_list( $t_bug_id ), true );

	$t_title = _('Issue #') . $t_bug_id;

} else if ( $f_bugnote_id ) {
	$t_bug_id = bugnote_get_field( $f_bugnote_id, 'bug_id' );
	$t_bug_data = bug_get( $t_bug_id, true );

	$t_bug_revisions = array_reverse( bug_revision_list( $t_bug_id, REV_ANY, $f_bugnote_id ), true );

	$t_title = _('Note') . ' ' . $f_bugnote_id;

} else if ( $f_rev_id ) {
	$t_bug_revisions = array_reverse( bug_revision_like( $f_rev_id ), true );

	if ( count( $t_bug_revisions ) < 1 ) {
		throw new UnspecifiedException();
	}

	$t_bug_id = $t_bug_revisions[$f_rev_id]['bug_id'];
	$t_bug_data = bug_get( $t_bug_id, true );

	$t_title = _('Issue #') . $t_bug_id;

} else {
	throw new UnspecifiedException();
}

function show_revision( $t_revision ) {
	static $s_can_drop = null;
	static $s_drop_token = null;
	static $s_user_access = null;

	if ( is_null( $s_can_drop ) ) {
		$s_can_drop = access_has_bug_level( config_get( 'bug_revision_drop_threshold' ), $t_revision['bug_id'] );
		$s_drop_token = form_security_param( 'bug_revision_drop' );
	}

	switch( $t_revision['type'] ) {
	case REV_DESCRIPTION:
		$t_label = _('Description');
		break;
	case REV_STEPS_TO_REPRODUCE:
		$t_label = _('Steps To Reproduce');
		break;
	case REV_ADDITIONAL_INFO:
		$t_label = _('Additional Information');
		break;

	case REV_BUGNOTE:
		if ( is_null( $s_user_access ) ) {
			$s_user_access = access_has_bug_level( config_get( 'private_bugnote_threshold' ), $t_revision['bug_id'] );
		}

		if ( !$s_user_access ) {
			return null;
		}

		$t_label = _('Note');
		break;

	default:
		$t_label = '';
	}

$t_by_string = sprintf( _('%1 by %2'), string_display_line( date( config_get( 'normal_date_format' ), $t_revision['timestamp'] ) ), string_display_line( user_get_name( $t_revision['user_id'] ) ) );

?>
<tr class="spacer"><td><a id="revision-<?php echo $t_revision['id'] ?>"></a></td></tr>

<tr>
<th class="category"><?php echo _('Revision') ?></th>
<td colspan="2"><?php echo $t_by_string ?></td>
<td class="center" width="5%">
<?php if ( $s_can_drop ) {
	print_bracket_link( 'bug_revision_drop.php?id=' . $t_revision['id'] . $s_drop_token, _('Drop') );
} ?>
</td>
</tr>

<tr>
<th class="category"><?php echo $t_label ?></th>
<td colspan="3"><?php echo string_display_links( $t_revision['value'] ) ?></td>
</tr>

	<?php
}

html_page_top( bug_format_summary( $t_bug_id, SUMMARY_CAPTION ) );

print_recently_visited();

?>

<br/>
<table class="width100" cellspacing="1">

<tr>
<td class="form-title" colspan="2"><?php echo _('View Revisions'), ': ', $t_title ?></td>
<td class="right" colspan="2">
<?php
if ( !$f_bug_id && !$f_bugnote_id ) { print_bracket_link( '?bug_id=' . $t_bug_id, _('All Revisions') ); }
print_bracket_link( 'view.php?id=' . $t_bug_id, _('Back to Issue') );
?>
</td>
</tr>

<tr>
<th class="category" width="15%"><?php echo _('Summary') ?></th>
<td colspan="3"><?php echo bug_format_summary( $t_bug_id, SUMMARY_FIELD ) ?></td>
</tr>

<?php foreach( $t_bug_revisions as $t_rev ) {
	show_revision( $t_rev );
} ?>

</table>

<?php
html_page_bottom();

