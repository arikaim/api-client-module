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
}
