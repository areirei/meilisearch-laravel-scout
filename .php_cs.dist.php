<?php

declare(strict_types=1);

$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__.DIRECTORY_SEPARATOR.'src')
    ->in(__DIR__.DIRECTORY_SEPARATOR.'tests')
    ->append(['.php_cs.dist']);

$rules = [
    '@Symfony' => true,
];
$config = new PhpCsFixer\Config();

return $config->setRules($rules)
    ->setFinder($finder);
