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
use Arikaim\Modules\Api\Interfaces\ApiClientInterface;
use Arikaim\Modules\Api\ApiFunctionDescriptor;

use Arikaim\Core\Collection\Traits\Descriptor;

/**
 * Abstract base class for each api function.
 */
abstract class AbstractApiFunction implements ApiFunctionInterface
{
    use Descriptor;

    /**
     * Request params type (query, path or json)
     *
     * @var string
     */
    protected $paramsType;

    /**
     * Requets params
     *
     * @var array
     */
    protected $params = [];

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
     * Api client
     *
     * @var ApiClientInterface|null
     */
    protected $apiClient;

    /**
     * Post fields
     *
     * @var array|null
     */
    protected $postFields = null;

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
        ?HttpClientInterface $client = null,
        ?ApiClientInterface $apiClient = null
    )
    {
        $this->setBaseUrl($baseUrl);
        $this->setHeaders($headers);
        $this->method($method);
        $this->httpClient = $client;
        $this->apiClient = $apiClient;
        $this->paramsType = ApiFunctionInterface::QUERY_PARAMS;
        $this->params = [];
        $this->setDescriptorClass(ApiFunctionDescriptor::class);

        $this->init();
    }

    /**
     * Set post fields
     *
     * @param array|null $data
     * @return Self
     */
    public function postFields(?array $data): void
    {
        $this->postFields = $data;
    }

    /**
     * Get post fields
     *
     * @return array|null
     */
    public function getPostFields(): ?array
    {
        return $this->postFields;
    }

    /**
     * Set params type
     *
     * @param string $type
     * @return Self
     */
    public function paramsType(string $type)
    {
        $this->paramsType = $type;

        return $this;
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
        $headers = $this->getHeaders();

        if (empty($this->httpClient) == true) {
            if (empty($fileName) == true) {             
                $result = Curl::getFileContent($url,$this->getMethod(),$headers);
            } else {
                $result = Curl::downloadFile($url,$fileName,$this->getMethod(),$headers);
            }
        } 

        return $result ?? false;
    }

    /**
     * Call api function
     *
     * @return ApiCallResponse
    */
    public function call()
    {
        $url = $this->getRequestUrl();
        $method = $this->getMethod();
        $headers = $this->getHeaders();

        if (empty($this->httpClient) == true) {
            $response = Curl::request($url,$method,$this->postFields,$headers);
        } else {
            $response = $this->httpClient->request($url,$method,$headers);
        }
      
        return new ApiCallResponse($response,$this->apiClient->getErrorFieldName());
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
     * Get request headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = ($this->apiClient == null) ? $this->headers : $this->apiClient->getAuthHeaders([
            'url'      => $this->getRequestUrl(),          
            'base_url' => $this->getBaseUrl(),
            'url_path' => $this->getUrlPath(), 
            'method'   => $this->getMethod(),
            'params'   => $this->getParams(),
            'post_fields' => (\is_array($this->postFields) == true) ? $this->postFields : []
        ]); 
        
        return (\is_array($headers) == true) ? \array_merge($headers,$this->headers) : $this->headers;
    }

    /**
     * Add request header
     *
     * @param string $header
     * @return Self
     */
    public function addHeader(string $header)
    {
        $this->headers[] = $header;

        return $this;
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
     * Set request param
     *
     * @param string $name
     * @param string $value
     * @return ApiFunction
     */
    public function param(string $name, string $value)
    {
        $this->params[$name] = $value;

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
        $tokens = explode('/',$this->path ?? '');
        $result = '';

        foreach ($tokens as $token) {
            $value = Text::render($token,$this->getParams());  
            
            if (empty($value) == false) {
                $result .= (empty($result) == true) ? $value : '/'. $value;
            }           
        }
        
        return $result;
    }
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array
    {        
        return \array_merge($this->params,$this->apiClient->getDefaultRequestParams());
    }

    /**
     * Set params
     *
     * @param array $params
     * @return ApiFunction
     */
    public function withParams(array $params)
    {        
        $this->params = $params;

        return $this;
    }

    /**
     * Set params
     *
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Create requets url
     *
     * @return string
     */
    public function buildRequestUrl(): string
    {              
        $queryParams = ''; 
        if ($this->paramsType == ApiFunctionInterface::QUERY_PARAMS) {
            $queryParams = \http_build_query($this->getParams());
            $queryParams = (empty($queryParams) == false) ? '?' . $queryParams : '';
        }
                    
        return $this->getUrlPath() . $queryParams;
    }
}
