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

use Arikaim\Core\Utils\Utils;

/**
 * REST Api call response 
 */
class ApiCallResponse
{
    /**
     * Resposne
     *
     * @var mixed
     */
    protected $apiResponse;

    /**
     * Constructor
     */
    public function __construct($response)
    {
        $this->apiResponse = $response;
    }

    /**
     * Get response as array
     *
     * @return array|false
     */
    public function toArray()
    {
        if (\is_array($this->apiResponse) == true) {
            return $this->apiResponse;
        }
        
        return (Utils::isJson($this->apiResponse) == true) ? \json_decode($this->apiResponse,true) : false;
    }

    /**
     * Get raw response
     *
     * @return mixed
     */
    public function getRaw()
    {
        return $this->apiResponse;
    }
}
