<?php

global $gBitSystem, $gUpgradeFrom, $gUpgradeTo;

$upgrades = array(

	'BWR1' => array(
		'BWR2' => array(
// de-tikify tables
array( 'DATADICT' => array(
	array( 'RENAMETABLE' => array(
		'tiki_security' => 'gatekeeper_security',
		'tiki_content_security_map' => 'gatekeeper_security_map',
	)),
	array( 'ALTER' => array(
		'gatekeeper_security' => array(
			'group_id' => array( '`group_id`', 'I4' ), // , 'NOTNULL' ),
		),
	)),
)),
		)
	),
);

if( isset( $upgrades[$gUpgradeFrom][$gUpgradeTo] ) ) {
	$gBitSystem->registerUpgrade( GATEKEEPER_PKG_NAME, $upgrades[$gUpgradeFrom][$gUpgradeTo] );
}
?>
