<?php

namespace Apto1\TranslateScrapper;

class Dictionary
{

    use AppTrait;

    private string $language;
    private array $dictionary;
    private array $result = [];

    public function __construct($language = 'en')
    {

        $start = microtime(true);

        $this->language = $language;
        $this->dictionary = json_decode(
            file_get_contents(
                __DIR__ . '/../dictionary/'.$this->language.'.json')
            ,
            true
        );

        $this->performance['parse'] = microtime(true) - $start;
    }

    /**
     * @return mixed|string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array|mixed
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    public function search($string)
    {

        $start = microtime(true);

        $sanitizedString = $this->sanitize($string);

        foreach ($this->dictionary as $id => $content) {

            if (strpos($content, $sanitizedString) !== false) {

                $this->result[] = $id;
            }
        }

        $this->performance['search'] = microtime(true) - $start;
    }
}