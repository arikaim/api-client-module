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

use Psr\Http\Message\ResponseInterface;
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
     * 
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->apiResponse = $response;
    }

    /**
     * Get response as array
     *
     * @return array
     */
    public function toArray(): array
    {
        if (\is_array($this->apiResponse) == true) {
            return $this->apiResponse;
        }
        $result = ($this->apiResponse instanceof ResponseInterface) ? $this->apiResponse->getBody() : $this->apiResponse;
          
        return (Utils::isJson($result) == true) ? \json_decode($result,true) : [];
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
