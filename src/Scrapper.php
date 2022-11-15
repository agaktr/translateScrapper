<?php

namespace Apto1\TranslateScrapper;

use DOMDocument;

class Scrapper
{

    use AppTrait;

    private array $urls;
    private array $urlContent = [];
    private array $scrappedContent = [];
    private array $files = [];

    public function __construct(array $urls = [])
    {
        $this->urls = $urls;

        $this->get();
        $this->scrap();
        $this->save();
    }

    /**
     * @return array
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * @return array
     */
    public function getUrlContent(): array
    {
        return $this->urlContent;
    }

    /**
     * @return array
     */
    public function getScrappedContent(): array
    {
        return $this->scrappedContent;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    private function get()
    {

        $start = microtime(true);

        // array of curl handles
        $multiCurl = array();

        // multi handle
        $mh = curl_multi_init();

        foreach ($this->urls as $id => $languages) {
            foreach ($languages as $language => $url) {
                $multiCurl[$id][$language] = curl_init();
                curl_setopt($multiCurl[$id][$language], CURLOPT_URL, $url);
                curl_setopt($multiCurl[$id][$language], CURLOPT_HEADER, 0);
                curl_setopt($multiCurl[$id][$language], CURLOPT_RETURNTRANSFER, 1);
                curl_multi_add_handle($mh, $multiCurl[$id][$language]);
            }
        }

        $index=null;
        do {
            curl_multi_exec($mh,$index);
        } while($index > 0);

        // get content and remove handles
        foreach($multiCurl as $id => $languages) {
            foreach ($languages as $language => $ch) {
                $this->urlContent[$id][$language] = curl_multi_getcontent($ch);
                curl_multi_remove_handle($mh, $ch);
            }
        }

        // close
        curl_multi_close($mh);

        $this->performance['curl'] = microtime(true) - $start;
    }

    private function scrap()
    {

        $start = microtime(true);

        foreach ($this->urlContent as $id => $languages) {
            foreach ($languages as $language => $content) {

                $dom = new DomDocument();
                @$dom->loadHTML($content);

                $textContent = $dom->getElementById('pageContent')->textContent;

                $sanitizedContent = $this->sanitize($textContent);

                $this->scrappedContent[$id][$language] = $sanitizedContent;
            }
        }

        $this->performance['scrap'] = microtime(true) - $start;
    }

    private function save()
    {

        $start = microtime(true);

        //check if dictionary folder exists
        if (!file_exists('dictionary')) {
            mkdir('dictionary', 0777, true);
        }

        $dictionaries = [];

        foreach ($this->scrappedContent as $id => $languages) {
            foreach ($languages as $language => $content) {

                $dictionaries[$language][$id] = $content;
            }
        }

        foreach ($dictionaries as $language => $dictionary) {
            $this->files[$language] = 'dictionary/' . $language . '.json';
            file_put_contents($this->files[$language], json_encode($dictionary));
        }

        $this->performance['save'] = microtime(true) - $start;
    }
}