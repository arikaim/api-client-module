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
     * Get error field name
     *
     * @return string|null
    */
    public function getErrorFieldName(): ?string;

    /**
     * Get error
     *
     * @param mixed $response
     * @return string|null
     */
    public function getError($response): ?string;

    /**
     * Get authorization headers or false if api not uses header for auth
     *
     * @param array|null $params
     * @return array|null
    */
    public function getAuthHeaders(?array $params = null): ?array;

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
     * @param array|null $params   
     * @param array|null $postFields   
     * @return ApiFunctionInterface|null
     */
    public function createApiFunction(string $class, ?array $params = null, ?array $postFields = null);

    /**
     * Call api function
     *
     * @param string $class
     * @param array|null $params 
     * @param array|null $postFields   
     * @return ApiCallResponse|false
    */
    public function call(string $class, ?array $params = null, ?array $postFields = null);
}
