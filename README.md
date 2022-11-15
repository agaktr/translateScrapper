To create the dictionary files ex.:
```php
/**
* The urls array of the content to be crawled
* pageId=>['en'=>'url','gr'=>'url']
*/
const URLS = [
    13 => [
        'en'	=> 'https://herema.gr/who-we-are/our-mandate/',
        'gr'	=> 'https://herema.gr/el/who-we-are/our-mandate/',
    ],
    14 => [
        'en'	=> 'https://herema.gr/who-we-are/our-transformation/',
        'gr'	=> 'https://herema.gr/el/who-we-are/our-transformation/',
    ],
];

/**
* Just initialize the class and everything will be done automatically
*/
$scrapper = new Scrapper(URLS);

/**
* There are some available methods for debugging
*/
//The URLS array
$scrapper->getUrls();
//The dictionary array
$scrapper->getFiles();
//Performance timings for curl,parsing and writing
$scrapper->getPerformance();
//The scrapped sanitzed content
$scrapper->getScrappedContent();
//The original content
$scrapper->getUrlContent();
```

To search the dictionary files ex.:
```php
/**
* Create a new instance of the Search class
* by passing the language
* PS. Leave blank contructor for en languange
*/
$dictionary = new Dictionary('gr');

/**
* Search for a word using the ->search() method
*/
$dictionary->search('Με πυξίδα την πεποίθηση ότι η εταιρεία');

/**
* Retrieve the results using the ->getResults() method
*/
$res = $dictionary->getResult();

/**
* There are some available methods for debugging
*/
//Performance timings for parsing and searching
$dictionary->getPerformance();
//The dictionary array
$dictionary->getDictionary()
```