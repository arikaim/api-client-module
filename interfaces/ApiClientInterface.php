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
 * Rest Api client interface
 */
interface ApiClientInterface 
{  
    /**
     * Create request authorization header
     *
     * @return string
    */
    public function createAuthHeader();
}
