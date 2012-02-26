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
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses database_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses print_api.php
 * @uses summary_api.php
 * @uses user_api.php
 */

/**
 * MantisBT Core API's
 */
require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'authentication_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'database_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );
require_api( 'summary_api.php' );
require_api( 'user_api.php' );

$f_project_id = gpc_get_int( 'project_id', helper_get_current_project() );

# Override the current page to make sure we get the appropriate project-specific configuration
$g_project_override = $f_project_id;

access_ensure_project_level( config_get( 'view_summary_threshold' ) );

$t_user_id = auth_get_current_user_id();

$t_project_ids = user_get_all_accessible_projects( $t_user_id, $f_project_id);
$specific_where = helper_project_specific_where( $f_project_id, $t_user_id);

$t_resolved = config_get( 'bug_resolved_status_threshold' );
# the issue may have passed through the status we consider resolved
#  (e.g., bug is CLOSED, not RESOLVED). The linkage to the history field
#  will look up the most recent 'resolved' status change and return it as well
$query = "SELECT b.id, b.date_submitted, b.last_updated, MAX(h.date_modified) AS hist_update, b.status
	FROM {bug} b LEFT JOIN {bug_history} h
		ON b.id = h.bug_id  AND h.type=0 AND h.field_name='status' AND h.new_value=" . db_param() . "
		WHERE b.status >=" . db_param() . " AND $specific_where
		GROUP BY b.id, b.status, b.date_submitted, b.last_updated
		ORDER BY b.id ASC";
$result = db_query_bound( $query, array( $t_resolved, $t_resolved ) );
$bug_count = 0;

$t_bug_id       = 0;
$t_largest_diff = 0;
$t_total_time   = 0;
while( $row = db_fetch_array( $result ) ) {
	$bug_count++;
	$t_date_submitted = $row['date_submitted'];
	$t_id = $row['id'];
	$t_status = $row['status'];
	if ( $row['hist_update'] !== NULL ) {
		$t_last_updated   = $row['hist_update'];
	} else {
		$t_last_updated   = $row['last_updated'];
	}

	if ($t_last_updated < $t_date_submitted) {
		$t_last_updated   = 0;
		$t_date_submitted = 0;
	}

	$t_diff = $t_last_updated - $t_date_submitted;
	$t_total_time = $t_total_time + $t_diff;
	if ( $t_diff > $t_largest_diff ) {
		$t_largest_diff = $t_diff;
		$t_bug_id = $row['id'];
	}
}
if ( $bug_count < 1 ) {
	$bug_count = 1;
}
$t_average_time 	= $t_total_time / $bug_count;

$t_largest_diff 	= number_format( $t_largest_diff / SECONDS_PER_DAY, 2 );
$t_total_time		= number_format( $t_total_time / SECONDS_PER_DAY, 2 );
$t_average_time 	= number_format( $t_average_time / SECONDS_PER_DAY, 2 );

$t_orct_arr = preg_split( '/[\)\/\(]/', _('(open/resolved/closed/total)'), -1, PREG_SPLIT_NO_EMPTY );

$t_orcttab = "";
foreach ( $t_orct_arr as $t_orct_s ) {
	$t_orcttab .= '<td class="right">';
	$t_orcttab .= $t_orct_s;
	$t_orcttab .= '</td>';
}

html_page_top( _('Summary') );
?>

<br />
<?php
print_summary_menu( 'summary_page.php' );
print_summary_submenu(); ?>
<br />
<table class="width100" cellspacing="1">
<tr>
	<td class="form-title" colspan="2">
		<?php echo _('Summary') ?>
	</td>
</tr>
<tr>
	<td width="50%">
		<?php # PROJECT #
			if ( 1 < count( $t_project_ids ) ) { ?>
		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Project') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_project(); ?>
		</table>

		<br />
		<?php } ?>

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Status') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_enum( 'status' ) ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Severity') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_enum( 'severity' ) ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Category') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_category() ?>
		</table>

		<br />

		<table class="width100">
		<tr>
			<td class="form-title" colspan="5">
				<?php echo _('Time Stats For Resolved Issues (days)') ?>
			</td>
		</tr>
		<tr class="row-1">
			<td width="50%">
				<?php echo _('Longest open issue') ?>
			</td>
			<td width="50%">
				<?php
					if ($t_bug_id>0) {
						print_bug_link( $t_bug_id );
					}
				?>
			</td>
		</tr>
		<tr class="row-2">
			<td>
				<?php echo _('Longest open') ?>
			</td>
			<td>
				<?php echo $t_largest_diff ?>
			</td>
		</tr>
		<tr class="row-1">
			<td>
				<?php echo _('Average time') ?>
			</td>
			<td>
				<?php echo $t_average_time ?>
			</td>
		</tr>
		<tr class="row-2">
			<td>
				<?php echo _('Total time') ?>
			</td>
			<td>
				<?php echo $t_total_time ?>
			</td>
		</tr>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('Developer Stats') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_developer() ?>
		</table>
	</td>



	<td width="50%">
		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title"><?php echo _('By Date (days)'); ?></td>
			<td class="right"><?php echo _('Opened'); ?></td>
			<td class="right"><?php echo _('Resolved'); ?></td>
			<td class="right"><?php echo _('Balance'); ?></td>
		</tr>
		<?php summary_print_by_date( config_get( 'date_partitions' ) ) ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" width="86%"><?php echo _('Most Active'); ?></td>
			<td class="right" width="14%"><?php echo _('Score'); ?></td>
		</tr>
		<?php summary_print_by_activity() ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" width="86%"><?php echo _('Longest open'); ?></td>
			<td class="right" width="14%"><?php echo _('Days'); ?></td>
		</tr>
		<?php summary_print_by_age() ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Resolution') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_enum( 'resolution' ) ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('By Priority') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_enum( 'priority' ) ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('Reporter Stats') ?>
			</td>
			<?php echo $t_orcttab ?>
		</tr>
		<?php summary_print_by_reporter() ?>
		</table>

		<br />

		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('Reporter Effectiveness') ?>
			</td>
			<td>
				<?php echo _('Severity') ?>
			</td>
			<td>
				<?php echo _('False') ?>
			</td>
			<td>
				<?php echo _('Total') ?>
			</td>
		</tr>
		<?php summary_print_reporter_effectiveness( config_get( 'severity_enum_string' ), config_get( 'resolution_enum_string' ) ) ?>
		</table>
	</td>
</tr>

<tr>
	<td colspan="2">
		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('Reporter By Resolution') ?>
			</td>
			<?php
			$t_resolutions = MantisEnum::getValues( config_get( 'resolution_enum_string' ) );

			foreach ( $t_resolutions as $t_resolution ) {
				echo '<td>', get_enum_element( 'resolution', $t_resolution ), '</td>';
			}

			echo '<td>', _('% False'), '</td>';
			?>
		</tr>
		<?php summary_print_reporter_resolution( config_get( 'resolution_enum_string' ) ) ?>
		</table>
	</td>
</tr>

<tr>
	<td colspan="2">
		<table class="width100" cellspacing="1">
		<tr>
			<td class="form-title" colspan="1">
				<?php echo _('Developer By Resolution') ?>
			</td>
			<?php
			$t_resolutions = MantisEnum::getValues( config_get( 'resolution_enum_string' ) );

			foreach ( $t_resolutions as $t_resolution ) {
				echo '<td>', get_enum_element( 'resolution', $t_resolution ), '</td>';
			}

			echo '<td>', _('% Fixed'), '</td>';
			?>
		</tr>
		<?php summary_print_developer_resolution( config_get( 'resolution_enum_string' ) ) ?>
		</table>
	</td>
</tr>
</table>

<?php
html_page_bottom();
