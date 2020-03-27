<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Twitter;

use Arikaim\Modules\Api\AbstractApiClient;
use Arikaim\Modules\Api\Interfaces\ApiClientInterface;

/**
 * Twitter Api client class
 */
class TwitterApi extends AbstractApiClient implements ApiClientInterface
{
    /**
     * Create request authorization header
     *
     * @return string
    */
    public function createAuthHeader()
    {

    }
}
