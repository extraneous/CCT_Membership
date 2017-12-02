<?php

/*
 * Editor server script for DB table person_receipt
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
Editor::inst( $db, 'person_receipt', 'id' )
	->fields(
		Field::inst( 'person_receipt_id' )
			->set( false ),
		Field::inst( 'person_id' ),
		Field::inst( 'mem_no' ),
		Field::inst( 'date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'amount' )
	)
	->process( $_POST )
	->json();
