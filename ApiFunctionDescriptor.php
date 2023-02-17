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

use Arikaim\Core\Collection\AbstractDescriptor;

/**
 * Api function descriptior
 */
class ApiFunctionDescriptor extends AbstractDescriptor
{
    /**
     * Define properties 
     *
     * @return void
     */
    protected function definition(): void
    {
        $this->property('title',function($property) {
            $property
                ->title('Title')
                ->type('text')   
                ->required(false)                    
                ->value('');                         
        });

        $this->property('description',function($property) {
            $property
                ->title('Description')
                ->type('text')   
                ->required(false)                    
                ->value('');                         
        });

        $this->createCollection('parameters');
        $this->createCollection('result');
    }
}
