<?php

/*
 * Editor server script for DB table account_posting_split
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
$db->sql( "CREATE TABLE IF NOT EXISTS `account_posting_split` (
	`id` int(10) NOT NULL auto_increment,
	`Account_Posting_Id` numeric(9,2),
	`Account_Posting_Split_Id` numeric(9,2),
	`Amount` numeric(9,2),
	`Person_Receipt_Split_Id` numeric(9,2),
	`Details` varchar(255),
	PRIMARY KEY( `id` )
);" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'account_posting_split', 'id' )
	->fields(
		Field::inst( 'Account_Posting_Id' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Account_Posting_Split_Id' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Amount' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Person_Receipt_Split_Id' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Details' )
	)
	->process( $_POST )
	->json();
