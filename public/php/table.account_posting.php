<?php

/*
 * Editor server script for DB table Account_Posting
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
$db->sql( "CREATE TABLE IF NOT EXISTS `Account_Posting` (
	`id` int(10) NOT NULL auto_increment,
	`Account_Posting_Ref` varchar(255),
	`Description` varchar(255),
	`Budget_Code` varchar(255),
	`Status` varchar(255),
	`Tran_Date` date,
	`Tran_Number` numeric(9,2),
	PRIMARY KEY( `id` )
);" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'Account_Posting', 'id' )
	->fields(
		Field::inst( 'Account_Posting_Ref' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::unique' ),
		Field::inst( 'Description' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Budget_Code' )
			->options( Options::inst()
				->table( 'budget_code' )
				->value( 'Budget_Code' )
				->label( 'Budget_Details' ) )
			->validator( 'Validate::dbValues' ) ,
		Field::inst( 'Bank_Code' )
			->options( Options::inst()
				->table( 'bank_account	' )
				->value( 'Bank_Code' )
				->label( 'Description' ) )
			->validator( 'Validate::dbValues' ) ,
		Field::inst( 'Status' ),
		Field::inst( 'Tran_Date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'D, j M y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'D, j M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, j M y' ),
		Field::inst( 'Tran_Number' )
	)
	->process( $_POST )
	->json();
