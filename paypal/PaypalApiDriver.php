<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Envato;

use Arikaim\Core\Arikaim;
use Arikaim\Modules\Api\AbstractApiClient;
use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Modules\Api\Interfaces\ApiClientInterface;

/**
 * Paypal api driver class
 */
class PaypalApiDriver extends AbstractApiClient implements DriverInterface, ApiClientInterface
{   
    use Driver;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('envato','api','EnvatoApiDriver','Envato Api driver');      
    }

    /**
     * Initialize driver
     *
     * @return void
     */
    public function initDriver($properties)
    {
        $this->setBaseUrl($properties->getValue('baseUrl'));    
        $this->setOauthToken($properties->getValue('token'));        
    }

    /**
     * Get authorization header or false if api not uses header for auth
     *
     * @return array|null
    */
    public function getAuthHeaders(): ?array
    {
        return [
            'Authorization: Bearer ' . $this->oauthToken
        ];
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return array
     */
    public function createDriverConfig($properties)
    {
        
    }
}
