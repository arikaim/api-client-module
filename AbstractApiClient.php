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
use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;
use Arikaim\Core\Utils\Factory;

/**
 * Api client class
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
     * Constructor
     */
    public function __construct()
    {           
        $this->oauthToken = null;
        $this->oauthTokenSecret = null;
    }

    /**
     * Get authorization headers or false if api not uses header for auth
     *
     * @return array|false
    */
    abstract public function getAuthHeaders();

    /**
     * Api function classes namespace
     *
     * @return string
     */
    public function getFunctionsNamespace()
    {
        return Factory::getClassNamespace(static::class) . "\\Functions\\";
    }

    /**
     * Create api function object 
     *
     * @param string $apiFunctionClass
     * @return ApiFunctionInterface|false
     */
    public function createApiFunction($apiFunctionClass)
    {
        $class = $this->getFunctionsNamespace() . $apiFunctionClass;
        $apiFunction = null;

        if (\class_exists($class) == true) {
            $apiFunction = new $class($this->getBaseUrl(),$this->getAuthHeaders());
        }

        return (\is_object($apiFunction) == false) ? false : $apiFunction;        
    }  

    /**
     * Call api function
     *
     * @param string|object $name Api funciton class name or object ref
     * @param array $params
     * @return mixed|false
    */
    public function call($name, array $params = null)
    {
        $apiFunction = ($name instanceof ApiFunctionInterface) ? $name : $this->createApiFunction($name,$params);
        
        return ($apiFunction === false) ? false : $apiFunction->call($params);           
    }
    
    /**
     * Set OAuth token
     *
     * @param string $url
     * @return void
     */
    public function setOauthToken($token)
    {
        $this->oauthToken = $token;
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
