#!/usr/bin/php -q
<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('CLI only');

define('APP_DIR', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);

$command = $argv[1] ?? null;
$input = $argv[2] ?? null;

if (!$command || !$input) {
    echo help_text();
    exit;
}

$make_type = strtolower(str_replace('make:', '', $command));

switch ($make_type) {
    case 'controller':
    case 'model':
        generate_class($make_type, $input);
        break;
    case 'helper':
        generate_helper($input);
        break;
    case 'library':
        generate_library($input);
        break;
    case 'view':
        generate_view($input);
        break;
    case 'language':
        generate_language($input);
        break;
    case 'config':
        generate_config($input);
        break;
    default:
        echo danger("Invalid option: \"$make_type\"") . PHP_EOL;
        echo help_text();
        exit;
}

function generate_class($type, $path) {
    $sub_dir = $type . 's';
    $extends = ucfirst($type);

    $parts = explode('/', str_replace('\\', '/', $path));
    $class_name = ucfirst(array_pop($parts));
    $relative_path = implode(DIRECTORY_SEPARATOR, $parts);
    $folder_path = APP_DIR . $sub_dir . DIRECTORY_SEPARATOR . $relative_path;
    $file_path = $folder_path . DIRECTORY_SEPARATOR . $class_name . '.php';

    if (!is_dir($folder_path)) mkdir($folder_path, 0777, true);

    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * " . ucfirst($type) . ": {$class_name}
 * 
 * Automatically generated via CLI.
 */
class {$class_name} extends {$extends} {
";

    // Add model-specific properties
    if ($type === 'model') {
        $content .= "    protected \$table = '';\n";
        $content .= "    protected \$primary_key = 'id';\n\n";
    }

    $content .= "    public function __construct()
    {
        parent::__construct();
    }
}";

    write_file($file_path, $content, ucfirst($type), $class_name);
}

function generate_helper($name) {
    // Check if name has an extension
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $base_name = $extension ? pathinfo($name, PATHINFO_FILENAME) : $name;

    // File name with or without extension
    $file_name = $extension ? $name : $base_name . '_helper.php';
    $file_path = APP_DIR . 'helpers/' . $file_name;

    // Function name will always end with _helper
    $function_name = strtolower($base_name) . '_helper';

    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Helper: {$file_name}
 * 
 * Automatically generated via CLI.
 */

function {$function_name}()
{
    // Your helper logic here
}
";

    write_file($file_path, $content, 'Helper', $file_name);
}


function generate_library($name) {
    $class_name = ucfirst($name);
    $file_path = APP_DIR . 'libraries/' . $class_name . '.php';

    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Library: {$class_name}
 * 
 * Automatically generated via CLI.
 */
class {$class_name} {

    public function __construct()
    {
        // Library initialized
    }
}
";

    write_file($file_path, $content, 'Library', $class_name);
}

function generate_view($name) {
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $base_name = $extension ? pathinfo($name, PATHINFO_FILENAME) : $name;
    $file_name = $extension ? $name : $name . '.php';
    $file_path = APP_DIR . 'views/' . $file_name;

    $content = "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>" . ucfirst($base_name) . "</title>
</head>
<body>
    <h1>Welcome to " . ucfirst($base_name) . " View</h1>
</body>
</html>";

    write_file($file_path, $content, 'View', $file_name);
}

function generate_language($name) {
    $file_path = APP_DIR . 'language/' . $name . '.php';

    $content = "<?php
return array(
    /**
     * Other String to be translated here
     */
    'welcome' => 'Hello {username} {type}',
);
";

    write_file($file_path, $content, 'Language', $name);
}

function generate_config($name) {
    $file_path = APP_DIR . 'config/' . $name . '.php';

    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Config: {$name}
 * 
 * Automatically generated via CLI.
 */

// Add your configuration here
";

    write_file($file_path, $content, 'Config', $name);
}

function write_file($path, $content, $type, $name) {
    if (!file_exists($path)) {
        file_put_contents($path, $content);
        echo success("$type \"$name\" created at $path");
    } else {
        echo danger("$type \"$name\" already exists.");
    }
}

function danger($string = '', $padding = true) {
    $length = strlen($string) + 4;
    $output = '';

    if ($padding) $output .= "\e[0;41m" . str_pad(' ', $length) . "\e[0m\n";
    $output .= "\e[0;41m" . ($padding ? '  ' : '') . $string . ($padding ? '  ' : '') . "\e[0m\n";
    if ($padding) $output .= "\e[0;41m" . str_pad(' ', $length) . "\e[0m\n";

    return $output;
}

function success($string = '') {
    return "\e[0;32m" . $string . "\e[0m\n";
}

function help_text()
{
    return <<<EOT

\033[1;34mLavaLust CLI Code Generator\033[0m
Usage: \033[1;33mphp cli.php make:{type} Name\033[0m

Available types and usage examples:

  \033[1;32mcontroller\033[0m   → Creates a controller in app/controllers
    Example: php cli.php make:controller Dashboard

  \033[1;32mmodel\033[0m        → Creates a model in app/models
    Example: php cli.php make:model Blog/PostModel

  \033[1;32mhelper\033[0m       → Creates a helper in app/helpers (adds _helper suffix)
    Example: php cli.php make:helper text

  \033[1;32mlibrary\033[0m      → Creates a class in app/libraries
    Example: php cli.php make:library PDF

  \033[1;32mview\033[0m         → Creates a .php view in app/views with HTML boilerplate
    Example: php cli.php make:view homepage

  \033[1;32mlanguage\033[0m     → Creates a language file in app/language with default content
    Example: php cli.php make:language tag-PH

  \033[1;32mconfig\033[0m       → Creates a config file in app/config
    Example: php cli.php make:config auth

EOT;
}
