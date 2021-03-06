<?php

// IDX Resource
$IDX_RESOURCE = array(
	'settings' => array(
		'name'     => 'tarco',
		'database' => 'tarco',
		'table'    => '_rewidx_listings',
		'title'    => 'Telluride Association of Realtors'
	),
	'fields'   => array(
		'id'                          => 'id',
		'ListingMLS'                  => 'ListingMLS',
		'ListingPrice'                => 'ListingPrice',
		'ListingPriceOld'             => 'ListingPriceOld',
		'ListingPriceChanged'         => 'ListingPriceChanged',
		'ListingType'                 => 'ListingType',
		'ListingSubType'              => 'ListingSubType',
		'ListingStyle'                => 'ListingStyle',
		'ListingStatus'               => 'ListingStatus',
		'ListingStatusOld'            => 'ListingStatusOld',
		'ListingStatusChanged'        => 'ListingStatusChanged',
		'ListingRemarks'              => 'ListingRemarks',
		'ListingImage'                => 'ListingImage',
		'ListingDate'                 => 'ListingDate',
		'ListingDOM'                  => 'ListingDOM',
        'timestamp_created'           => 'timestamp_created',
		'Address'                     => 'Address',
		'AddressArea'                 => 'AddressArea',
		'AddressSubdivision'          => 'AddressSubdivision',
		'AddressCity'                 => 'AddressCity',
		'AddressCounty'               => 'AddressCounty',
		'AddressState'                => 'AddressState',
		'AddressZipCode'              => 'AddressZipCode',
		'SchoolDistrict'              => 'SchoolDistrict',
		'SchoolElementary'            => 'SchoolElementary',
		'SchoolMiddle'                => 'SchoolMiddle',
		'SchoolHigh'                  => 'SchoolHigh',
		'NumberOfBedrooms'            => 'NumberOfBedrooms',
		'NumberOfBathrooms'           => 'NumberOfBathrooms',
		'NumberOfBathsFull'           => 'NumberOfBathsFull',
		'NumberOfBathsHalf'           => 'NumberOfBathsHalf',
		'NumberOfSqFt'                => 'NumberOfSqFt',
		'NumberOfAcres'               => 'NumberOfAcres',
		'NumberOfStories'             => 'NumberOfStories',
		'NumberOfGarages'             => 'NumberOfGarages',
		'NumberOfParkingSpaces'       => 'NumberOfParkingSpaces',
		'NumberOfFireplaces'          => 'NumberOfFireplaces',
		'YearBuilt'                   => 'YearBuilt',
		'HasPool'                     => 'HasPool',
		'HasFireplace'                => 'HasFireplace',
		'HasBasement'                 => 'HasBasement',
		'IsWaterfront'                => 'IsWaterfront',
		'IsForeclosure'               => 'IsForeclosure',
		'IsShortSale'                 => 'IsShortSale',
		'IsBankOwned'                 => 'IsBankOwned',
		'DescriptionLot'              => 'DescriptionLot',
		'DescriptionSqFt'             => 'DescriptionSqFt',
		'DescriptionPool'             => 'DescriptionPool',
		'DescriptionView'             => 'DescriptionView',
		'DescriptionStories'          => 'DescriptionStories',
		'DescriptionFireplace'        => 'DescriptionFireplace',
		'DescriptionWaterfront'       => 'DescriptionWaterfront',
		'DescriptionBasement'         => 'DescriptionBasement',
		'DescriptionGarages'          => 'DescriptionGarages',
		'DescriptionParking'          => 'DescriptionParking',
		'DescriptionAmenities'        => 'DescriptionAmenities',
		'DescriptionAppliances'       => 'DescriptionAppliances',
		'DescriptionUtilities'        => 'DescriptionUtilities',
		'DescriptionFeatures'         => 'DescriptionFeatures',
		'DescriptionExterior'         => 'DescriptionExterior',
		'DescriptionExteriorFeatures' => 'DescriptionExteriorFeatures',
		'DescriptionInterior'         => 'DescriptionInterior',
		'DescriptionInteriorFeatures' => 'DescriptionInteriorFeatures',
		'DescriptionHeating'          => 'DescriptionHeating',
		'DescriptionCooling'          => 'DescriptionCooling',
		'DescriptionZoning'           => 'DescriptionZoning',
		'DescriptionRoofing'          => 'DescriptionRoofing',
		'DescriptionWindows'          => 'DescriptionWindows',
		'DescriptionConstruction'     => 'DescriptionConstruction',
		'DescriptionFoundation'       => 'DescriptionFoundation',
		'DescriptionHOAFees'          => 'DescriptionHOAFees',
		'DescriptionHOAFeesFrequency' => 'DescriptionHOAFeesFrequency',
		'ListingOffice'               => 'ListingOffice',
		'ListingOfficeID'             => 'ListingOfficeID',
		'ListingAgent'                => 'ListingAgent',
		'ListingAgentID'              => 'ListingAgentID',
		'Latitude'                    => 'Latitude',
		'Longitude'                   => 'Longitude',
		'VirtualTour'                 => 'VirtualTour',
		'DescriptionLofts'            => 'DescriptionLofts',
		'DescriptionDeedRestrictions' => 'DescriptionDeedRestrictions',
		'DescriptionLegal'            => 'DescriptionLegal',
		'DescriptionSqFtSource'       => 'DescriptionSqFtSource',
		'YearRemodeled'               => 'YearRemodeled',
		'DescriptionDisclosures'      => 'DescriptionDisclosures',
		'ListingCoAgent'              => 'ListingCoAgent',
		'ListingCoOffice'             => 'ListingCoOffice',
		'ListingTaxes'                => 'ListingTaxes',
		'ListingTaxYear'              => 'ListingTaxYear',
		'DescriptionTransferTax'      => 'DescriptionTransferTax'
	)
);

// IDX Collection
$IDX = array();

// Add to Collection
array_push($IDX, array('name' => $IDX_RESOURCE['settings']['name'], 'settings' => $IDX_RESOURCE['settings'], 'fields' => $IDX_RESOURCE['fields']));
