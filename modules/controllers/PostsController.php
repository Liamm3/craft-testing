<?php

namespace modules\controllers;

use Craft;
use craft\elements\Entry;
use craft\services\Entries;
use craft\web\Controller;
use yii\web\Response;

/**
 * Posts controller
 */
class PostsController extends Controller
{
    const SECTION_NAME = 'posts';
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = self::ALLOW_ANONYMOUS_LIVE;

    /**
     * site-module/posts action
     */
    public function actionIndex(): Response
    {
        $posts = Entry::find()->section('posts')->all();
        return $this->asJson($posts);
    }
}
