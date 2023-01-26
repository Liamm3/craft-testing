<?php

namespace modules\controllers;

use Craft;
use craft\elements\Entry;
use craft\errors\ElementNotFoundException;
use craft\helpers\StringHelper;
use craft\web\Controller;
use modules\behaviors\CompanyBehavior;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Company controller
 */
class CompanyController extends Controller {
    private const SECTION_HANDLE = 'companies';
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE;
    public $enableCsrfValidation = false;

    public function actionIndex(): Response {
        $companies = Entry::find()->section(self::SECTION_HANDLE)->all();
        $transformedCompanies = array_map(function($company) {
            return $company->getLeanTransform();
        }, $companies);
        return $this->asJson($transformedCompanies);
    }

    public function actionCreate(): Response {
        try {
            $this->requireAcceptsJson();
            $this->requirePostRequest();
        } catch (BadRequestHttpException $e) {

        }
        $companyData = Craft::$app->request->getBodyParams();
        return $this->createCompanyFromJson($companyData);
    }

    private function createCompanyFromJson(array $company) {
        $section = Craft::$app->sections->getSectionByHandle(self::SECTION_HANDLE);
        $entryTypes = $section->getEntryTypes();
        $entryType = reset($entryTypes);
        $entry = new Entry([
            "sectionId" => $section->id,
            "typeId" => $entryType->id,
            "fieldLayoutId" => $entryType->fieldLayoutId,
            "authorId" => 1,
            "title" => $company["companyName"],
            "slug" => StringHelper::toKebabCase($company["companyName"]),
            "postDate" => new \DateTime(),
            "enabled" => true
        ]);
        $entry->setFieldValues([
            'email' => $company['email'],
            'latitude' => $company['latitude'],
            'longitude' => $company['longitude'],
            'postalCode' => $company['postalCode'],
            'streetName' => $company['streetName'],
            'streetNumber' => $company['streetNumber'],
            'city' => $company['city'],
            'description' => $company['description'],
        ]);
        $success = Craft::$app->elements->saveElement($entry);
        if ($success) {
            // TODO: Do not attach behavior manually; maybe use a service to get lean transform in future
            $entry->attachBehavior('companies', CompanyBehavior::class);
            return $this->asJson([
                "success" => $success,
                "company" => $entry->getLeanTransform()
            ])->setStatusCode(201);
        }
        return $this->asJson([
            "success" => $success,
            "errors" => $entry->getErrors()
        ])->setStatusCode(400);
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
        $section = Craft::$app->sections->getSectionByHandle(self::SECTION_HANDLE);
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
