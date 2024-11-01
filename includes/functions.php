<?php
/**
 * This function sanitize input field.
 *
 * @param array $data array of array(or simple array) that will be sanitize.
 * @return array
 */
function sptable_sanitize_text_field_array_of_array( $data ) {
	$to_return = array();
	foreach ( $data as $key => $value ) {
		if ( is_array( $value ) ) {
			$to_return[ $key ] = sptable_sanitize_text_field_array_of_array( wp_unslash( $value ) );
		} else {
			$to_return[ $key ] = sanitize_text_field( wp_unslash( $value ) );
		}
	}
	return $to_return;
}
