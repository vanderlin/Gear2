<?php


use Illuminate\Filesystem\Filesystem;

class ConfigHelper extends \Illuminate\Config\FileLoader {
    

    private static $instance = null;

    // ------------------------------------------------------------------------
    static function getInstance() {
        return new Illuminate\Config\FileLoader(Config::getLoader()->getFilesystem(), app_path() . '/config');
        if(ConfigHelper::$instance == null) {
            ConfigHelper::$instance = new Illuminate\Config\FileLoader(Config::getLoader()->getFilesystem(), app_path() . '/config');
        }
        return ConfigHelper::$instance;
    }


    // ------------------------------------------------------------------------
    static function save($namespace, $environment=null) {


        $env  = $environment==null ? Config::getEnvironment() : $environment;
        $loader = ConfigHelper::getInstance();
        $path = $loader->getPath(null);
        
        $items = Config::get($namespace);

        
        $file = (!$env || ($env == 'production')) ? "{$path}/{$namespace}.php" : "{$path}/{$env}/{$namespace}.php";

        $data = '<?php return '.var_export( $items, true ).';';
        
        $loader->files->put($file, $data);
    }

    // ------------------------------------------------------------------------
    static function get($namespace, $environment=null) {

        $loader = ConfigHelper::getInstance();

        $items = array();
        $env  = $environment==null ? Config::getEnvironment() : $environment;

        // First we'll get the root configuration path for the environment which is
        // where all of the configuration files live for that namespace, as well
        // as any environment folders with their specific configuration items.
        $path = $loader->getPath(null);

        $parts = explode('.', $namespace);

        $filename = count($parts)>0?$parts[0]:$namespace;
        $group = implode(".", array_slice($parts, 1));
        $env  = $environment==null ? Config::getEnvironment() : $environment;
        $file = (!$env || ($env == 'production')) ? "{$path}/{$filename}.php" : "{$path}/{$env}/{$filename}.php";

        $items = $loader->files->getRequire($file);
        
        return array_get($items, $group);
    }

    
    // ------------------------------------------------------------------------
    static function setAndSave($namespace, $value, $environment=null) {

        $loader = ConfigHelper::getInstance();

        $items = array();
        $env  = $environment==null ? Config::getEnvironment() : $environment;

        // First we'll get the root configuration path for the environment which is
        // where all of the configuration files live for that namespace, as well
        // as any environment folders with their specific configuration items.
        $path = $loader->getPath(null);

        $parts = explode('.', $namespace);

        $filename = count($parts)>0?$parts[0]:$namespace;
        $group = implode(".", array_slice($parts, 1));
        $env  = $environment==null ? Config::getEnvironment() : $environment;
        $file = (!$env || ($env == 'production')) ? "{$path}/{$filename}.php" : "{$path}/{$env}/{$filename}.php";

        if($loader->files->exists($file)) {
            $items = $loader->files->getRequire($file);   
            
            array_set($items, $group, $value);

            $data = "<?php return ".var_export( $items, true).";";

            File::put($file, $data);
            
        }
        
        return $file;
        return array_get($items, $group);

        //$items = $loader->files->getRequire($file);   
        //$data = '<?php return '.var_export( $items, true ).';';
        
        //$loader->files->put($file, $data);

        
        
    }
    
}
