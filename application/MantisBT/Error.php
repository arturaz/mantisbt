<?php
namespace MantisBT;
use \stdClass;
use \ErrorException;

class Error {
	/**
	 * Indicates previous errors
	 */
	private static $allErrors = array();

	/**
	 * Indicates if an error/exception has been handled
	 */
	private static $handled = false;

	private static $errorConstants = array(
										'1'=>'E_ERROR',
										'2'=>'E_WARNING',
										'4'=>'E_PARSE',
										'8'=>'E_NOTICE',
										'16'=>'E_CORE_ERROR',
										'32'=>'E_CORE_WARNING',
										'64'=>'E_COMPILE_ERROR',
										'128'=>'E_COMPILE_WARNING',
										'256'=>'APPLICATION ERROR', 	// E_USER_ERROR
										'512'=>'APPLICATION WARNING', 	// E_USER_WARNING
										'1024'=>'E_USER_NOTICE',
										'2048'=>'E_STRICT',
										'4096'=>'E_RECOVERABLE_ERROR',
										'8192'=>'E_DEPRECATED',
										'16384'=>'E_USER_DEPRECATED',
									);

	private static $parameters = array();

	public static function init(){
		if( self::$handled === false ) {
			// first run
			register_shutdown_function(array('MantisBT\Error', 'display_errors'));

			self::$handled = true;
		}
	}

	public static function exception_handler($exception) {
		$errorInfo = new stdClass();
		$errorInfo->time = time();
		$errorInfo->type = 'EXCEPTION';
		$errorInfo->name = 'InvalidException';
		$errorInfo->code = 0;
		$errorInfo->message = _('An invalid exception type was caught by the exception handler. Unfortuantly no further information can be obtained.');

		if (is_object($exception)) {
			$reflectionClass = new \ReflectionClass($exception);
			if ($reflectionClass->isSubclassOf('Exception')) {
				$errorInfo->name = $reflectionClass->getName();
				$errorInfo->code = $exception->getCode();
				$errorInfo->message = $exception->getMessage();
				$errorInfo->file = $exception->getFile();
				$errorInfo->line = $exception->getLine();
				$errorInfo->trace = $exception->getTrace();
			}
		}

		self::init();
		self::$allErrors[] = $errorInfo;
	}

	public static function exception_error_handler( $errno, $errstr, $errfile, $errline ) {
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}

	public static function display_errors( $noHeader = false ) {
		# disable any further event callbacks
		if ( function_exists( 'event_clear_callbacks' ) ) {
			event_clear_callbacks();
		}

		$oblen = ob_get_length();
		if( self::$handled === true && $oblen > 0 ) {
			$oldContents = ob_get_contents();
		}

		# We need to ensure compression is off - otherwise the compression headers are output.
		compress_disable();

		# then clean the buffer, leaving output buffering on.
		if( $oblen > 0 ) {
			ob_clean();
		}

		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" >';
		echo '<head><title>Error Page</title>';
		echo '<style>table.width70		{ width: 70%;  border: solid 1px #000000; }</style></head><body>';
		echo '<p align="center"><img src="' . helper_mantis_url('images/mantis_logo.gif') . '" /></p>';
		echo '<hr />';

		echo '<div align="center">';
		echo _('Please use the "Back" button in your web browser to return to the previous page. There you can correct whatever problems were identified in this error or select another action. You can also click an option from the menu bar to go directly to a new section.');
		echo '<br />';

		foreach ( self::$allErrors as $key => $errorInfo ) {
			self::display_error( $errorInfo );

			if ( $key == 0 && sizeof( self::$allErrors ) > 1 ) {
				echo '<p>Previous non-fatal errors occurred:</p>';
			}
		}
		echo '</div>';

		if ( !config_get( 'show_friendly_errors' ) ) {
			if( isset( $oldContents ) ) {
				echo '<p>Page contents follow.</p>';
				echo '<div style="border: solid 1px black;padding: 4px"><pre>';
				echo htmlspecialchars($oldContents);
				echo '</pre></div>';
			}
		}
		echo '<hr /><br /><br /><br />';
		echo '</body></html>', "\n";
		exit();
	}

	public static function display_error( $error) {
		echo '<br /><div><table class="width70" cellspacing="1">';
		echo '<tr><td class="form-title">' . $error->name . '</td></tr>';
		echo '<tr><td><p class="center" style="color:red">' . nl2br( $error->message ) . '</p></td></tr>';
		echo '<tr><td>';
		self::error_print_details( basename( $error->file ), $error->line );
		echo '</td></tr>';
		if ( !config_get( 'show_friendly_errors' ) ) {
			echo '<tr><td>';
			self::error_print_stack_trace( $error->trace );
			echo '</td></tr>';
		}
		echo '</table></div>';
	}

	/**
	 * Print out the error details
	 * @param string $file
	 * @param int $line
	 * @return null
	 */
	public static function error_print_details( $file, $line ) {
		if ( !config_get( 'show_friendly_errors' ) ) {
		?>
			<table class="width75">
				<tr>
					<td>Filename: <?php echo htmlentities( $file, ENT_COMPAT, 'UTF-8' );?></td>
				</tr>
				<tr>
					<td>Line: <?php echo $line?></td>
				</tr>
			</table>
		<?php
		} else {
			if( strpos( $file, '.' ) !== false ) {
				$components = explode( '.', $file );
				$file = current( $components );
			}
		?>
			<table class="width75">
				<tr>
					<td>ID: <?php echo htmlentities( $file, ENT_COMPAT, 'UTF-8' );?>:<?php echo $line?></td>
				</tr>
			</table>
		<?php
		}
	}

	public static function error_print_stack_trace( $stack ) {
		echo '<table class="width75">';
		echo '<tr><th>Filename</th><th>Line</th><th></th><th></th><th>Function</th><th>Args</th></tr>';

		# remove the call to the error handler from the stack trace
		array_shift( $stack );

		foreach( $stack as $frame ) {
			echo '<tr><td>', ( isset( $frame['file'] ) ? htmlentities( $frame['file'], ENT_COMPAT, 'UTF-8' ) : '-' ), '</td><td>', ( isset( $frame['line'] ) ? $frame['line'] : '-' ), '</td><td>', ( isset( $frame['class'] ) ? $frame['class'] : '-' ), '</td><td>', ( isset( $frame['type'] ) ? $frame['type'] : '-' ), '</td><td>', ( isset( $frame['function'] ) ? $frame['function'] : '-' ), '</td>';

			$args = array();
			if( isset( $frame['args'] ) && !empty( $frame['args'] ) ) {
				foreach( $frame['args'] as $value ) {
					$args[] = self::error_build_parameter_string( $value );
				}
				echo '<td>( ', htmlentities( implode( $args, ', ' ), ENT_COMPAT, 'UTF-8' ), ' )</td></tr>';
			} else {
				echo '<td>-</td></tr>';
			}
		}
		echo '</table>';
	}


	public static function error_build_parameter_string( $param, $showType = true, $depth = 0 ) {
		if( $depth++ > 10 ) {
			return '<strong>***Nesting Level Too Deep***</strong>';
		}

		if( is_array( $param ) ) {
			$results = array();

			foreach( $param as $t_key => $value ) {
				# Mask Passwords
				if( strpos( $t_key, 'pass' ) !== false ) {
					$value = '**********';
				}
				$results[] = '[' . self::error_build_parameter_string( $t_key, false, $depth ) . ']' . ' => ' . self::error_build_parameter_string( $value, false, $depth );
			}

			return '<Array> { ' . implode( $results, ', ' ) . ' }';
		}
		else if( is_object( $param ) ) {
			$results = array();

			$className = get_class( $param );
			$instVars = get_object_vars( $param );

			foreach( $instVars as $name => $value ) {
				$results[] = "[$name]" . ' => ' . self::error_build_parameter_string( $value, false, $depth );
			}

			return '<Object><' . $className . '> ( ' . implode( $results, ', ' ) . ' )';
		} else {
			if( $showType ) {
				return '<' . gettype( $param ) . '>' . var_export( $param, true );
			} else {
				return var_export( $param, true );
			}
		}
	}

	public static function error_handled() {
		return self::$handled;
	}
}
