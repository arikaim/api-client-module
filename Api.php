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

use Arikaim\Core\Extension\Module;

/**
 * REST Api client module class
 */
class Api extends Module
{
    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->installDriver('Arikaim\\Modules\\Api\\Drivers\\GitHubApiDriver');
        $this->installDriver('Arikaim\\Modules\\Api\\Drivers\\EnvatoApiDriver');
        $this->installDriver('Arikaim\\Modules\\Api\\Drivers\\YoutubeApiDriver');
    }
}
