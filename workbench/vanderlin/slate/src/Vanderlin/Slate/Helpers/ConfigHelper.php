<?php namespace Vanderlin\Slate\Helpers;



use Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;

class ConfigHelper extends \Illuminate\Config\FileLoader {
    

    private static $instance = null;

    // ------------------------------------------------------------------------
    static function getInstance() {
        return new FileLoader(Config::getLoader()->getFilesystem(), app_path() . '/config');
        if(ConfigHelper::$instance == null) {
            ConfigHelper::$instance = new \Illuminate\Config\FileLoader(Config::getLoader()->getFilesystem(), app_path() . '/config');
        }
        return ConfigHelper::$instance;
    }

    // ------------------------------------------------------------------------
    public function loadConfig() {
        $reader = new FileLoader(Config::getLoader()->getFilesystem(), app_path() . '/config');
        return $reader;
    }

    // ------------------------------------------------------------------------
    static function save($namespace, $environment=null) {

        $loader = ConfigHelper::getInstance();

        $path = $loader->load('production', 'config');

        dd([$path,
            $namespace
            ]);


        $env  = $environment==null ? Config::getEnvironment() : $environment;
        
        
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
    static function setAndSaveConfigFile($file, $namespace, $value, $environment=null) {

        $phppos = strrpos($file, ".php");
        $load_name = substr($file, 0, $phppos?$phppos:strlen($file));
        $file_name = $phppos ? $file : $file.'.php';

        $env  = $environment==null ? Config::getEnvironment() : $environment;
        $reader = Config::getLoader();
        $path = $reader->getPath(null);
        $data = $reader->load($env, $load_name);


        if($namespace == null) {
            $data = $value;
        }
        else {
            array_set($data, $namespace, $value);
        }

        $new_data = "<?php return ".var_export( $data, true).";";

        File::put($path.'/'.$file_name, $new_data);
        
        return $new_data;        
        
    }
    
}
