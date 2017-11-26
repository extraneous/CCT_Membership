<?php

/*
 * Editor server script for DB table bank_receipt
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
Editor::inst( $db, 'bank_receipt', 'id' )
	->fields(
		Field::inst( 'Receipt_Date' )
			->validator( 'Validate::dateFormat', array( 'format'=>'D, j M y' ) )
			->getFormatter( 'Format::date_sql_to_format', 'D, j M y' )
			->setFormatter( 'Format::date_format_to_sql', 'D, j M y' ),
		Field::inst( 'Receipt_Batch_Id' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Receipt_Amount' )
			->validator( 'Validate::notEmpty' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Pay_Method' ),
		Field::inst( 'Match_Status' )
			->validator( 'Validate::notEmpty' ),
		Field::inst( 'Person_Id' )
			->validator( 'Validate::numeric' ),
		Field::inst( 'Membership_Status' ),
		Field::inst( 'GiftAid_Status' ),
		Field::inst( 'GiftAid_Claim_Ref' ),
		Field::inst( 'Note' )
	)
	->process( $_POST )
	->json();
