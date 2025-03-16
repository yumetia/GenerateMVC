<?php
// Init presets: find the files in the parent directory

$mvcStructure = [
    "Model" => ["Database.php", "GenericModel.php"],
    "View" => ["assets", "content", "css/components",
        "css/global", "css/pages",
        "js/components", "js/global", "js/pages"
    ],
    "Controller" => ["Login.php", "Register.php"],
    "Helper" => ["HtmlHelper.php", "Redirect.php"],
    "Config" => ["config.ini", "import.php", "db.sql"],
    ".htaccess",
    "autoload.php",
    "index.php"
];

// Goal:
// Check if each part of the MVC structure exists
// If not, create it

class GenerateMVC
{
    private $mvcStructure;
    private $avoidItem = [];

    public function __construct($mvcStructure)
    {
        $this->mvcStructure = $mvcStructure;
        $this->scanDirectory("../");
        $this->avoidItem = array_unique($this->avoidItem);
        $this->generate($this->avoidItem);
    }

    public function scanDirectory($directory)
    {
        $items = scandir($directory);
        $fullpath = realpath($directory);
        foreach ($items as $item) {
            if (in_array($item, [".", "..", ".git"]) ||
                $this->checkFile($item) ||
                $this->checkFolder($item)) {
                if (!in_array($item, $this->avoidItem)) {
                    $this->avoidItem[] = $item;
                }
                continue;
            }

            $path = $fullpath . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->scanDirectory($path);
            }
        }
    }

    public function generate($avoidItem)
    {
        // Create MVC struct
        foreach ($this->mvcStructure as $key => $values) {
            if (is_int($key)) {
                $this->createFile("../$values"); // standalone files
                continue;
            }

            if (!in_array($key, $avoidItem)) {
                if (!is_dir("../$key")) {
                    mkdir("../$key", 0777, true); // main dir
                }
                

                if (!is_array($values)) {
                    $values = [$values]; // Making sure $values is always an array
                }

                foreach ($values as $value) {
                    if (strpos($value, ".") !== false) {
                        $this->createFile("../$key/$value"); // files
                    } elseif (!is_dir("../$key/$value")){
                        mkdir("../$key/$value", 0777, true); // subdir
                    }
                }
            }
        }
    }

    private function createFile($filePath)
    {
        switch ($filePath) {
            case '../.htaccess':
                file_put_contents($filePath, "RewriteEngine On
# Redirect all files except existing ones to index
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]");
                break;

            case '../autoload.php':
                file_put_contents($filePath, "<?php

spl_autoload_register(function (\$class) {

    \$directories = [
        __DIR__ . '/Controller/',
        __DIR__ . '/Model/',
        __DIR__ . '/Helper/',
    ];

    foreach (\$directories as \$directory) {
        \$file = \$directory . \$class . '.php';
        if (file_exists(\$file)) {
            require_once \$file;
            return;
        }
    }

    throw new Exception('Cannot load the class: ' . \$class);
});
");
                break;

            default:
                if (!file_exists($filePath)) {
                    touch($filePath); // empty file
                }
                break;
        }
    }

    public function checkFile($item)
    {
        // Return true if we need to skip the file
        foreach ($this->mvcStructure as $files) {
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($item == $file) {
                        return true;
                    }
                }
            } elseif ($item == $files) {
                return true;
            }
        }
        return false;
    }

    public function checkFolder($item)
    {
        // Return true if we need to skip the folder
        foreach ($this->mvcStructure as $category => $files) {
            if (is_string($category) &&
                ($item == $category || $item == $files)) {
                return true;
            }
        }
        return false;
    }
}

// ----- //

(new GenerateMVC($mvcStructure));
