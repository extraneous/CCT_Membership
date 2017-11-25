<?php

/*
 * Editor server script for DB table Source
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
$db->sql( "CREATE TABLE IF NOT EXISTS `Source` (
	`id` int(10) NOT NULL auto_increment,
	`Source_Code` varchar(255),
	`Location` varchar(255),
	`status` varchar(255),
	PRIMARY KEY( `id` )
);" );

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'Source', 'id' )
	->fields(
		Field::inst( 'Source_Code' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::unique' ),
		Field::inst( 'Location' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'status' )
	)
	->process( $_POST )
	->json();
