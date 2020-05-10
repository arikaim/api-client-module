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
     * Get authorization headers or false if api not uses header for auth
     *
     * @return array|false
    */
    public function getAuthHeaders();

    /**
     * Should return api function classes namespace
     *
     * @return string
     */
    public function getFunctionsNamespace();

    /**
     * Call api funciton
     *
     * @param string $apiFunctionClass
     * @return mixed|false
    */
    public function call($apiFunctionClass);
}
