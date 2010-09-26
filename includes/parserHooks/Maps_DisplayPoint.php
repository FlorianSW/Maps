<?php

/**
 * Class for the 'display_point' parser hooks.
 * 
 * @since 0.7
 * 
 * @file Maps_DisplayPoint.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsDisplayPoint extends ParserHook {
	
	/**
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticMagic( array &$magicWords, $langCode ) {
		$className = __CLASS__;
		$instance = new $className();
		return $instance->magic( $magicWords, $langCode );
	}
	
	/**
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$wgParser ) {
		$className = __CLASS__;
		$instance = new $className();
		return $instance->init( $wgParser );
	}	
	
	public static function initialize() {
		
	}
	
	/**
	 * Formats a set of points that can have meta data provided.
	 * 
	 * @param string $locations
	 * @param string $name The name of the parameter.
	 * @param array $parameters Array containing data about the so far handled parameters.
	 */		
	public static function formatGeoPoints( &$locations, $name, array $parameters, $metaDataSeparator = false ) {
		$locations = (array)$locations;
		foreach ( $locations as &$location ) {
			self::formatGeoPoint( $location, $name, $parameters, $metaDataSeparator );
		}
	}
	
	public static function formatGeoPoint( &$location, $name, array $parameters, $metaDataSeparator = false ) {
		if ( $metaDataSeparator !== false ) {
			$segments = explode( $metaDataSeparator, $location );
		}
		else {
			$segments = array( $location );
		}
		
		MapsMapper::formatLocation( $segments[0], $name, $parameters );
		
		$location = $segments;
	}		
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @since 0.7
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'display_point';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getParameterInfo() {
		global $egMapsMapWidth, $egMapsMapHeight, $egMapsDefaultServices, $egMapsDefaultTitle, $egMapsDefaultLabel, $egMapsDefaultMapCentre;
		
		$params = MapsMapper::getCommonParameters();
		
		$params['mappingservice']->default = $egMapsDefaultServices['display_point'];
		$params['mappingservice']->addManipulations( new MapsParamService( 'display_point' ) );
		
		$params['coordinates'] = new ListParameter( 'coordinates' );
		$params['coordinates']->addAliases( 'coords', 'location', 'address', 'addresses', 'locations' );
		$params['coordinates']->addCriteria( new CriterionIsLocation( '~' ) );
		$params['coordinates']->addManipulations( new MapsParamCoordSet( '~' ) );		
		$params['coordinates']->lowerCaseValue = false;		
		
		$params['centre'] = new Parameter(
			'centre',
			Parameter::TYPE_STRING,
			$egMapsDefaultMapCentre,
			array( 'center' ),
			array(
				new CriterionIsLocation(),
			)			
		);
		$params['centre']->lowerCaseValue = false;
		
		$params['title'] = new Parameter(
			'title',
			Parameter::TYPE_STRING,
			$egMapsDefaultTitle
		);
		$params['title']->lowerCaseValue = false;
		
		$params['label'] = new Parameter(
			'label',
			Parameter::TYPE_STRING,
			$egMapsDefaultLabel,
			array( 'text' )
		);
		$params['label']->lowerCaseValue = false;
		
		$params['icon'] = new Parameter(
			'icon',
			Parameter::TYPE_STRING,
			'', // TODO
			array(),
			array(
				New CriterionNotEmpty()
			)
		);	
		$params['icon']->lowerCaseValue = false;
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getDefaultParameters() {
		return array( 'coordinates' );
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 * 
	 * @since 0.7
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		// Get the instance of the service class. 
		$service = MapsMappingServices::getServiceInstance( $parameters['mappingservice'], $this->getName() );
		
		// Get an instance of the class handling the current parser hook and service. 
		$mapClass = $service->getFeatureInstance( $this->getName() );
		
		return $mapClass->getMapHtml( $parameters, $this->parser );
	}	
			
}