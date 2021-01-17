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
    public function getPathParams(): array;

    /**
     * Set params
     *
     * @param array $params
     * @return void
     */
    public function setQueryParams(array $params): void;

    /**
     * Set params
     *
     * @param array $params
     * @return void
     */
    public function setPathParams(array $params): void;

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
