<?php

namespace modules\generators;

use Craft;
use Nette\PhpGenerator\PhpNamespace;
use craft\generator\BaseGenerator;
use yii\base\Behavior as BaseBehavior;
use yii\helpers\Inflector;

/**
 * Creates a new behavior.
 */
class Behavior extends BaseGenerator
{
    private string $className;
    private string $namespace;
    private string $displayName;

    public function run(): bool
    {
        $this->className = $this->classNamePrompt('Behavior name:', [
            'required' => true,
        ]);

        $this->namespace = $this->namespacePrompt('Behavior namespace:', [
            'default' => "$this->baseNamespace\\behaviors",
        ]);

        $this->displayName = Inflector::camel2words($this->className);

        $namespace = (new PhpNamespace($this->namespace))
            ->addUse(Craft::class)
            ->addUse(BaseBehavior::class);

        $class = $this->createClass("{$this->className}Behavior", BaseBehavior::class, [
            self::CLASS_CONSTANTS => $this->constants(),
            self::CLASS_PROPERTIES => $this->properties(),
            self::CLASS_METHODS => $this->methods(),
        ]);
        $namespace->add($class);

        $class->setComment("$this->displayName behavior");

        $this->writePhpClass($namespace);

        $this->command->success("**Behavior created!**");
        return true;
    }

    private function constants(): array
    {
        // List any constants that should be copied into generated behaviors from yii\base\Behavior
        // (see `craft\generator\BaseGenerator::createClass()`)
        return [];
    }

    private function properties(): array
    {
        // List any properties that should be copied into generated behaviors from yii\base\Behavior
        // (see `craft\generator\BaseGenerator::createClass()`)
        return [
            'owner'
        ];
    }

    private function methods(): array
    {
        // List any methods that should be copied into generated behaviors from yii\base\Behavior
        // (see `craft\generator\BaseGenerator::createClass()`)
        return [];
    }
}
