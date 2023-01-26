<?php

namespace modules\web\twig;

use Craft;
use craft\elements\Entry;
use craft\fields\Assets;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension
 */
class LeanEntry extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('leanEntry', function($entry) {
                return $entry;
            }),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('lean', function(array | Entry $value) {
                if (!is_array($value)) {
                    return $this->transformEntry($value);
                }
                return array_map(function($entry) {
                    return $this->transformEntry($entry);
                }, $value);
            }),
        ];
    }

    private function transformEntry(Entry $entry): array {
        $customFields = $entry->getFieldLayout()->getCustomFields();
        $leanEntry = [
            "title" => $entry->title
        ];
        foreach ($customFields as $customField) {
            $field = Craft::$app->fields->getFieldById($customField->id);
            if ($field instanceof Assets) {
                $assets = $entry->getFieldValue($field->handle)->all();
                $leanEntry[$field->handle] = array_map(function($asset) {
                    return [
                        "title" => $asset->title,
                        "url" => $asset->getUrl()
                    ];
                }, $assets);
            } else {
                $leanEntry[$field->handle] = $entry->getFieldValue($field->handle);
            }
        }
        return $leanEntry;
    }

    public function getTests()
    {
        // Define custom Twig tests
        // (see https://twig.symfony.com/doc/3.x/advanced.html#tests)
        return [
            new TwigTest('passwordy', function($string) {
                $insecureChars = ['a', 'e', 'i', 'o', 's'];
                foreach ($insecureChars as $char) {
                    if (str_contains($string, $char)) {
                        return false;
                    }
                }
                return true;
            }),
            // ...
        ];
    }
}
