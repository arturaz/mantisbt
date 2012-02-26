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
 */
/**
 * MantisBT Core API's
 */
require_once( dirname( dirname( __FILE__ ) ) . '/core.php' );
require_once( 'schema.php' );

access_ensure_global_level( config_get_global( 'admin_site_threshold' ) );

html_page_top( 'MantisBT Administration' );

function print_info_row( $p_description, $p_value ) {
	echo '<tr>';
	echo '<th class="category">' . $p_description . '</th>';
	echo '<td>' . $p_value . '</td>';
	echo '</tr>';
}
?>
<br />

<div>
		<p>[ <a href="check/index.php">Check your installation</a> ]</p>
	<?php if ( count($upgrade) - 1 != config_get( 'database_version' ) ) { ?>
		<p>[ <a href="upgrade_warning.php"><strong>Upgrade your installation</strong></a> ]</p>
	<?php } ?>
		<p>[ <a href="system_utils.php">System Utilities</a> ]</p>
		<p>[ <a href="test_langs.php">Test Langs</a> ]</p>
		<p>[ <a href="email_queue.php">Email Queue</a> ]</p>
</div>

<table class="width75" cellspacing="1">
<tr>
<td class="form-title" width="30%" colspan="2"><?php echo _('MantisBT Installation Information') ?></td>
</tr>
<?php
	if( ON == config_get( 'show_version' ) ) {
		$t_version_suffix = config_get_global( 'version_suffix' );
	} else {
		$t_version_suffix = '';
	}
	print_info_row( _('MantisBT Version'), MANTIS_VERSION, $t_version_suffix );
	print_info_row( 'php_version', phpversion());
?>
<tr>
<td class="form-title" width="30%" colspan="2"><?php echo _('MantisBT Database Information') ?></td>
</tr>
<?php
	print_info_row( _('Schema Version'), config_get( 'database_version' ) );
?>
<tr>
<td class="form-title" width="30%" colspan="2"><?php echo _('MantisBT Path Information') ?></td>
</tr>
<?php
	print_info_row( _('Site Path'), config_get( 'absolute_path' ) );
	print_info_row( _('Core Path'), APPLICATION_PATH );
	print_info_row( _('Plugin Path'), config_get( 'plugin_path' ) );
?>
</table>
<?php
	html_page_bottom();
