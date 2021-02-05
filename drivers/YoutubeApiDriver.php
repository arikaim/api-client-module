<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Drivers;

use Arikaim\Core\Arikaim;
use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Modules\Api\Interfaces\ApiServiceInterface;

/**
 * Youtube api driver class
 */
class YoutubeApiDriver implements DriverInterface, ApiServiceInterface
{   
    use Driver;

    /**
     * Api service
     *
     * @var mixed
     */
    protected $service;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('youtube-api','feeds.media','YoutubeApiDriver','Youtube Api driver');      
    }

    /**
     * Initialize driver
     *
     * @return void
     */
    public function initDriver($properties)
    {
        $apiKey = $properties->getValue('api_key');
        $client = new \Google\Client();
        $client->setDeveloperKey($apiKey);

        $this->service = new \Google_Service_YouTube($client);    
    }

    /**
     * Get api service 
     *
     * @return object
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return array
     */
    public function createDriverConfig($properties)
    {
        $properties->property('api_key',function($property) {
            $property
                ->title('API Key')
                ->type('text')              
                ->value('');                         
        }); 
    }
}
