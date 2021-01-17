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
     * @return array|null
    */
    public function getAuthHeaders(): ?array;

    /**
     * Should return api function classes namespace
     *
     * @return string
     */
    public function getFunctionsNamespace(): string;

    /**
     * Set functions namespace
     *
     * @param string $namespace
     * @return void
     */
    public function setFunctionsNamespace(string $namespace): void;

    /**
     * Create api function object 
     *
     * @param string $apiFunctionClass
     * @param array|null $queryParams
     * @param array|null $pathParams 
     * @return ApiFunctionInterface|null
     */
    public function createApiFunction(string $class, ?array $queryParams = null, ?array $pathParams = null);

    /**
     * Call api function
     *
     * @param string $class
     * @param array|null $queryParams
     * @param array|null $pathParams
     * @return ApiCallResponse|false
    */
    public function call(string $class, ?array $queryParams = null, ?array $pathParams = null);
}
