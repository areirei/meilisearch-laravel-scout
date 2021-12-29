<?php

declare(strict_types=1);

$header = <<<'EOF'
This file is part of PHP CS Fixer.
(c) Fabien Potencier <fabien@symfony.com>
    Dariusz Rumiński <dariusz.ruminski@gmail.com>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__.DIRECTORY_SEPARATOR.'src')
    ->in(__DIR__.DIRECTORY_SEPARATOR.'tests');
    // ->append(['.php_cs.dist.php']);

$rules = [
    '@Symfony' => true,
];
$config = new \PhpCsFixer\Config();
$config->setRules($rules)
    ->setFinder($finder);

if (false !== getenv('FABBOT_IO')) {
    try {
        \PhpCsFixer\FixerFactory::create()
            ->registerBuiltInFixers()
            ->registerCustomFixers($config->getCustomFixers())
            ->useRuleSet(new \PhpCsFixer\RuleSet($config->getRules()))
        ;
    } catch (\PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
        $config->setRules([]);
    } catch (UnexpectedValueException $e) {
        $config->setRules([]);
    } catch (InvalidArgumentException $e) {
        $config->setRules([]);
    }
}
return $config;
