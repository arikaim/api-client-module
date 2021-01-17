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

use Arikaim\Core\Utils\Text;
use Arikaim\Core\Utils\Curl;
use Arikaim\Modules\Api\ApiCallResponse;
use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;
use Arikaim\Core\Interfaces\HttpClientInterface;

/**
 * Abstract base class for each api function.
 */
abstract class AbstractApiFunction implements ApiFunctionInterface
{
    const QUERY_PARAMS    = 0;
    const URL_PATH_PARAMS = 1;
    const JSON_PARAMS     = 2;

    /**
     * Requets query params
     *
     * @var array
     */
    protected $queryParams = [];

    /**
     * Requets path params
     *
     * @var array
     */
    protected $pathParams = [];

    /**
     * Api request base url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Request method
     *
     * @var string
     */
    protected $method;

    /**
     * Request path
     *
     * @var string
     */
    protected $path;

    /**
     * Request headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Http client
     *
     * @var HttpClientInterface|null
     */
    protected $httpClient;

    /**
    * Constructor
    *
    * @param string $baseUrl
    * @param array $headers
    * @param string $method
    */
    public function __construct(
        string $baseUrl, 
        array $headers = [], 
        string $method = 'GET', 
        ?HttpClientInterface $client = null
    )
    {
        $this->setBaseUrl($baseUrl);
        $this->setHeaders($headers);
        $this->method($method);
        $this->httpClient = $client;

        $this->init();
    }

    /**
     * Init api call
     *       
     * @return void
    */
    abstract public function init(): void;

    /**
     * Call api function
     * 
     * @param string|null $fileName
     * @return mixed
     */
    public function downloadFile(?string $fileName = null)
    {
        $url = $this->getRequestUrl();
        $result = false;
        if (empty($this->httpClient) == true) {
            if (empty($fileName) == true) {             
                $result = Curl::getFileContent($url,$this->getMethod(),$this->headers);
            } else {
                $result = Curl::downloadFile($url,$fileName,$this->getMethod(),$this->headers);
            }
        } 

        return $result;
    }

    /**
     * Call api function
     *`   
     * @param array|null $params
     * @param int|null $paramsType
     * @return ApiCallResponse
    */
    public function call()
    {
        $url = $this->getRequestUrl();
        if (empty($this->httpClient) == true) {
            $response = Curl::request($url,$this->getMethod(),null,$this->headers);
        } else {
            $response = $this->httpClient->request($url,$this->getMethod(),$this->headers);
        }
      
        return new ApiCallResponse($response);
    }

    /**
     * Get request url
     *
     * @return string
     */
    public function getRequestUrl(): string
    {
        return $this->getBaseUrl() . $this->buildRequestUrl();
    } 

    /**
     *  Set request headers
     */
    public function setHeaders(array $heades): void
    {
        $this->headers = $heades;
    }

    /**
     * Add request header
     *
     * @param string $header
     * @return void
     */
    public function addHeader(string $header): void
    {
        \array_push($this->headers,$header);
    }

    /**
     * Set base url
     *
     * @param string $url
     * @return void
     */
    public function setBaseUrl(string $url): void
    {
        $this->baseUrl = $url;
    }

    /**
     * Get base url
     * 
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Set request method
     *
     * @param string $method
     * @return ApiFunction
     */
    public function method(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set request path
     *
     * @param string $path
     * @return ApiFunction
     */
    public function path(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getPathParams(): array
    {
        return $this->pathParams;
    }

    /**
     * Set path param
     *
     * @param string $name
     * @param string $value
     * @return ApiFunction
     */
    public function pathParam(string $name, string $value) 
    {
        $this->pathParams[$name] = $value;

        return $this;
    }

    /**
     * Set request param
     *
     * @param string $name
     * @param string $value
     * @return ApiFunction
     */
    public function param(string $name, string $value)
    {
        $this->queryParams[$name] = $value;

        return $this;
    }

    /**
     * Get request method
     *     
     * @return string
    */
    public function getMethod(): string
    {
        return $this->method ?? 'GET';
    }
    
    /**
     * Get requiets url path
     *
     * @return string
     */
    public function getUrlPath(): string
    {      
        return Text::render($this->path,$this->pathParams);  
    }
    
    /**
     * Get params
     *
     * @return array
     */
    public function getQueryParams(): array
    {        
        return $this->queryParams;
    }

    /**
     * Set query params
     *
     * @param array $params
     * @return ApiFunction
     */
    public function withQueryParams(array $params)
    {        
        $this->queryParams = $params;

        return $this;
    }

    /**
     * Set query params
     *
     * @return void
     */
    public function setQueryParams(array $params): void
    {
        $this->queryParams = $params;
    }

    /**
     * Set query params
     *
     * @return void
     */
    public function setPathParams(array $params): void
    {
        $this->pathParams = $params;
    }

    /**
     * Create query request params
     *
     * @return string
     */
    public function createQueryParams(): string
    {
        return \http_build_query($this->queryParams);
    }

    /**
     * Create requets url
     *
     * @return string
     */
    public function buildRequestUrl(): string
    {       
        $queryParams = $this->createQueryParams();
        $queryParams = (empty($queryParams) == false) ? '?' . $queryParams : '';
              
        return $this->getUrlPath() . $queryParams;
    }
}
