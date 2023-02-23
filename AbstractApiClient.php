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
use Exception;

/**
 * Api client class
 */
abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * OAuth token
     *
     * @var string|null
    */
    protected $oauthToken = null;
    
    /**
     * OAuth token secret
     *
     * @var string|null
    */
    protected $oauthTokenSecret = null;

    /**
     * Api key
     *
     * @var string|null
     */
    protected $apiKey = null;

    /**
     * Api request base url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Api functions classes namespace
     *
     * @var string|null
     */
    protected $functionsNamespace = null;

    /**
     * Default request params avaliable form all api calls
     *
     * @var array
     */
    protected $defaultRequestParams = [];

    /**
     * Constructor
     */
    public function __construct()
    {  
        $this->oauthToken = null;   
        $this->oauthTokenSecret = null;    
        $this->baseUrl = '';
        $this->functionsNamespace = null;
        $this->apiKey = null;
        $this->defaultRequestParams = [];
    }

    /**
     * Get error
     *
     * @param mixed $response
     * @return string|null
     */
    public function getError($response): ?string
    {
        return null;
    }
    
    /**
     * Get authorization headers or false if api not uses header for auth
     *
     * @param array|null $params
     * @return array|null
    */
    abstract public function getAuthHeaders(?array $params = null): ?array;

    /**
     * Get error field name
     *
     * @return string|null
    */
    public function getErrorFieldName(): ?string
    {
        return null;
    }

    /**
     * Api function classes namespace
     *
     * @return string
     */
    public function getFunctionsNamespace(): string
    {
        $defaultNamespace = Factory::getClassNamespace(static::class) . "\\Functions\\";

        return $this->functionsNamespace ?? $defaultNamespace;
    }

    /**
     * Set functions namespace
     *
     * @param string $namespace
     * @return void
     */
    public function setFunctionsNamespace(string $namespace): void
    {
        $this->functionsNamespace = $namespace;
    }

    /**
     * Create api function object 
     *
     * @param string $class
     * @param array|null $params    
     * @param array|null $postFields    
     * @throws Exception
     * @return ApiFunctionInterface|null
     */
    public function createApiFunction(string $class, ?array $params = null, ?array $postFields = null)
    {
        if (\class_exists($class) == false) {
            $class = $this->getFunctionsNamespace() . $class;
        }
      
        $apiFunction = new $class($this->getBaseUrl(),[],'GET',null,$this,$params);
        if (($apiFunction instanceof ApiFunctionInterface) == false) {
            throw new Exception('Not valid api function class ' . $class);
        }

        $apiFunction->postFields($postFields);

        return $apiFunction;        
    }  

    /**
     * Call api function
     *
     * @param string $class
     * @param array|null $params   
     * @param array|null $postFields   
     * @return ApiCallResponse|false
    */
    public function call(string $class, ?array $params = null, ?array $postFields = null)
    {
        $apiFunction = $this->createApiFunction($class,$params,$postFields);
       
        return (empty($apiFunction) == true) ? false : $apiFunction->call();    
    }
    
    /**
     * Set OAuth token
     *
     * @param string $token
     * @return void
     */
    public function setOauthToken(?string $token): void
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

    /**
     * Get api key
     *
     * @param string|null $apiKey
     * @return string|null
     */
    public function getApiKey(?string $apiKey = null): ?string
    {
        return $this->apiKey;
    }

    /**
     * Set api key
     *
     * @param string $key
     * @return void
     */
    public function setApiKey(string $key): void
    {
        $this->apiKey = $key;
    }

    /**
     * Get default requets params
     *
     * @return array
     */
    public function getDefaultRequestParams(): array
    {
        return $this->defaultRequestParams;
    }

    /**
     * Set default request param
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function requestParam(string $key, $value): void
    {
        $this->defaultRequestParams[$key] = $value;
    }
}
