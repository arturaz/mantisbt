<?php
# MantisBT - A PHP based bugtracking system

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
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package MantisBT
 * @copyright Copyright (C) 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright (C) 2002 - 2012  MantisBT Team   - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 */
/**
 * Mantis Core API's
 */
require_once( dirname( dirname( __FILE__ ) ) . '/core.php' );

access_ensure_global_level( config_get_global( 'admin_site_threshold' ) );

html_page_top();

$f_to = gpc_get( 'send', null );
$f_mail_test = gpc_get_bool( 'mail_test' );

if ( $f_to !== null ) {
	if ( $f_to == 'all' ) {
		echo "Sending emails...<br />";
		email_send_all();
		echo "Done";
	} else if ( $f_to == 'sendordelall' ) {
		echo "Sending or deleting emails...<br />";
		email_send_all(true);
		echo "Done";

	} else {
		$t_email_data = email_queue_get( (int) $f_to );

		// check if email was found.  This can fail if another request picks up the email first and sends it.
		echo 'Sending email...<br />';
		if( $t_email_data !== false ) {
			if( !email_send( $t_email_data ) ) {
				echo 'Email Not Sent - Deleting from queue<br />';
				email_queue_delete( $t_email_data->email_id );
			} else {
				echo 'Email Sent<br />';
			}
		} else {
			echo 'Email not found in queue<br />';
		}
	}
}

if( $f_mail_test ) {
	echo '<strong>Testing Mail</strong> - ';

	# @@@ thraxisp - workaround to ensure a language is set without authenticating
	#  will disappear when this is properly localized
	lang_push( 'english' );

	$t_email_data = new EmailData;
	$t_email_data->email = config_get_global( 'webmaster_email' );
	$t_email_data->subject = 'Testing PHP mail() function';
	$t_email_data->body = 'Your PHP mail settings appear to be correctly set.';
	$t_email_data->metadata['priority'] = config_get( 'mail_priority' );
	$t_email_data->metadata['charset'] = 'utf-8';
	$result = email_send( $t_email_data );

	if( !$result ) {
		echo ' PROBLEMS SENDING MAIL TO: ' . config_get_global( 'webmaster_email' ) . '. Please check your php/mail server settings.<br />';
	} else {
		echo ' mail() send successful.<br />';
	}
}

$t_ids = email_queue_get_ids();

if( count( $t_ids ) > 0 ) {

	echo '<table><tr><th>' . _('ID') . '</th><th>' . _('E-mail') . '</th><th>' . _('Timestamp') . '</th><th>Send Or Delete</th></tr>';
	foreach( $t_ids as $t_id ) {
		$row = email_queue_get( $t_id );

		echo '<tr><td>' . $row->email_id . '</td><td>' . $row->email . '</td><td>' . $row->submitted . '</td><td>' , html_button( 'email_queue.php', 'Send Or Delete', array( 'send' => $row->email_id ) ) , '</td></tr>';
	}
	echo '</table>';

	html_button( 'email_queue.php', 'Send All', array( 'send' => 'all') );
	html_button( 'email_queue.php', 'Send Or Delete All', array( 'send' => 'sendordelall') );

} else {
	echo 'Email Queue Empty';
}

?>
<br /><hr /><br />
<table width="100%" bgcolor="#222222" cellpadding="20" cellspacing="1">
<tr>
	<td bgcolor="#f4f4f4">
		<span class="title">Testing Email</span>
		<p>You can test the ability for MantisBT to send email notifications with this form.  Just click "Send Mail".  If the page takes a very long time to reappear or results in an error then you will need to investigate your php/mail server settings (see PHPMailer related settings in your config_inc.php, if they don't exist, copy from config_defaults_inc.php).  Note that errors can also appear in the server error log.  More help can be found at the <a href="http://www.php.net/manual/en/ref.mail.php">PHP website</a> if you are using the mail() PHPMailer sending mode.</p>
		<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']?>">
		Email Address: <?php echo config_get_global( 'webmaster_email' );?><br />
		<input type="submit" value="Send Mail" name="mail_test" />
		</form>
	</td>
</tr>
</table>

<?php

html_page_bottom();
