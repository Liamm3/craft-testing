<?php

namespace modules;

use Craft;
use craft\base\Model;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use modules\behaviors\CompanyBehavior;
use yii\base\Event;
use yii\base\Module as BaseModule;

/**
 * site-module module
 *
 * @method static Module getInstance()
 */
class Module extends BaseModule {
    const BEHAVIORS = [
        "companies" => CompanyBehavior::class,
    ];

    public function init()
    {
        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->request->isConsoleRequest) {
            $this->controllerNamespace = 'modules\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\controllers';
        }

        Event::on(
            Entry::class,
            Entry::EVENT_DEFINE_BEHAVIORS,
            function(DefineBehaviorsEvent $event) {
                if (!$event->sender->id) {
                    return;
                }

                $sectionHandle = $event->sender->section->handle;

                if (array_key_exists($sectionHandle, self::BEHAVIORS)) {
                    $event->sender->attachBehaviors([
                        self::BEHAVIORS[$sectionHandle]
                    ]);
                }
            }
        );

        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
            // ...
        });
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/4.x/extend/events.html to get started)
    }
}
