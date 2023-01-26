<?php

namespace modules\behaviors;

use craft\elements\Entry;
use yii\base\Behavior;

class CompanyBehavior extends Behavior {
    /**
     * @var Entry
     */
    public $owner;

    public function getLeanTransform(): array {
        $transformedEntry = [
            "title" => $this->owner->title,
            "url" => $this->owner->url,
        ];
        $fieldLayout = $this->owner->getFieldLayout();
        $fieldLayoutFields = $fieldLayout->getCustomFields();
        foreach ($fieldLayoutFields as $fieldLayoutField) {
            $field = \Craft::$app->getFields()->getFieldById($fieldLayoutField->id);
            $transformedEntry[$field->handle] = $this->owner[$field->handle];
        }
        return $transformedEntry;
    }
}