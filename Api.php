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
use DirectoryIterator;

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
    }

    /**
     * Get api functions class list
     *
     * @param string $namespace  Functions namespace
     * @return array
     */
    public function getApiFunctionsClasses(string $namespace): array
    {       
        global $container;

        $namespacePath = $container->get('class.loader')->namespaceToPath($namespace);
        $path = ROOT_PATH . BASE_PATH . DIRECTORY_SEPARATOR . $namespacePath;

        if (\file_exists($path) == false) {            
            return [];
        }

        $result = [];
        foreach (new DirectoryIterator($path) as $file) {
            if (
                $file->isDot() == true || 
                $file->isDir() == true ||
                $file->getExtension() != 'php'
            ) continue;
          
            $result[] = \str_replace('.php','',$file->getFilename());           
        }

        return $result;
    }
}
