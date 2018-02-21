<?php

define('API_URL', 'https://abraia.me/api');
define('CONFIG_FILE', getenv('HOME').'/.abraia');

function load_auth() {
    $api_key = getenv('ABRAIA_API_KEY');
    $api_secret = getenv('ABRAIA_API_SECRET');
    $config = array(
        'abraia_api_key' => ($api_key === false ? '' : $api_key),
        'abraia_api_secret' => ($api_secret === false ? '' : $api_secret),
    );
    if (file_exists(CONFIG_FILE) and ($api_key === false or $api_secret === false)){
        $lines = file(CONFIG_FILE);
        foreach($lines as $line) {
            $vals = explode(':', $line);
            $key = $vals[0];
            $value = trim($vals[1]);
            $config[$key] = $value;
        }
    }
    return array($config['abraia_api_key'], $config['abraia_api_secret']);
}

$keys = load_auth();

define('API_KEY', $keys[0]);
define('API_SECRET', $keys[1]);

?>
