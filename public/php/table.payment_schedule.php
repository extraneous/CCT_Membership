<?php

/*
 * Editor server script for DB table payment_schedule
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
Editor::inst( $db, 'payment_schedule', 'id' )
	->fields(
		Field::inst( 'appeal_code' )
		->options(
			Options::inst()
	                ->table( 'appeal' )
	                ->value( 'appeal_code' )
	                ->label( 'description' )
		),
		Field::inst( 'person_id' ),
		Field::inst( 'mem_no' ),
		Field::inst( 'bank_code' )
		->options(
			Options::inst()
	                ->table( 'bank_account' )
	                ->value( 'bank_code' )
	                ->label( 'bank_code' )
		),

		Field::inst( 'start_date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'frequency' ),
		Field::inst( 'end_date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'amount' ),
		Field::inst( 'memo' ),
		Field::inst( 'last_received_date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'last_received_amount' )

	)
	->process( $_POST )
	->json();
