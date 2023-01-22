<?php

namespace modules\controllers;

use Craft;
use craft\elements\Entry;
use craft\errors\ElementNotFoundException;
use craft\helpers\StringHelper;
use craft\web\Controller;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Company controller
 */
class CompanyController extends Controller {
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE;
    public $enableCsrfValidation = false;

    public function actionIndex(): Response {
        $companies = Entry::find()->section('companies')->all();
        $transformedCompanies = array_map(function($company) {
            return $company->getLeanTransform();
        }, $companies);
        return $this->asJson($transformedCompanies);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionUploadMock() {
        try {
            $this->requireAcceptsJson();
            $this->requirePostRequest();
        } catch (BadRequestHttpException $e) {

        }
        $companies = $this->request->getBodyParams();

        $section = Craft::$app->sections->getSectionByHandle('companies');
        $entryTypes = $section->getEntryTypes();
        $entryType = reset($entryTypes);

        foreach ($companies as $company) {
            $entry = new Entry([
                "sectionId" => $section->id,
                "typeId" => $entryType->id,
                "fieldLayoutId" => $entryType->fieldLayoutId,
                "authorId" => 1,
                "title" => $company["company_name"],
                "slug" => StringHelper::toKebabCase($company["company_name"]),
                "postDate" => new \DateTime(),
                "enabled" => true
            ]);
            $entry->setFieldValues([
                'email' => $company['email'],
                'latitude' => $company['latitude'],
                'longitude' => $company['longitude'],
                'postalCode' => $company['postal_code'],
                'streetName' => $company['street_name'],
                'streetNumber' => $company['street_number'],
                'city' => $company['city'],
                'description' => $company['description'],
            ]);
            try {
                $success = Craft::$app->elements->saveElement($entry);
            } catch (ElementNotFoundException|Exception|\Throwable $e) {
                dd($e);
            }

            if (!$success) {
                dd("Something went wrong.", $entry->getErrors());
            }
        }
    }
}
