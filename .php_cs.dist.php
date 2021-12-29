<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$rules = [
    '@Symfony' => true,
];
$config = new PhpCsFixer\Config();
$config->setRules($rules)
    ->setFinder($finder)
;

return $config;
