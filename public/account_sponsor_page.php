<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * CALLERS
 *	This page is called from:
 *	- print_menu()
 *	- print_account_menu()
 *
 * EXPECTED BEHAVIOUR
 *	- Display the user's current sponsorships
 *	- Allow the user to edit the payment flag
 *
 * CALLS
 *	This page calls the following pages:
 *	- account_sponsor_update.php  (to save changes)
 *
 * RESTRICTIONS & PERMISSIONS
 *	- User must be authenticated, and not anonymous
 *   - sponsorship must be enabled
 *
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses authentication_api.php
 * @uses bug_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses current_user_api.php
 * @uses database_api.php
 * @uses form_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses project_api.php
 * @uses sponsorship_api.php
 * @uses string_api.php
 * @uses version_api.php
 */

use MantisBT\Exception\Access\AccessDenied;
use MantisBT\Exception\Sponsorship\SponsorshipDisabled;

require_once( 'core.php' );
require_api( 'authentication_api.php' );
require_api( 'bug_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'current_user_api.php' );
require_api( 'database_api.php' );
require_api( 'form_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );
require_api( 'project_api.php' );
require_api( 'sponsorship_api.php' );
require_api( 'string_api.php' );
require_api( 'version_api.php' );

require_css( 'status_config.php' );

if ( !config_get( 'enable_sponsorship' ) ) {
	throw new SponsorshipDisabled();
}

# anonymous users are not allowed to sponsor issues
if ( current_user_is_anonymous() ) {
	throw new AccessDenied();
}

$t_show_all = gpc_get_bool( 'show_all', false );

# start the page
html_page_top( _('My Sponsorships') );

$t_project = helper_get_current_project();
?>
<br />
<table class="width100" cellspacing="1">
<tr>
	<td class="form-title">
		<?php echo _('My Sponsorships') ?>
	</td>
	<td class="right">
		<?php print_account_menu( 'account_sponsor_page.php' ) ?>
	</td>
</tr>
</table>
<?php
# get issues user has sponsored
$t_user = auth_get_current_user_id();
$t_resolved = config_get( 'bug_resolved_status_threshold' );
$t_payment = config_get( 'payment_enable', 0 );

$t_project_clause = helper_project_specific_where( $t_project );

$t_query = "SELECT b.id as bug, s.id as sponsor, s.paid, b.project_id, b.fixed_in_version, b.status
	FROM {bug} b, {sponsor} s
	WHERE s.user_id=" . db_param() . " AND s.bug_id = b.id " .
	( $t_show_all ? '' : 'AND ( b.status < ' . db_param() . ' OR s.paid < ' . SPONSORSHIP_PAID . ')' ) . "
	AND $t_project_clause
	ORDER BY s.paid ASC, b.project_id ASC, b.fixed_in_version ASC, b.status ASC, b.id DESC";

$t_result = db_query_bound( $t_query, $t_show_all ? array( $t_user ) : array( $t_user , $t_resolved ) );

$t_sponsors = array();
while ( $t_row = db_fetch_array( $t_result ) ) {
	$t_sponsors[] = $t_row;
}

$t_sponsor_count = count( $t_sponsors );
if ( $t_sponsor_count === 0 ) {
	echo '<p>' . _('You have not sponsored any issues.') . '</p>';
} else {
?>

<!-- # Edit own sponsorship Form BEGIN -->
<br />
<div>
<table class="width100" cellspacing="1">

	<!-- Headings -->
	<tr>
		<td class="form-title" colspan="9">
			<?php echo _('Issues You have Sponsored:') ?>
		</td>
	</tr>
	<tr>
		<td class="form-title" width="10%"><?php echo _('Issue ID') ?></td>
		<td class="form-title" width="8%"><?php echo _('Project') ?></td>
		<td class="form-title" width="7%"><?php echo _('Fixed in Version') ?></td>
		<td class="form-title" width="10%"><?php echo _('Status') ?></td>
		<td class="form-title" width="10%"><?php echo _('Assigned To') ?></td>
		<td class="form-title" width="30%"><?php echo _('Summary') ?></td>
		<td class="form-title" width="8%"><?php echo _('Amount') ?></td>
		<td class="form-title" width="7%"><?php echo _('Status') ?></td>
		<td class="form-title" width="10%">&#160;</td>
	</tr>
<?php
	$t_total_owing = 0;
	$t_total_paid = 0;
	for ( $i = 0; $i < $t_sponsor_count; ++$i ) {
		$t_sponsor_row = $t_sponsors[$i];
		$t_bug = bug_get( $t_sponsor_row['bug'] );
		$t_sponsor = sponsorship_get( $t_sponsor_row['sponsor'] );

		# describe bug
		$t_status = string_attribute( get_enum_element( 'status', $t_bug->status ) );
		$t_resolution = string_attribute( get_enum_element( 'resolution', $t_bug->resolution ) );
		$t_version_id = version_get_id( $t_bug->fixed_in_version, $t_project );
		if ( ( false !== $t_version_id ) && ( VERSION_RELEASED == version_get_field( $t_version_id, 'released' ) ) ) {
			$t_released_label = '<a title="' . _('Released') . '">' . $t_bug->fixed_in_version . '</a>';
		} else {
			$t_released_label = $t_bug->fixed_in_version;
		}

		# choose color based on status
		$status_label = html_get_status_css_class( $t_bug->status );

		echo '<tr class="' . $status_label .  '">';
		echo '<td><a href="' . string_get_bug_view_url( $t_sponsor_row['bug'] ) . '">' . bug_format_id( $t_sponsor_row['bug'] ) . '</a></td>';
		echo '<td>' . project_get_field( $t_bug->project_id, 'name' ) . '&#160;</td>';
		echo '<td class="right">' . $t_released_label . '&#160;</td>';
		echo '<td><span class="issue-status" title="' . $t_resolution . '">' . $t_status . '</span></td>';
		echo '<td>';
		print_user( $t_bug->handler_id );
		echo '</td>';

		# summary
		echo '<td>' . string_display_line( $t_bug->summary );
		if ( VS_PRIVATE == $t_bug->view_state ) {
			printf( ' <img src="%s" alt="(%s)" title="%s" />', $t_icon_path . 'protected.gif', _('private'), _('private') );
		}
		echo '</td>';

		# describe sponsorship amount
		echo '<td class="right">' . sponsorship_format_amount( $t_sponsor->amount ) . '</td>';
		echo '<td>' . get_enum_element( 'sponsorship', $t_sponsor->paid ) . '</td>';

		if ( SPONSORSHIP_PAID == $t_sponsor->paid ) {
			$t_total_paid += $t_sponsor->amount;
		} else {
			$t_total_owing += $t_sponsor->amount;
		}

		echo '<td>';
		if ( $t_payment ) {
			echo '(paypal button)';
		} else {
			echo '&#160;';
		}
		echo '</td>';
		echo '</tr>';
	}
?>
<!-- Totals -->
<tr>
	<td colspan="5"></td>
	<td><?php echo _('Total Owing') ?></td>
	<td class="right"><?php echo sponsorship_format_amount( $t_total_owing ) ?></td>
	<td colspan="2"></td>
</tr>
<tr>
	<td colspan="5"></td>
	<td><?php echo _('Total Paid') ?></td>
	<td class="right"><?php echo sponsorship_format_amount( $t_total_paid ) ?></td>
	<td colspan="2"></td>
</tr>
</table>
</div>
<?php } # end sponsored issues

$t_query = "SELECT b.id as bug, s.id as sponsor, s.paid, b.project_id, b.fixed_in_version, b.status
	FROM {bug} b, {sponsor} s
	WHERE b.handler_id=" . db_param() . " AND s.bug_id = b.id " .
	( $t_show_all ? '' : 'AND ( b.status < ' . db_param() . ' OR s.paid < ' . SPONSORSHIP_PAID . ')' ) . "
	AND $t_project_clause
	ORDER BY s.paid ASC, b.project_id ASC, b.fixed_in_version ASC, b.status ASC, b.id DESC";

$t_result = db_query_bound( $t_query, $t_show_all ? array( $t_user ) : array( $t_user , $t_resolved ) );

$t_sponsors = array();
while ( $t_row = db_fetch_array( $t_result ) ) {
	$t_sponsors[] = $t_row;
}

$t_sponsor_count = count( $t_sponsors );
if ( $t_sponsor_count === 0 ) {
	echo '<p>' . _('No sponsored issues Assigned To yourself were found.') . '</p>';
} else {
?>

<!-- # Edit sponsorship Form BEGIN -->
<br />
<div>
<form method="post" action="account_sponsor_update.php">
<?php echo form_security_field( 'account_sponsor_update' ) ?>
<table class="width100" cellspacing="1">

	<!-- Headings -->
	<tr>
		<td class="form-title" colspan="8">
			<?php echo _('Sponsored Issues You Have Been Assigned To:') ?>
		</td>
	</tr>
	<tr>
		<td class="form-title" width="10%"><?php echo _('Issue ID') ?></td>
		<td class="form-title" width="8%"><?php echo _('Project') ?></td>
		<td class="form-title" width="7%"><?php echo _('Fixed in Version') ?></td>
		<td class="form-title" width="10%"><?php echo _('Status') ?></td>
		<td class="form-title" width="35%"><?php echo _('Summary') ?></td>
		<td class="form-title" width="10%"><?php echo _('Sponsor') ?></td>
		<td class="form-title" width="10%"><?php echo _('Amount') ?></td>
		<td class="form-title" width="10%"><?php echo _('Status') ?></td>
	</tr>
<?php
	$t_bug_list = array();
	$t_total_owing = 0;
	$t_total_paid = 0;
	for ( $i = 0; $i < $t_sponsor_count; ++$i ) {
		$t_sponsor_row = $t_sponsors[$i];
		$t_bug = bug_get( $t_sponsor_row['bug'] );
		$t_sponsor = sponsorship_get( $t_sponsor_row['sponsor'] );
		$t_buglist[] = $t_sponsor_row['bug'] . ':' . $t_sponsor_row['sponsor'];

		# describe bug
		$t_status = string_attribute( get_enum_element( 'status', $t_bug->status ) );
		$t_resolution = string_attribute( get_enum_element( 'resolution', $t_bug->resolution ) );
		$t_version_id = version_get_id( $t_bug->fixed_in_version, $t_project );
		if ( ( false !== $t_version_id ) && ( VERSION_RELEASED == version_get_field( $t_version_id, 'released' ) ) ) {
			$t_released_label = '<a title="' . _('Released') . '">' . $t_bug->fixed_in_version . '</a>';
		} else {
			$t_released_label = $t_bug->fixed_in_version;
		}

		# choose color based on status
		$status_label = html_get_status_css_class( $t_bug->status );

		echo '<tr class="' . $status_label .  '">';
		echo '<td><a href="' . string_get_bug_view_url( $t_sponsor_row['bug'] ) . '">' . bug_format_id( $t_sponsor_row['bug'] ) . '</a></td>';
		echo '<td>' . project_get_field( $t_bug->project_id, 'name' ) . '&#160;</td>';
		echo '<td class="right">' . $t_released_label . '&#160;</td>';
		echo '<td><a title="' . $t_resolution . '"><span class="underline">' . $t_status . '</span>&#160;</a></td>';

		# summary
		echo '<td>' . string_display_line( $t_bug->summary );
		if ( VS_PRIVATE == $t_bug->view_state ) {
			printf( ' <img src="%s" alt="(%s)" title="%s" />', $t_icon_path . 'protected.gif', _('private'), _('private') );
		}
		echo '</td>';

		# describe sponsorship amount
		echo '<td>';
		print_user( $t_sponsor->user_id );
		echo '</td>';
		echo '<td class="right">' . sponsorship_format_amount( $t_sponsor->amount ) . '</td>';
		echo '<td><select name="sponsor_' . $row['bug'] . '_' . $t_sponsor->id . '">';
		print_enum_string_option_list( 'sponsorship', $t_sponsor->paid );
		echo '</select></td>';

		echo '</tr>';
		if ( SPONSORSHIP_PAID == $t_sponsor->paid ) {
			$t_total_paid += $t_sponsor->amount;
		} else {
			$t_total_owing += $t_sponsor->amount;
		}

	}
	$t_hidden_bug_list = implode( ',', $t_buglist );
?>
<!-- Totals -->
<tr>
	<td colspan="5"></td>
	<td><?php echo _('Total Owing') ?></td>
	<td class="right"><?php echo sponsorship_format_amount( $t_total_owing ) ?></td>
	<td></td>
</tr>
<tr>
	<td colspan="5"></td>
	<td><?php echo _('Total Paid') ?></td>
	<td class="right"><?php echo sponsorship_format_amount( $t_total_paid ) ?></td>
	<td></td>
</tr>
	<input type="hidden" name="buglist" value="<?php echo $t_hidden_bug_list ?>" />
	<!-- BUTTONS -->
	<tr>
		<td colspan="5">&#160;</td>
		<!-- Update Button -->
		<td colspan="2">
			<input type="submit" class="button" value="<?php echo _('Change Payment Status') ?>" />
		</td>
	</tr>
</table>
</form>
</div>
<?php } # end sponsored issues ?>

<br />
<div>
<?php
html_button ( 'account_sponsor_page.php', $t_show_all ? _('Hide Resolved and Paid') : _('Show All'), array( 'show_all' => ( $t_show_all ? 0 : 1 ) ) );
?>
</div>

<?php
html_page_bottom();
