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

use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;

/**
 * Api function base class
 */
class ApiFunction implements ApiFunctionInterface
{
    /**
     * Requets params
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Constructor
     */
    public function __construct($parameters = [])
    {                   
       
    }

    /**
     * Get request method
     *
     * @return string
    */
    public function getMethod()
    {
    }
    
    /**
     * Get requiets url path
     *
     * @return string
     */
    public function getUrlPath()
    {        
    }
    
    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {        
    }
}
