<?php

/*
 * Editor server script for DB table bank_receipt_batch
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

// The following statement can be removed after the first run (i.e. the database
// table has been created). It is a good idea to do this to help improve
// performance.
$db->sql( "CREATE TABLE IF NOT EXISTS `bank_receipt_batch` (
	`id` int(10) NOT NULL auto_increment,
	`Bank_Code` varchar(255),
	`Paying_In_Amount` numeric(9,2),
	`Paying_In_Reference` numeric(9,2),
	`Bank_Statement_Date` date,
	`Bank_Statement_Line` numeric(9,2),
	`Bank_Statement_Amount` numeric(9,2),
	`Receipt_Type` varchar(255),
	PRIMARY KEY( `id` )
);" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'bank_receipt_batch', 'id' )
	->fields(
		Field::inst( 'Bank_Code' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Paying_In_Amount' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Paying_In_Reference' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Bank_Statement_Date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'D, j M y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'D, j M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, j M y' ),
		Field::inst( 'Bank_Statement_Line' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Bank_Statement_Amount' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Receipt_Type' )
	)
	->process( $_POST )
	->json();
