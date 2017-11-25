<?php

/*
 * Editor server script for DB table address
 * Created by http://editor.datatables.net/generator
 */

// DataTables PHP library and database connection
include( "lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'address', 'id' )
	->fields(
		Field::inst( 'address.organisation' ),
		Field::inst( 'address.number_or_name' ),
		Field::inst( 'address.address_line_1' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'address.address_line_2' ),
		Field::inst( 'address.post_town' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'address.county' ),
		Field::inst( 'address.post_code' ),
		Field::inst( 'address.status' ),
		Field::inst( 'address.date_changed' )
	)
	->process( $_POST )
	->json();
