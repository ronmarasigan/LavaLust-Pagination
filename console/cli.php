#!/usr/bin/php -q
<?php
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('CLI only');

// Define app directory
define('APP_DIR', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);

// Get CLI arguments
if (!isset($argv[1]) || !isset($argv[2])) {
    die("Usage: php cli.php make:controller ControllerName OR php cli.php make:model Folder/ModelName\n");
}

// Parse the make type
$make_type = strtolower(str_replace('make:', '', $argv[1]));
if (!in_array($make_type, ['controller', 'model'])) {
    die("Invalid option. Use either 'make:controller' or 'make:model'\n");
}

// Determine subdirectory
$sub_dir = $make_type . 's';
$extends = ucfirst($make_type);
$input_path = $argv[2];

// Normalize path
$path_parts = explode('/', str_replace('\\', '/', $input_path));
$class_name = array_pop($path_parts);
$class_name = ucfirst($class_name); // Keep original casing
$relative_path = implode(DIRECTORY_SEPARATOR, $path_parts);
$folder_path = APP_DIR . $sub_dir . DIRECTORY_SEPARATOR . $relative_path;
$file_path = $folder_path . DIRECTORY_SEPARATOR . $class_name . '.php';

// Ensure directory exists
if (!is_dir($folder_path)) {
    mkdir($folder_path, 0777, true);
}

// Choose content template
if ($make_type === 'model') {
    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: {$class_name}
 * 
 * Automatically generated via CLI.
 */
class {$class_name} extends {$extends} {

    /**
     * Table associated with the model.
     * @var string
     */
    protected \$table = '';

    /**
     * Primary key of the table.
     * @var string
     */
    protected \$primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }
}
";
} else {
    $content = "<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class {$class_name} extends {$extends} {

    public function __construct()
    {
        parent::__construct();
    }
}
";
}

// Write file
if (!file_exists($file_path)) {
    file_put_contents($file_path, $content);
    echo success(ucfirst($make_type) . ' "' . $class_name . '" created at ' . $file_path);
} else {
    echo danger(ucfirst($make_type) . ' "' . $class_name . '" already exists.');
}

// Output helpers
function danger($string = '', $padding = true)
{
    $length = strlen($string) + 4;
    $output = '';

    if ($padding) $output .= "\e[0;41m" . str_pad(' ', $length) . "\e[0m\n";
    $output .= "\e[0;41m" . ($padding ? '  ' : '') . $string . ($padding ? '  ' : '') . "\e[0m\n";
    if ($padding) $output .= "\e[0;41m" . str_pad(' ', $length) . "\e[0m\n";

    return $output;
}

function success($string = '')
{
    return "\e[0;32m" . $string . "\e[0m\n";
}
?>
