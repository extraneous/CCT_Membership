<?php

/*
 * Editor server script for DB table Bank_Account
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
Editor::inst( $db, 'Bank_Account', 'id' )
	->fields(
		Field::inst( 'bank_code' )
			->validator( 'Validate::unique' ),
		Field::inst( 'description' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'nominal_code' )
			->validator( 'Validate::unique' ),
		Field::inst( 'sort_code' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'account_number' )
			->validator( 'Validate::notEmpty' )
	)
	->process( $_POST )
	->json();
