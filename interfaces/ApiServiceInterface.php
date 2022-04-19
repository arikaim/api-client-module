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
 * Rest Api service client interface
 */
interface ApiServiceInterface 
{  
    /**
     * Get api service
     *
     * @return object|null
    */
    public function getService();

    /**
     * Check api settings
     *
     * @return boolean
     */
    public function checkConnection(): bool;
}
