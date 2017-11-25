<?php

/*
 * Editor server script for DB table membership_type
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
Editor::inst( $db, 'membership_type', 'id' )
	->fields(
		Field::inst( 'mem_type_code' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'amount' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'frequency' ),
//			->validator( 'Validate::notEmpty' ),
		Field::inst( 'from_date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'to_date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'Y-m-d' ) )
			->getFormatter( 'Format::date_sql_to_format', 'Y-m-d' )
			->setFormatter( 'Format::date_format_to_sql', 'Y-m-d' ),
		Field::inst( 'count' )
			->validator( 'Validate::notEmpty' )
	)
	->where ( 'to_date' , null, '=' )
	->process( $_POST )
	->json();
