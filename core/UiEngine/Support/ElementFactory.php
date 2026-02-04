<?php

namespace Core\UiEngine\Support;

use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Elements\Element;
use Core\UiEngine\Elements\FormElement;
use Core\UiEngine\Elements\ContainerElement;
use Core\UiEngine\Elements\Form\Input;
use Core\UiEngine\Elements\Form\Select;
use Core\UiEngine\Elements\Form\Checkbox;
use Core\UiEngine\Elements\Form\Radio;
use Core\UiEngine\Elements\Form\Textarea;
use Core\UiEngine\Elements\Form\Button;
use Core\UiEngine\Elements\Form\FileInput;
use Core\UiEngine\Elements\Form\Hidden;
use Core\UiEngine\Elements\Form\Form;
use Core\UiEngine\Elements\Form\SwitchElement;
use Core\UiEngine\Elements\Display\Alert;
use Core\UiEngine\Elements\Display\Badge;
use Core\UiEngine\Elements\Display\Card;
use Core\UiEngine\Elements\Display\Modal;
use Core\UiEngine\Elements\Display\Tabs;
use Core\UiEngine\Elements\Display\Accordion;
use Core\UiEngine\Elements\Display\Progress;
use Core\UiEngine\Elements\Display\Table;
use Core\UiEngine\Elements\Layout\Row;
use Core\UiEngine\Elements\Layout\Column;
use Core\UiEngine\Elements\Layout\Container;
use Core\UiEngine\Elements\Layout\Divider;
use Core\UiEngine\Elements\Html;
use Core\UiEngine\Elements\RawHtml;
use Core\UiEngine\Elements\Display\Image;
use InvalidArgumentException;

/**
 * ElementFactory - Creates UI elements from configuration arrays
 *
 * Provides a central registry for element types and factory methods
 * for creating elements from configuration.
 */
class ElementFactory
{
    /**
     * Registered element types
     *
     * @var array<string, class-string<ElementInterface>>
     */
    protected static array $types = [];

    /**
     * Whether the factory has been initialized
     *
     * @var bool
     */
    protected static bool $initialized = false;

    /**
     * Initialize the factory with built-in types
     *
     * @return void
     */
    public static function initialize(): void
    {
        if (static::$initialized) {
            return;
        }

        // Form elements
        static::register('input', Input::class);
        static::register('select', Select::class);
        static::register('checkbox', Checkbox::class);
        static::register('radio', Radio::class);
        static::register('textarea', Textarea::class);
        static::register('button', Button::class);
        static::register('file', FileInput::class);
        static::register('hidden', Hidden::class);
        static::register('form', Form::class);
        static::register('switch', SwitchElement::class);

        // Display elements
        static::register('alert', Alert::class);
        static::register('badge', Badge::class);
        static::register('card', Card::class);
        static::register('modal', Modal::class);
        static::register('tabs', Tabs::class);
        static::register('accordion', Accordion::class);
        static::register('progress', Progress::class);
        static::register('table', Table::class);

        // Layout elements
        static::register('row', Row::class);
        static::register('column', Column::class);
        static::register('col', Column::class); // Alias
        static::register('container', Container::class);
        static::register('divider', Divider::class);

        // HTML elements
        static::register('html', Html::class);
        static::register('rawhtml', RawHtml::class);
        static::register('image', Image::class);
        static::register('img', Image::class); // Alias

        static::$initialized = true;
    }

    /**
     * Register an element type
     *
     * @param string $type Type identifier
     * @param class-string<ElementInterface> $class Element class
     * @return void
     */
    public static function register(string $type, string $class): void
    {
        static::$types[$type] = $class;
    }

    /**
     * Unregister an element type
     *
     * @param string $type
     * @return void
     */
    public static function unregister(string $type): void
    {
        unset(static::$types[$type]);
    }

    /**
     * Check if a type is registered
     *
     * @param string $type
     * @return bool
     */
    public static function hasType(string $type): bool
    {
        static::initialize();
        return isset(static::$types[$type]);
    }

    /**
     * Get the class for a type
     *
     * @param string $type
     * @return class-string<ElementInterface>|null
     */
    public static function getClass(string $type): ?string
    {
        static::initialize();
        return static::$types[$type] ?? null;
    }

    /**
     * Get all registered types
     *
     * @return array<string, class-string<ElementInterface>>
     */
    public static function getTypes(): array
    {
        static::initialize();
        return static::$types;
    }

    /**
     * Create an element from configuration
     *
     * @param array $config Configuration array with 'type' key
     * @return ElementInterface
     * @throws InvalidArgumentException
     */
    public static function create(array $config): ElementInterface
    {
        static::initialize();

        if (!isset($config['type'])) {
            throw new InvalidArgumentException('Element config must include a "type" key');
        }

        $type = $config['type'];

        if (!isset(static::$types[$type])) {
            throw new InvalidArgumentException("Unknown element type: {$type}");
        }

        $class = static::$types[$type];

        return $class::make($config);
    }

    /**
     * Create multiple elements from configuration array
     *
     * @param array<array> $configs Array of configuration arrays
     * @return array<ElementInterface>
     */
    public static function createMany(array $configs): array
    {
        return array_map(
            fn($config) => static::create($config),
            $configs
        );
    }

    /**
     * Create an element from JSON string
     *
     * @param string $json JSON configuration
     * @return ElementInterface
     * @throws InvalidArgumentException
     */
    public static function createFromJson(string $json): ElementInterface
    {
        $config = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON: ' . json_last_error_msg());
        }

        return static::create($config);
    }

    /**
     * Create a form with children from config
     *
     * @param array $config Form configuration with 'children' array
     * @return Form
     */
    public static function createForm(array $config): Form
    {
        $config['type'] = 'form';
        return static::create($config);
    }

    /**
     * Create a row with columns from simplified config
     *
     * @param array<array> $columns Column configurations
     * @param array $rowConfig Optional row configuration
     * @return Row
     */
    public static function createRow(array $columns, array $rowConfig = []): Row
    {
        $rowConfig['type'] = 'row';
        $rowConfig['children'] = $columns;

        return static::create($rowConfig);
    }

    /**
     * Create a card with content
     *
     * @param string $title Card title
     * @param array $children Child elements
     * @param array $config Additional card configuration
     * @return Card
     */
    public static function createCard(string $title, array $children = [], array $config = []): Card
    {
        $config['type'] = 'card';
        $config['title'] = $title;
        $config['children'] = $children;

        return static::create($config);
    }

    /**
     * Alias for create
     *
     * @param array $config
     * @return ElementInterface
     */
    public static function make(array $config): ElementInterface
    {
        return static::create($config);
    }

    /**
     * Clear all registered types (for testing)
     *
     * @return void
     */
    public static function reset(): void
    {
        static::$types = [];
        static::$initialized = false;
    }
}
