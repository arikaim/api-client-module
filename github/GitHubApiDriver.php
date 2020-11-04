<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Github;

use Arikaim\Core\Arikaim;
use Arikaim\Modules\Api\AbstractApiClient;
use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;
use Arikaim\Modules\Api\Interfaces\ApiClientInterface;

/**
 * GitHub api driver class
 */
class GitHubApiDriver extends AbstractApiClient implements DriverInterface, ApiClientInterface
{   
    use Driver;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('github-api','repository','GitHubApiDriver','Github Api driver');      
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
     * @return array|false
    */
    public function getAuthHeaders()
    {
        return [
            'Authorization: token ' . $this->oauthToken,
            'Accept: application/vnd.github.nebula-preview+json',
            'User-Agent: Arikaim CMS'
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
        $properties->property('baseUrl',function($property) {
            $property
                ->title('Base Url')
                ->type('text')
                ->default('https://api.github.com/')
                ->value('https://api.github.com/')
                ->readonly(true);              
        }); 
        
        $properties->property('token',function($property) {
            $property
                ->title('OAuth2 Access Token')
                ->type('text')              
                ->value('');                         
        }); 
    }
}
