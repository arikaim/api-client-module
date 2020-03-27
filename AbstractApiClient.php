<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api;

use Arikaim\Modules\Api\Interfaces\ApiClientInterface;

/**
 * Abstract Api client module class
 */
abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * OAuth token
     *
     * @var string
    */
    protected $oauthToken;
    
    /**
     * OAuth token secret
     *
     * @var string
    */
    protected $oauthTokenSecret;

    /**
     * Api request base url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Requets params
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create request authorization header
     *
     * @return string
    */
    abstract public function createAuthHeader();

    /**
     * Constructor
     */
    public function __construct($oauthToken, $oauthTokenSecret)
    {           
        $this->oauthToken = $oauthToken;
        $this->oauthTokenSecret = $oauthTokenSecret;
        $this->parameters = [];
    }

    public funciton request()
    {

    }
    
    /**
     * Create query request params
     *
     * @return void
     */
    public function createQueryParams()
    {
        return http_build_query($this->$parameters);
    }

    /**
     * Set api request param
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function setParam($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Set base url
     *
     * @param string $url
     * @return void
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
    }

    /**
     * Return base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
