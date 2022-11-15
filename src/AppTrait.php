<?php

namespace Apto1\TranslateScrapper;


trait AppTrait
{

    private array $performance = [];

    /**
     * @return array
     */
    public function getPerformance(): array
    {
        return $this->performance;
    }

    public function sanitize(string $string, $enc = "utf-8"): string
    {

        return strtr(
                mb_strtoupper(
                    preg_replace(
                        '/\s+/',
                        ' ',
                        $string
                    ),
                    $enc
                ),
                array('Ά' => 'Α', 'Έ' => 'Ε', 'Ί' => 'Ι', 'Ή' => 'Η', 'Ύ' => 'Υ',
                    'Ό' => 'Ο', 'Ώ' => 'Ω', 'A' => 'A', 'A' => 'A', 'A' => 'A', 'A' => 'A',
                    'Y' => 'Y','ΐ' => 'Ϊ'
                )
            );
    }
}