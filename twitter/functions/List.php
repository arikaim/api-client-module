<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Api\Twitter\Functions;

use Arikaim\Modules\Api\Interfaces\ApiFunctionInterface;

/**
 * List api call
 */
class List extends ApiFunction implements ApiFunctionInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {                   
        $this
            ->method('GET')
            ->path('lists/list.json')
            ->param('user_id')
            ->param('screen_name')
            ->param('reverse');
    }
}
