<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([__DIR__]) // Make sure a directory is set here
    ->exclude(['vendor', 'storage', 'bootstrap/cache']); // Exclude unnecessary folders

return (new Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);
