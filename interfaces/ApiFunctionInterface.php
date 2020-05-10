<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Interfaces;

/**
 * Rest Api funciton interface
 */
interface ApiFunctionInterface 
{  
    /**
     * Get request method
     *
     * @return string
    */
    public function getMethod();
    
    /**
     * Set base url
     *   
     * @return string
     */
    public function getBaseUrl();

    /**
     * Get requiets url path
     *
     * @return string
     */
    public function getUrlPath();
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams();

    /**
     * Set params
     *
     * @param array $params
     * @return void
     */
    public function setParams($params);

    /**
     * Create requets url from path and params
     *
     * @return string
     */
    public function buildRequestUrl();

    /**
     *  Set request headers
     *
     * @param array $heades
     * @return void
     */
    public function setHeaders(array $heades);

    /**
     * Add request header
     *
     * @param string $header
     * @return void
     */
    public function addHeader($header);

    /**
     * Call api function
     *`   
     * @param array $params|null
     * @return mixed|false
    */
    public function call(array $params = null);

    /**
     * Initialize api funciton
     *
     * @return void
     */
    public function init();
}
