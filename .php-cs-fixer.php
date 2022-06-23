<?php
 
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('somedir')
;
 
$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=' => 'align_single_space'
            ]
            ],
    ])
    ->setFinder($finder)
;