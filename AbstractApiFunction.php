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
use Arikaim\Core\Utils\Utils;
use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;

/**
 * Abstract base class for each api function.
 */
abstract class AbstractApiFunction implements ApiFunctionInterface
{
    /**
     * Requets params
     *
     * @var array
     */
    protected $parameters = [];

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
    protected $headers;

    /**
    * Constructor
    *
    * @param string $baseUrl
    * @param array $headers
    * @param string $method
    */
    public function __construct($baseUrl, $headers, $method = 'GET')
    {
        $this->setBaseUrl($baseUrl);
        $this->setHeaders($headers);
        $this->method($method);

        $this->init();
    }

    /**
     * Call api function
     *   
     * @param array $params|null
     * @return mixed|false
    */
    abstract public function init();

    /**
     * Call api function
     *`   
     * @param array|null $params
     * @return mixed|false
    */
    public function call(array $params = null)
    {
        $this->parameters = empty($params) ? $this->parameters : \array_merge($this->parameters,$params);

        $url = $this->getBaseUrl() . $this->buildRequestUrl();
        $response = Curl::request($url,$this->getMethod(),null,$this->headers);

        return (Utils::isJson($response) == true) ? \json_decode($response,true) : $response;
    }

    /**
     *  Set request headers
     */
    public function setHeaders(array $heades)
    {
        $this->headers = $heades;
    }

    /**
     * Add request header
     *
     * @param string $header
     * @return void
     */
    public function addHeader($header)
    {
        \array_push($this->headers,$header);
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
     * Get base url
     * 
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Set request method
     *
     * @param string $method
     * @return ApiFunction
     */
    public function method($method)
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
    public function path($path)
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
    public function param($name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Get request method
     *     
     * @return string
    */
    public function getMethod()
    {
        return $this->method ?? 'GET';
    }
    
    /**
     * Get requiets url path
     *
     * @return string
     */
    public function getUrlPath()
    {      
        return Text::render($this->path,$this->parameters);  
    }
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {        
        return $this->parameters;
    }

    /**
     * Set params
     *
     * @return void
     */
    public function setParams($params)
    {
        $this->parameters = $params;
    }

    /**
     * Create query request params
     *
     * @return string
     */
    public function createQueryParams()
    {
        return \http_build_query($this->parameters);
    }

    /**
     * Create requets url
     *
     * @return string
     */
    public function buildRequestUrl()
    {       
        $queryParams = $this->createQueryParams();
        $queryParams = (empty($queryParams) == false) ? '?' . $queryParams : '';
        
        return $this->getUrlPath() . $queryParams;
    }
}
