<?php

// IDX Resource
$IDX_RESOURCE = array(
    'settings' => array(
        'name'     => 'nalmls',
        'database' => 'nalmls',
        'table'    => '_rewidx_listings',
        'title'    => 'North Alabama MLS'
    ),
    'fields'   => array(
        'id'                          => 'id',
        'ListingMLS'                  => 'ListingMLS',
        'ListingPrice'                => 'ListingPrice',
        'ListingType'                 => 'ListingType',
        'ListingSubType'              => 'ListingSubType',
        'ListingStyle'                => 'ListingStyle',
        'ListingStatus'               => 'ListingStatus',
        'ListingRemarks'              => 'ListingRemarks',
        'ListingImage'                => 'ListingImage',
        'ListingDate'                 => 'ListingDate',
        'ListingDOM'                  => 'ListingDOM',
        'timestamp_created'           => 'timestamp_created',
        'ListingPriceOld'             => 'ListingPriceOld',
        'ListingPriceChanged'         => 'ListingPriceChanged',
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
        'ListingOffice'               => 'ListingOffice',
        'ListingOfficeID'             => 'ListingOfficeID',
        'ListingAgent'                => 'ListingAgent',
        'ListingAgentID'              => 'ListingAgentID',
        'Latitude'                    => 'Latitude',
        'Longitude'                   => 'Longitude',
        'VirtualTour'                 => 'VirtualTour',
    ),
);

// IDX Collection
$IDX = array();

// Add to Collection
array_push($IDX, array('name' => $IDX_RESOURCE['settings']['name'], 'settings' => $IDX_RESOURCE['settings'], 'fields' => $IDX_RESOURCE['fields']));