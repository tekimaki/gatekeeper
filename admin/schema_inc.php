<?php

global $gBitSystem;

$gBitSystem->registerPackageInfo( GATEKEEPER_PKG_NAME, array(
	'description' => "Gatekeeper system allows the creation of protected content. This content can then only be accessed by using a specified url, password or only the creator.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// Requirements
$gBitSystem->registerRequirements( GATEKEEPER_PKG_NAME, array(
	'liberty' => array( 'min' => '2.1.4' ),
));

// Install process
global $gBitInstaller;
if( is_object( $gBitInstaller ) ){

$tables = array(

'gatekeeper_security' => " 
	security_id I4 PRIMARY,
	user_id I4 NOTNULL,
	security_description C(160) NOTNULL,
	group_id I4,
	is_private C(1),
	is_hidden C(1),
	access_question C(250),
	access_answer C(128)
	CONSTRAINT	', CONSTRAINT `gatekeeper_access_user_ref` FOREIGN KEY (`user_id`) REFERENCES `".BIT_DB_PREFIX."users_users` (`user_id`)'
",

'gatekeeper_security_map' => "
	security_id I4 PRIMARY,
	content_id I4 PRIMARY
	CONSTRAINT	', CONSTRAINT `gatekeeper_consec_sec_ref` FOREIGN KEY (`security_id`) REFERENCES `".BIT_DB_PREFIX."gatekeeper_security` (`security_id`)
				 , CONSTRAINT `gatekeeper_access_content_ref` FOREIGN KEY (`content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content` (`content_id`)'
",

);

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( GATEKEEPER_PKG_NAME, $tableName, $tables[$tableName] );
}

// ### Indexes
$indices = array (
	'gatekeeper_security_user_idx' => array( 'table' => 'gatekeeper_security', 'cols' => 'user_id', 'opts' => NULL ),
	'gatekeeper_consec_security_idx' => array( 'table' => 'gatekeeper_security_map', 'cols' => 'security_id', 'opts' => NULL ),
	'gatekeeper_consec_content_idx' => array( 'table' => 'gatekeeper_security_map', 'cols' => 'content_id', 'opts' => array( 'UNIQUE' ) ),
);
$gBitInstaller->registerSchemaIndexes( GATEKEEPER_PKG_NAME, $indices );

// ### Sequences
$sequences = array (
	'gatekeeper_security_id_seq' => array( 'start' => 1 ) 
);
$gBitInstaller->registerSchemaSequences( GATEKEEPER_PKG_NAME, $sequences );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( GATEKEEPER_PKG_NAME, array(
	array('p_gatekeeper_create', 'Can create a gatekeeper', 'registered', GATEKEEPER_PKG_NAME),
	array('p_gatekeeper_edit', 'Can edit any gatekeeper', 'editors', GATEKEEPER_PKG_NAME),
	array('p_gatekeeper_admin', 'Can admin gatekeeper', 'editors', GATEKEEPER_PKG_NAME),
	array('p_gatekeeper_read', 'Can read gatekeeper', 'basic', GATEKEEPER_PKG_NAME),
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( GATEKEEPER_PKG_NAME, array(
	array(GATEKEEPER_PKG_NAME, 'gatekeeper_default_ordering','title_desc'),
	array(GATEKEEPER_PKG_NAME, 'gatekeeper_list_content_id','y'),
	array(GATEKEEPER_PKG_NAME, 'gatekeeper_list_title','y'),
	array(GATEKEEPER_PKG_NAME, 'gatekeeper_list_description','y'),
) );

}
