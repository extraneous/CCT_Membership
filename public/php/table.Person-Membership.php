<?php

/*
 * Editor server script for DB table person
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
Editor::inst( $db, 'person', 'id' )
	->fields(
		Field::inst( 'membership.Mem_No' ),
		Field::inst( 'person.Title' ),
		Field::inst( 'person.First_Name' ),
		Field::inst( 'person.Last_Name' ),
		Field::inst( 'address.Address_Line_1' ),
		Field::inst( 'address.Post_Code' ),
		Field::inst( 'membership.Mem_Type_Code' )
			->options( Options::inst()
				->table( 'membership_type' )
				->value( 'Mem_Type_Code' )
				->label( 'Mem_Type_Code' ) )
			->validator( 'Validate::dbValues' ),
		Field::inst( 'membership.Lapsed' ),
		Field::inst( 'membership.Comments' )

	)
	->leftJoin( 'address', 'address.Address_Id', '=', 'person.Address_Id' )
	->leftJoin( 'person_membership', 'person_membership.Person_Id', '=', 'person.Person_Id' )
	->leftJoin( 'membership', 'membership.Mem_No', '=', 'person_membership.Mem_No' )
	->process( $_POST )
	->json();
