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
use Arikaim\Core\Extension\Module;

/**
 * REST Api client module class
 */
class Api extends Module
{
    /**
     * Image menagaer class
     *
     * @var ImageManager
     */
    private $manager;

    /**
     * Constructor
     */
    public function __construct()
    {
        // module details
        $this->setServiceName('api');       
    }


    /**
     * Get ImageManager instance
     *
     * @return ImageManager
     */
    public function getManager()
    {
        return $this->manager;
    }
}
