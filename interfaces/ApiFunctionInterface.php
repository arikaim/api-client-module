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
    const QUERY_PARAMS    = 'query';
    const URL_PATH_PARAMS = 'path';
    const JSON_PARAMS     = 'json';
  
    /**
     * Set post fields
     *
     * @param array|null $data
     * @return Self
     */
    public function postFields(?array $data): void;
    
    /**
     * Get request method
     *
     * @return string
    */
    public function getMethod(): string;
    
    /**
     * Set base url
     *   
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Get requiets url path
     *
     * @return string
     */
    public function getUrlPath(): string;
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams(): array;

    /**
     * Set params
     *
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void;

    /**
     * Set params type
     *
     * @param string $type
     * @return Self
     */
    public function paramsType(string $type);

    /**
     * Create requets url from path and params
     *
     * @return string
     */
    public function buildRequestUrl(): string;

    /**
     *  Set request headers
     *
     * @param array $heades
     * @return void
     */
    public function setHeaders(array $heades): void;

    /**
     * Add request header
     *
     * @param string $header
     * @return void
     */
    public function addHeader(string $header): void;

    /**
     * Call api function
     *       
     * @return ApiCallResponse
     */
    public function call();

    /**
     * Call api function
     * 
     * @param string|string $fileName
     * @return mixed
     */
    public function downloadFile(?string $fileName = null);

    /**
     * Initialize api funciton
     *
     * @return void
     */
    public function init(): void;
}
