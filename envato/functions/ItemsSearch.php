<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Envato\Functions;

use Arikaim\Modules\Api\AbstractApiFunction;
use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;

/**
 * Search items api call
 */
class ItemsSearch extends AbstractApiFunction implements ApiFunctionInterface
{
    /**
     * Initialize api funciton
     *
     * @return void
     */
    public function init(): void
    {
        $this
            ->method('GET')
            ->path('v1/discovery/search/search/item');    
    }
}
