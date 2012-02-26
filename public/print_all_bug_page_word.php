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
 * Word 2000 export page
 * The bugs displayed in print_all_bug_page.php are saved in a .doc file
 * The IE icon allows to see or directly print the same result
 *
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses bug_api.php
 * @uses bugnote_api.php
 * @uses category_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses custom_field_api.php
 * @uses date_api.php
 * @uses file_api.php
 * @uses filter_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses html_api.php
 * @uses http_api.php
 * @uses lang_api.php
 * @uses prepare_api.php
 * @uses print_api.php
 * @uses profile_api.php
 * @uses project_api.php
 * @uses string_api.php
 */

/**
 * MantisBT Core API's
 */
require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'authentication_api.php' );
require_api( 'bug_api.php' );
require_api( 'bugnote_api.php' );
require_api( 'category_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'custom_field_api.php' );
require_api( 'date_api.php' );
require_api( 'file_api.php' );
require_api( 'filter_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'html_api.php' );
require_api( 'http_api.php' );
require_api( 'lang_api.php' );
require_api( 'prepare_api.php' );
require_api( 'print_api.php' );
require_api( 'profile_api.php' );
require_api( 'project_api.php' );
require_api( 'string_api.php' );

auth_ensure_user_authenticated();

$f_type_page	= gpc_get_string( 'type_page', 'word' );
$f_search		= gpc_get_string( 'search', false ); /** @todo need a better default */
$f_offset		= gpc_get_int( 'offset', 0 );
$f_export		= gpc_get_string( 'export' );
$f_show_flag	= gpc_get_bool( 'show_flag' );

helper_begin_long_process();

# word or html export
if ( $f_type_page != 'html' ) {
	$t_export_title = helper_get_default_export_filename( '' );
	$t_export_title = preg_replace( '/[\/:*?"<>|]/', '', $t_export_title );
	$t_export_title .= '.doc';

	# Make sure that IE can download the attachments under https.
	header( 'Pragma: public' );

	header( 'Content-Type: application/msword' );

	http_content_disposition_header( $t_export_title );
}

# This is where we used to do the entire actual filter ourselves
$t_page_number = gpc_get_int( 'page_number', 1 );
$t_per_page = -1;
$t_bug_count = null;
$t_page_count = null;

$result = filter_get_bug_rows( $t_page_number, $t_per_page, $t_page_count, $t_bug_count );
$t_row_count = count( $result );
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">

<?php
html_page_top1();
html_head_end();
html_body_begin();

$f_bug_arr = explode( ',', $f_export );
$t_count_exported = 0;
$t_date_format = config_get( 'normal_date_format' );
$t_short_date_format = config_get( 'short_date_format' );

$t_lang_bug_view_title = _('View Issue Details');
$t_lang_id = _('ID');
$t_lang_category = _('Category');
$t_lang_severity = _('Severity');
$t_lang_reproducibility = _('Reproducibility');
$t_lang_date_submitted = _('Date Submitted');
$t_lang_last_update = _('Last Update');
$t_lang_reporter = _('Reporter');
$t_lang_assigned_to = _('Assigned To');
$t_lang_platform = _('Platform');
$t_lang_due_date = _('Due Date');
$t_lang_os = _('OS');
$t_lang_os_version = _('OS Version');
$t_lang_fixed_in_version = _('Fixed in Version');
$t_lang_resolution = _('Resolution');
$t_lang_priority = _('Priority');
$t_lang_product_build = _('Product Build');
$t_lang_eta = _('ETA');
$t_lang_status = _('Status');
$t_lang_product_version = _('Product Version');
$t_lang_no_bugnotes_msg = _('There are no notes attached to this issue.');
$t_lang_projection = _('Projection');
$t_lang_target_version = _('Target Version');
$t_lang_summary = _('Summary');
$t_lang_description = _('Description');
$t_lang_steps_to_reproduce = _('Steps To Reproduce');
$t_lang_additional_information = _('Additional Information');
$t_lang_bug_notes_title = _('Notes');
$t_lang_system_profile = _('System Description');
$t_lang_attached_files = _('Attached Files');

$t_current_user_id = auth_get_current_user_id();
$t_user_bugnote_order = user_pref_get_pref ( $t_current_user_id, 'bugnote_order' );

for( $j=0; $j < $t_row_count; $j++ ) {
	$t_bug = $result[$j];
	$t_id = $t_bug->id;

	if ( $j % 50 == 0 ) {
		# to save ram as report will list data once, clear cache after 50 bugs
		bug_text_clear_cache();
		bug_clear_cache();
		bugnote_clear_cache();
	}

	# display the available and selected bugs
	if ( in_array( $t_id, $f_bug_arr ) || !$f_show_flag ) {
		if ( $t_count_exported > 0 ) {
			echo '<br style="mso-special-character: line-break; page-break-before: always">';
		}

		$t_count_exported++;

		$t_last_updated = date( $g_short_date_format, $t_bug->last_updated );

		# grab the project name
		$t_project_name = project_get_field( $t_bug->project_id, 'name' );
		$t_category_name = category_full_name( $t_bug->category_id, false );
?>
<br />
<table class="width100" cellspacing="1">
<tr>
	<td class="form-title" colspan="3">
		<?php echo $t_lang_bug_view_title ?>
	</td>
</tr>
<tr>
	<td class="print-spacer" colspan="6">
		<hr />
	</td>
</tr>
<tr class="print-category">
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_id ) ?>
	</td>
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_category ) ?>
	</td>
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_severity ) ?>
	</td>
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_reproducibility ) ?>
	</td>
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_date_submitted ) ?>
	</td>
	<td class="print" width="16%">
		<?php echo sprintf( _('%1:'), $t_lang_last_update ) ?>
	</td>
</tr>
<tr class="print">
	<td class="print">
		<?php echo $t_id ?>
	</td>
	<td class="print">
		<?php echo '[' . string_display_line( $t_project_name ) . '] ' . string_display_line( $t_category_name ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'severity', $t_bug->severity ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'reproducibility', $t_bug->reproducibility ) ?>
	</td>
	<td class="print">
		<?php echo date( $t_date_format, $t_bug->date_submitted ) ?>
	</td>
	<td class="print">
		<?php echo date( $t_date_format, $t_bug->last_updated ) ?>
	</td>
</tr>
<tr>
	<td class="print-spacer" colspan="6">
		<hr />
	</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_reporter ) ?>
	</td>
	<td class="print">
		<?php print_user_with_subject( $t_bug->reporter_id, $t_id ) ?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_platform ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->platform ) ?>
	</td>
<?php if ( access_has_bug_level( config_get( 'due_date_view_threshold' ), $t_id ) ) { ?>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_due_date ) ?>
	</td>
<?php
		if ( bug_is_overdue( $t_id ) ) { ?>
		<td class="print-overdue">
<?php
		} else	{ ?>
		<td class="print">
<?php
		}
		if ( !date_is_null( $t_bug->due_date ) ) {
				echo date( $t_short_date_format, $t_bug->due_date );
		print "\t\t</td>\n";
		}
	} else {
?>
	<td class="print" colspan="2">&#160;</td>
<?php } ?>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_assigned_to ) ?>
	</td>
	<td class="print">
		<?php
			if ( access_has_bug_level( config_get( 'view_handler_threshold' ), $t_id ) ) {
				print_user_with_subject( $t_bug->handler_id, $t_id );
			}
		?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_os ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->os ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_priority ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'priority', $t_bug->priority ) ?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_os_version ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->os_build ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_status ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'status', $t_bug->status ) ?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_product_version ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->version ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_product_build ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->build ) ?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_resolution ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'resolution', $t_bug->resolution ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_projection ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'projection', $t_bug->projection ) ?>
	</td>
	<td class="print-category">
		&#160;
	</td>
	<td class="print">
		&#160;
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_eta ) ?>
	</td>
	<td class="print">
		<?php echo get_enum_element( 'eta', $t_bug->eta ) ?>
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_fixed_in_version ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->fixed_in_version ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>

</tr>
<tr class="print">
	<td class="print-category">
		&#160;
	</td>
	<td class="print">
		&#160;
	</td>
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_target_version ) ?>
	</td>
	<td class="print">
		<?php echo string_display_line( $t_bug->target_version ) ?>
	</td>
	<td class="print" colspan="2">&#160;</td>
</tr>
<?php
$t_related_custom_field_ids = custom_field_get_linked_ids( $t_bug->project_id );
foreach( $t_related_custom_field_ids as $t_custom_field_id ) {
	$t_def = custom_field_get_definition( $t_custom_field_id );
?>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), lang_get_defaulted( $t_def['name'] ) ) ?>
	</td>
	<td class="print" colspan="5">
		<?php print_custom_field_value( $t_def, $t_custom_field_id, $t_id ); ?>
	</td>
</tr>
<?php
}       // foreach
?>
<tr>
	<td class="print-spacer" colspan="6">
		<hr />
	</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_summary ) ?>
	</td>
	<td class="print" colspan="5">
		<?php echo string_display_line_links( $t_bug->summary ) ?>
	</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_description ) ?>
	</td>
	<td class="print" colspan="5">
		<?php echo string_display_links( $t_bug->description ) ?>
	</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_steps_to_reproduce ) ?>
	</td>
	<td class="print" colspan="5">
		<?php echo string_display_links( $t_bug->steps_to_reproduce ) ?>
	</td>
</tr>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_additional_information ) ?>
	</td>
	<td class="print" colspan="5">
		<?php echo string_display_links( $t_bug->additional_information ) ?>
	</td>
</tr>
<?php
	# account profile description
	if ( $t_bug->profile_id > 0 ) {
		$t_profile_row = profile_get_row_direct( $t_bug->profile_id );
		$t_profile_description = string_display( $t_profile_row['description'] );

?>
<tr class="print">
	<td class="print-category">
		<?php echo $t_lang_system_profile ?>
	</td>
	<td class="print" colspan="5">
		<?php echo $t_profile_description ?>
	</td>
</tr>
<?php
	} # profile description
?>
<tr class="print">
	<td class="print-category">
		<?php echo sprintf( _('%1:'), $t_lang_attached_files ) ?>
	</td>
	<td class="print" colspan="5">
		<?php
			$t_attachments = file_get_visible_attachments( $t_id );
			$t_first_attachment = true;
			$t_path = config_get_global( 'path' );

			foreach ( $t_attachments as $t_attachment  ) {
				if ( $t_first_attachment ) {
					$t_first_attachment = false;
				} else {
					echo '<br />';
				}

				$c_filename = string_display_line( $t_attachment['display_name'] );
				$c_download_url = $t_path . htmlspecialchars( $t_attachment['download_url'] );
				$c_filesize = number_format( $t_attachment['size'] );
				$c_date_added = date( $t_date_format, $t_attachment['date_added'] );
				echo "$c_filename ($c_filesize) <span class=\"italic\">$c_date_added</span><br />$c_download_url";

				if ( $t_attachment['preview'] && $t_attachment['type'] == 'image' && $f_type_page == 'html' ) {
					echo '<br /><img src="', $t_attachment['download_url'], '" alt="', $t_attachment['alt'], '" /><br />';
				}
			}
		?>
	</td>
</tr>
<?php
	$t_user_bugnote_limit = 0;

	$t_bugnotes = bugnote_get_all_visible_bugnotes( $t_id, $t_user_bugnote_order, $t_user_bugnote_limit );
?>
<br />
<table class="width100" cellspacing="1">
<?php
	# no bugnotes
	if ( 0 == count( $t_bugnotes ) ) {
	?>
<tr>
	<td class="print" colspan="2">
		<?php echo $t_lang_no_bugnotes_msg ?>
	</td>
</tr>
<?php
	} else { # print bugnotes ?>
<tr>
	<td class="form-title" colspan="2">
			<?php echo $t_lang_bug_notes_title ?>
	</td>
</tr>
	<?php
		foreach ( $t_bugnotes as $t_bugnote ) {
			# prefix all bugnote data with v3_
			$t_date_submitted = date( $t_date_format, $t_bugnote->date_submitted );
			$t_last_modified = date( $t_date_format, $t_bugnote->last_modified );

			# grab the bugnote text and id and prefix with v3_
			$t_note = string_display_links( $t_bugnote->note );
	?>
<tr>
	<td class="print-spacer" colspan="2">
		<hr />
	</td>
</tr>
<tr>
	<td class="nopad" width="20%">
		<table class="hide" cellspacing="1">
		<tr>
			<td class="print">
				(<?php echo bugnote_format_id( $t_bugnote->id ) ?>)
			</td>
		</tr>
		<tr>
			<td class="print">
				<?php print_user( $t_bugnote->reporter_id ) ?>&#160;&#160;&#160;
			</td>
		</tr>
		<tr>
			<td class="print">
				<?php echo $t_date_submitted ?>&#160;&#160;&#160;
				<?php if ( $t_bugnote->date_submitted != $t_bugnote->last_modified ) {
					echo '<br />(' . _('Last edited:') . _('&#32;') . $t_last_modified . ')';
				} ?>
			</td>
		</tr>
		</table>
	</td>
	<td class="nopad" width="85%">
		<table class="hide" cellspacing="1">
		<tr>
			<td class="print">
				<?php
					switch ( $t_bugnote->note_type ) {
						case REMINDER:
							echo _('Reminder sent to:') . ' ';
							$t_note_attr = mb_substr( $t_bugnote->note_attr, 1, mb_strlen( $t_bugnote->note_attr ) - 2 );
							$t_to = array();
							foreach ( explode( '|', $t_note_attr ) as $t_recipient ) {
								$t_to[] = prepare_user_name( $t_recipient );
							}
							echo implode( ', ', $t_to ) . '<br />';
						default:
							echo string_display_links( $t_bugnote->note );
					}
				?>
			</td>
		</tr>
		</table>
	</td>
</tr>
<?php
		} # end for
	} # end else
?>

</table>
<?php # Bugnotes END ?>
</table>


<?php
echo '<br /><br />';
	} # end in_array
}  # end main loop
