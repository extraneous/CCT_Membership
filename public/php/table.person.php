<?php
require_once('../../includes/checkLoggedIn.php');
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
		Field::inst( 'person.Title' ),
		Field::inst( 'person.First_Name' ),
		Field::inst( 'person.Last_Name' ),
		Field::Inst( 'person.Tel_No_1' ),
		Field::Inst( 'person.Tel_No_2' ),
		Field::Inst( 'person.Email' ),
		Field::Inst( 'person.GiftAid' ),
		Field::Inst( 'person.GiftAid_Date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::Inst( 'person.Modify_Date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::inst( 'address.id' ),	
		Field::Inst( 'address.Organisation' ),
		Field::Inst( 'address.Number_Or_Name' ),
		Field::inst( 'address.Address_Line_1' ),
		Field::inst( 'address.Address_Line_2' ),
		Field::inst( 'address.Post_Town' ),
		Field::Inst( 'address.County' ),
		Field::inst( 'address.Post_Code' ),
		Field::Inst( 'address.Country' ),
		Field::Inst( 'address.Status' ),
		Field::Inst( 'address.Date_Changed' ),
		Field::inst( 'membership.Mem_No' ),
		Field::inst( 'membership.Organisation_Name' ),
		Field::inst( 'membership.Entered_Date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::inst( 'membership.Apply_Date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::inst( 'membership.Start_Date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::inst( 'membership.Source' )
			->options( Options::inst()
				->table( 'source' )
				->value( 'source.Source_Code' )
				->label( 'source.Location' ) )
			->validator( 'Validate::dbValues' ), 
		Field::inst( 'membership.Mem_Type_Code' )
			->options( Options::inst()
				->table( 'membership_type' )
				->value( 'membership_type.Mem_Type_Code' )
				->label( 'membership_type.Mem_Type_Code' ) )
			->validator( 'Validate::dbValues' ),
		Field::inst( 'membership.Comments' ),
		Field::inst( 'membership.Manual' ),
		Field::inst( 'membership.Cleansed' ),
		Field::inst( 'membership.Lapsed' ),
		Field::inst( 'membership.Lapsed_Date' )
				->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 ) ,
		Field::inst( 'membership.Status' ),
		Field::inst( 'membership.Modify_Date')
	)
	->leftJoin( 'address', 'address.Address_Id', '=', 'person.Address_Id' )
	->leftJoin( 'person_membership', 'person_membership.Person_Id', '=', 'person.Person_Id' )
	->leftJoin( 'membership', 'membership.Mem_No', '=', 'person_membership.Mem_No' )
	->process( $_POST )
	->json();
