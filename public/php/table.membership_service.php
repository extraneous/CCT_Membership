<?php

/*
 * Editor server script for DB table membership_service
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
$db->sql( "CREATE TABLE IF NOT EXISTS `membership_service` (
	`id` int(10) NOT NULL auto_increment,
	`Mem_No` numeric(9,2),
	`Service_Code` varchar(255),
	`Start_Date` date,
	`End_Date` date,
	`status` varchar(255),
	PRIMARY KEY( `id` )
);" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'membership_service', 'id' )
	->fields(
		Field::inst( 'Mem_No' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Service_Code' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Start_Date' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::dateFormat', array( 'format'=>'D, j M y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'D, j M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, j M y' ),
		Field::inst( 'End_Date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'D, j M y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'D, j M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, j M y' ),
		Field::inst( 'status' )
	)
	->process( $_POST )
	->json();
