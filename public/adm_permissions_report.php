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
 * @author Marcello Scata' <marcelloscata at users.sourceforge.net> ITALY
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses html_api.php
 * @uses lang_api.php
 * @uses string_api.php
 */

/**
 * MantisBT Core API's
 */
require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'html_api.php' );
require_api( 'lang_api.php' );
require_api( 'string_api.php' );

access_ensure_project_level( config_get( 'manage_configuration_threshold' ) );

html_page_top( _('Permissions Report') );

print_manage_menu( 'adm_permissions_report.php' );
print_manage_config_menu( 'adm_permissions_report.php' );

function get_section_begin_apr( $p_section_name ) {
	$t_access_levels = MantisEnum::getValues( config_get( 'access_levels_enum_string' ) );

	$t_output = '<table class="width100">';
	$t_output .= '<tr><td class="form-title-caps" colspan="' . ( count( $t_access_levels ) + 1 ) . '">' . $p_section_name . '</td></tr>' . "\n";
	$t_output .= '<tr><td class="form-title">' . _('Capability') . '</td>';

	foreach( $t_access_levels as $t_access_level ) {
		$t_output .= '<td class="form-title" style="text-align:center">&#160;' . MantisEnum::getLabel( lang_get('access_levels_enum_string'), $t_access_level ) . '&#160;</td>';
	}

	$t_output .= '</tr>' . "\n";

	return $t_output;
}

function get_capability_row( $p_caption, $p_access_level ) {
	$t_access_levels = MantisEnum::getValues( config_get( 'access_levels_enum_string' ) );

	$t_output = '<tr><td>' . string_display( $p_caption ) . '</td>';
	foreach( $t_access_levels as $t_access_level ) {
		if ( $t_access_level >= (int)$p_access_level ) {
			$t_value = '<img src="images/ok.gif" width="20" height="15" alt="X" title="X" />';
		} else {
			$t_value = '&#160;';
		}

		$t_output .= '<td class="center">' . $t_value . '</td>';
	}

	$t_output .= '</tr>' . "\n";

	return $t_output;
}

function get_section_end() {
	$t_output = '</table><br />' . "\n";
	return $t_output;
}

echo '<br /><br />';

# News
echo get_section_begin_apr( _('News') );
echo get_capability_row( _('View private news'), config_get( 'private_news_threshold' ) );
echo get_capability_row( _('Manage news'), config_get( 'manage_news_threshold' ) );
echo get_section_end();

# Attachments
if( config_get( 'allow_file_upload' ) == ON ) {
	echo get_section_begin_apr( _('attachment(s)') );
	echo get_capability_row( _('View list of attachments'), config_get( 'view_attachments_threshold' ) );
	echo get_capability_row( _('Download attachments'), config_get( 'download_attachments_threshold' ) );
	echo get_capability_row( _('Delete attachments'), config_get( 'delete_attachments_threshold' ) );
	echo get_capability_row( _('Upload issue attachments'), config_get( 'upload_bug_file_threshold' ) );
	echo get_section_end();
}

# Filters
echo get_section_begin_apr( _('filters') );
echo get_capability_row( _('Save filters'), config_get( 'stored_query_create_threshold' ) );
echo get_capability_row( _('Save filters as shared'), config_get( 'stored_query_create_shared_threshold' ) );
echo get_capability_row( _('Use saved filters'), config_get( 'stored_query_use_threshold' ) );
echo get_section_end();

# Projects
echo get_section_begin_apr( _('Projects') );
echo get_capability_row( _('Create project'), config_get( 'create_project_threshold' ) );
echo get_capability_row( _('Delete project'), config_get( 'delete_project_threshold' ) );
echo get_capability_row( _('Manage Projects'), config_get( 'manage_project_threshold' ) );
echo get_capability_row( _('Manage user access to a project'), config_get( 'project_user_threshold' ) );
echo get_capability_row( _('Automatically included in private projects'), config_get( 'private_project_threshold' ) );
echo get_section_end();

# Project Documents
if( config_get( 'enable_project_documentation' ) == ON ) {
	echo get_section_begin_apr( _('Project Documents') );
	echo get_capability_row( _('View project documents'), config_get( 'view_proj_doc_threshold' ) );
	echo get_capability_row( _('Upload project documents'), config_get( 'upload_project_file_threshold' ) );
	echo get_section_end();
}

# Custom Fields
echo get_section_begin_apr( _('Custom Fields') );
echo get_capability_row( _('Manage Custom Fields'), config_get( 'manage_custom_fields_threshold' ) );
echo get_capability_row( _('Link custom fields to projects'), config_get( 'custom_field_link_threshold' ) );
echo get_section_end();

# Sponsorships
if( config_get( 'enable_sponsorship' ) == ON ) {
	echo get_section_begin_apr( _('Sponsorships') );
	echo get_capability_row( _('View sponsorship details'), config_get( 'view_sponsorship_details_threshold' ) );
	echo get_capability_row( _('View sponsorship total'), config_get( 'view_sponsorship_total_threshold' ) );
	echo get_capability_row( _('Sponsor issue'), config_get( 'sponsor_threshold' ) );
	echo get_capability_row( _('Assign sponsored issue'), config_get( 'assign_sponsored_bugs_threshold' ) );
	echo get_capability_row( _('Handle sponsored issue'), config_get( 'handle_sponsored_bugs_threshold' ) );
	echo get_section_end();
}

# Others
echo get_section_begin_apr( _('Others') );
echo get_capability_row( _('View') . ' ' . _('Summary'), config_get( 'view_summary_threshold' ) );
echo get_capability_row( _('See e-mail addresses of other users'), config_get( 'show_user_email_threshold' ) );
echo get_capability_row( _('Send reminders'), config_get( 'bug_reminder_threshold' ) );
echo get_capability_row( _('Add profiles'), config_get( 'add_profile_threshold' ) );
echo get_capability_row( _('Manage Users'), config_get( 'manage_user_threshold' ) );
echo get_capability_row( _('Notify of new user created'), config_get( 'notify_new_user_created_threshold_min' ) );
echo get_section_end();

html_page_bottom();
