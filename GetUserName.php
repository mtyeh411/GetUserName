<?php

$wgHooks[ 'ParserFirstCallInit' ][] = "ExtGetUserName::setup";
$wgHooks[ 'LanguageGetMagic' ][]  = 'ExtGetUserName::languageGetMagic';
class ExtGetUserName {
    private static $parserFunctions = array(
        'USERNAME' => 'getUserName',
    );
 
    public static function setup( &$parser ) {
        // register each hook
        foreach( self::$parserFunctions as $hook => $function )
            $parser->setFunctionHook( $hook,
                array( __CLASS__, $function ), SFH_OBJECT_ARGS );
 
        return true;
    }
 
    public static function languageGetMagic( &$magicWords, $langCode ) {
        $magicWords[ 'USERNAME' ] = array( 0, 'USERNAME' ); 
        return true;
    }
 
    public static function getUserName( &$parser, $frame, $args ) {
        $parser->disableCache();
        global $wgUser;
        return trim( $wgUser->getName() );
    }
}
