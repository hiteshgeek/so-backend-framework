<?php

namespace Core\UiEngine;

use Core\UiEngine\Contracts\ElementInterface;
use Core\UiEngine\Support\ElementFactory;
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
use Core\UiEngine\Elements\Form\Slider;
use Core\UiEngine\Elements\Form\Autocomplete;
use Core\UiEngine\Elements\Form\Dropzone;
use Core\UiEngine\Elements\Display\Alert;
use Core\UiEngine\Elements\Display\Avatar;
use Core\UiEngine\Elements\Display\Badge;
use Core\UiEngine\Elements\Display\Card;
use Core\UiEngine\Elements\Display\Modal;
use Core\UiEngine\Elements\Display\Skeleton;
use Core\UiEngine\Elements\Display\Tabs;
use Core\UiEngine\Elements\Display\Accordion;
use Core\UiEngine\Elements\Display\Progress;
use Core\UiEngine\Elements\Display\Rating;
use Core\UiEngine\Elements\Display\Table;
use Core\UiEngine\Elements\Layout\Row;
use Core\UiEngine\Elements\Layout\Column;
use Core\UiEngine\Elements\Layout\Container;
use Core\UiEngine\Elements\Layout\Divider;
use Core\UiEngine\Elements\Html;
use Core\UiEngine\Elements\Display\Image;
use Core\UiEngine\Validation\ClientRuleExporter;

/**
 * UiEngine - Main factory class for creating UI elements
 *
 * Provides a convenient API for creating UI elements either
 * programmatically or from configuration arrays/JSON.
 */
class UiEngine
{
    /**
     * Current CSRF token (set globally for all forms)
     *
     * @var string|null
     */
    protected static ?string $csrfToken = null;

    /**
     * Current CSRF field name
     *
     * @var string
     */
    protected static string $csrfFieldName = '_token';

    /**
     * Global configuration options
     *
     * @var array
     */
    protected static array $config = [
        'defaultInputSize' => 'md',
        'defaultButtonVariant' => 'primary',
        'defaultAlertDismissible' => false,
        'useInlineEvents' => false,
    ];

    // ==================
    // Configuration
    // ==================

    /**
     * Set global configuration
     *
     * @param array $config
     * @return void
     */
    public static function configure(array $config): void
    {
        static::$config = array_merge(static::$config, $config);
    }

    /**
     * Get configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getConfig(string $key, mixed $default = null): mixed
    {
        return static::$config[$key] ?? $default;
    }

    /**
     * Set CSRF token for forms
     *
     * @param string $token
     * @param string $fieldName
     * @return void
     */
    public static function setCsrfToken(string $token, string $fieldName = '_token'): void
    {
        static::$csrfToken = $token;
        static::$csrfFieldName = $fieldName;
    }

    /**
     * Get CSRF token
     *
     * @return string|null
     */
    public static function getCsrfToken(): ?string
    {
        return static::$csrfToken;
    }

    // ==================
    // Form Elements
    // ==================

    /**
     * Create a text input
     *
     * @param string|null $name
     * @return Input
     */
    public static function input(?string $name = null): Input
    {
        $input = Input::make();

        if ($name !== null) {
            $input->name($name);
        }

        return $input;
    }

    /**
     * Create an email input
     *
     * @param string|null $name
     * @return Input
     */
    public static function email(?string $name = null): Input
    {
        return static::input($name)->email();
    }

    /**
     * Create a password input
     *
     * @param string|null $name
     * @return Input
     */
    public static function password(?string $name = null): Input
    {
        return static::input($name)->password();
    }

    /**
     * Create a number input
     *
     * @param string|null $name
     * @return Input
     */
    public static function number(?string $name = null): Input
    {
        return static::input($name)->number();
    }

    /**
     * Create a date input
     *
     * @param string|null $name
     * @return Input
     */
    public static function date(?string $name = null): Input
    {
        return static::input($name)->date();
    }

    /**
     * Create a select dropdown
     *
     * @param string|null $name
     * @return Select
     */
    public static function select(?string $name = null): Select
    {
        $select = Select::make();

        if ($name !== null) {
            $select->name($name);
        }

        return $select;
    }

    /**
     * Create a checkbox
     *
     * @param string|null $name
     * @return Checkbox
     */
    public static function checkbox(?string $name = null): Checkbox
    {
        $checkbox = Checkbox::make();

        if ($name !== null) {
            $checkbox->name($name);
        }

        return $checkbox;
    }

    /**
     * Create a radio group
     *
     * @param string|null $name
     * @return Radio
     */
    public static function radio(?string $name = null): Radio
    {
        $radio = Radio::make();

        if ($name !== null) {
            $radio->name($name);
        }

        return $radio;
    }

    /**
     * Create a textarea
     *
     * @param string|null $name
     * @return Textarea
     */
    public static function textarea(?string $name = null): Textarea
    {
        $textarea = Textarea::make();

        if ($name !== null) {
            $textarea->name($name);
        }

        return $textarea;
    }

    /**
     * Create a button
     *
     * @param string|null $text
     * @return Button
     */
    public static function button(?string $text = null): Button
    {
        $button = Button::make();

        if ($text !== null) {
            $button->text($text);
        }

        return $button;
    }

    /**
     * Create a submit button
     *
     * @param string $text
     * @return Button
     */
    public static function submit(string $text = 'Submit'): Button
    {
        return static::button($text)->submit()->primary();
    }

    /**
     * Create a file input
     *
     * @param string|null $name
     * @return FileInput
     */
    public static function file(?string $name = null): FileInput
    {
        $file = FileInput::make();

        if ($name !== null) {
            $file->name($name);
        }

        return $file;
    }

    /**
     * Create a slider (range input)
     *
     * @param string|null $name
     * @return Slider
     */
    public static function slider(?string $name = null): Slider
    {
        $slider = Slider::make();

        if ($name !== null) {
            $slider->name($name);
        }

        return $slider;
    }

    /**
     * Create a hidden input
     *
     * @param string|null $name
     * @param mixed $value
     * @return Hidden
     */
    public static function hidden(?string $name = null, mixed $value = null): Hidden
    {
        $hidden = Hidden::make();

        if ($name !== null) {
            $hidden->name($name);
        }

        if ($value !== null) {
            $hidden->value($value);
        }

        return $hidden;
    }

    /**
     * Create an autocomplete input
     *
     * @param string|null $name
     * @return Autocomplete
     */
    public static function autocomplete(?string $name = null): Autocomplete
    {
        $autocomplete = Autocomplete::make();

        if ($name !== null) {
            $autocomplete->name($name);
        }

        return $autocomplete;
    }

    /**
     * Create a dropzone file upload
     *
     * @param string|null $name
     * @return Dropzone
     */
    public static function dropzone(?string $name = null): Dropzone
    {
        $dropzone = Dropzone::make();

        if ($name !== null) {
            $dropzone->name($name);
        }

        return $dropzone;
    }

    /**
     * Create a switch element
     *
     * @param string|null $name
     * @return SwitchElement
     */
    public static function switch(?string $name = null): SwitchElement
    {
        $switch = SwitchElement::make();

        if ($name !== null) {
            $switch->name($name);
        }

        return $switch;
    }

    /**
     * Create a form
     *
     * @param string|null $action
     * @return Form
     */
    public static function form(?string $action = null): Form
    {
        $form = Form::make();

        if ($action !== null) {
            $form->action($action);
        }

        // Auto-set CSRF token if available
        if (static::$csrfToken !== null) {
            $form->csrf(static::$csrfToken, static::$csrfFieldName);
        }

        return $form;
    }

    // ==================
    // Display Elements
    // ==================

    /**
     * Create an alert
     *
     * @param string|null $message
     * @return Alert
     */
    public static function alert(?string $message = null): Alert
    {
        $alert = Alert::make();

        if ($message !== null) {
            $alert->message($message);
        }

        if (static::$config['defaultAlertDismissible']) {
            $alert->dismissible();
        }

        return $alert;
    }

    /**
     * Create a success alert
     *
     * @param string $message
     * @return Alert
     */
    public static function success(string $message): Alert
    {
        return static::alert($message)->success();
    }

    /**
     * Create an error/danger alert
     *
     * @param string $message
     * @return Alert
     */
    public static function error(string $message): Alert
    {
        return static::alert($message)->danger();
    }

    /**
     * Create a warning alert
     *
     * @param string $message
     * @return Alert
     */
    public static function warning(string $message): Alert
    {
        return static::alert($message)->warning();
    }

    /**
     * Create an info alert
     *
     * @param string $message
     * @return Alert
     */
    public static function info(string $message): Alert
    {
        return static::alert($message)->info();
    }

    /**
     * Create an avatar
     *
     * @param string|null $image
     * @return Avatar
     */
    public static function avatar(?string $image = null): Avatar
    {
        $avatar = Avatar::make();

        if ($image !== null) {
            $avatar->image($image);
        }

        return $avatar;
    }

    /**
     * Create a badge
     *
     * @param string|null $text
     * @return Badge
     */
    public static function badge(?string $text = null): Badge
    {
        $badge = Badge::make();

        if ($text !== null) {
            $badge->text($text);
        }

        return $badge;
    }

    /**
     * Create a card
     *
     * @param string|null $title
     * @return Card
     */
    public static function card(?string $title = null): Card
    {
        $card = Card::make();

        if ($title !== null) {
            $card->title($title);
        }

        return $card;
    }

    /**
     * Create a skeleton loader
     *
     * @param string $shape
     * @return Skeleton
     */
    public static function skeleton(string $shape = 'text'): Skeleton
    {
        return Skeleton::make()->shape($shape);
    }

    /**
     * Create a modal
     *
     * @param string|null $id
     * @return Modal
     */
    public static function modal(?string $id = null): Modal
    {
        $modal = Modal::make();

        if ($id !== null) {
            $modal->id($id);
        }

        return $modal;
    }

    /**
     * Create tabs
     *
     * @return Tabs
     */
    public static function tabs(): Tabs
    {
        return Tabs::make();
    }

    /**
     * Create an accordion
     *
     * @return Accordion
     */
    public static function accordion(): Accordion
    {
        return Accordion::make();
    }

    /**
     * Create a progress bar
     *
     * @param int|float $value
     * @return Progress
     */
    public static function progress(int|float $value = 0): Progress
    {
        return Progress::make()->value($value);
    }

    /**
     * Create a rating element
     *
     * @param float $value
     * @return Rating
     */
    public static function rating(float $value = 0): Rating
    {
        return Rating::make()->value($value);
    }

    /**
     * Create a table
     *
     * @param array $columns
     * @return Table
     */
    public static function table(array $columns = []): Table
    {
        $table = Table::make();

        if (!empty($columns)) {
            $table->columns($columns);
        }

        return $table;
    }

    // ==================
    // Layout Elements
    // ==================

    /**
     * Create a row
     *
     * @return Row
     */
    public static function row(): Row
    {
        return Row::make();
    }

    /**
     * Create a column
     *
     * @param int|string|null $size
     * @return Column
     */
    public static function col(int|string|null $size = null): Column
    {
        $col = Column::make();

        if ($size !== null) {
            $col->size($size);
        }

        return $col;
    }

    /**
     * Alias for col()
     *
     * @param int|string|null $size
     * @return Column
     */
    public static function column(int|string|null $size = null): Column
    {
        return static::col($size);
    }

    /**
     * Create a container
     *
     * @param bool $fluid
     * @return Container
     */
    public static function container(bool $fluid = false): Container
    {
        $container = Container::make();

        if ($fluid) {
            $container->fluid();
        }

        return $container;
    }

    /**
     * Create a divider
     *
     * @param string|null $text
     * @return Divider
     */
    public static function divider(?string $text = null): Divider
    {
        $divider = Divider::make();

        if ($text !== null) {
            $divider->text($text);
        }

        return $divider;
    }

    // ==================
    // HTML Elements
    // ==================

    /**
     * Create a generic HTML element
     *
     * @param string $tag
     * @param string|null $content
     * @return Html
     */
    public static function html(string $tag = 'div', ?string $content = null): Html
    {
        $element = Html::make();
        $element->tag($tag);

        if ($content !== null) {
            $element->text($content);
        }

        return $element;
    }

    /**
     * Create a div element
     *
     * @param string|null $content
     * @return Html
     */
    public static function div(?string $content = null): Html
    {
        return static::html('div', $content);
    }

    /**
     * Create a span element
     *
     * @param string|null $content
     * @return Html
     */
    public static function span(?string $content = null): Html
    {
        return static::html('span', $content);
    }

    /**
     * Create a paragraph element
     *
     * @param string|null $content
     * @return Html
     */
    public static function p(?string $content = null): Html
    {
        return static::html('p', $content);
    }

    /**
     * Create an anchor/link element
     *
     * @param string|null $href
     * @param string|null $text
     * @return Html
     */
    public static function a(?string $href = null, ?string $text = null): Html
    {
        $element = static::html('a', $text);

        if ($href !== null) {
            $element->href($href);
        }

        return $element;
    }

    /**
     * Create an image element
     *
     * @param string|null $src
     * @param string|null $alt
     * @return Image
     */
    public static function img(?string $src = null, ?string $alt = null): Image
    {
        $image = Image::make();

        if ($src !== null) {
            $image->src($src);
        }

        if ($alt !== null) {
            $image->alt($alt);
        }

        return $image;
    }

    /**
     * Alias for img()
     *
     * @param string|null $src
     * @param string|null $alt
     * @return Image
     */
    public static function image(?string $src = null, ?string $alt = null): Image
    {
        return static::img($src, $alt);
    }

    // ==================
    // Factory Methods
    // ==================

    /**
     * Create element from configuration array
     *
     * @param array $config
     * @return ElementInterface
     */
    public static function fromConfig(array $config): ElementInterface
    {
        return ElementFactory::create($config);
    }

    /**
     * Create element from JSON string
     *
     * @param string $json
     * @return ElementInterface
     */
    public static function fromJson(string $json): ElementInterface
    {
        return ElementFactory::createFromJson($json);
    }

    /**
     * Create multiple elements from configuration array
     *
     * @param array $configs
     * @return array<ElementInterface>
     */
    public static function fromConfigMany(array $configs): array
    {
        return ElementFactory::createMany($configs);
    }

    /**
     * Alias for fromConfig()
     *
     * @param array $config
     * @return ElementInterface
     */
    public static function make(array $config): ElementInterface
    {
        return static::fromConfig($config);
    }

    // ==================
    // Rendering Helpers
    // ==================

    /**
     * Render multiple elements
     *
     * @param array<ElementInterface> $elements
     * @return string
     */
    public static function render(array $elements): string
    {
        $html = '';

        foreach ($elements as $element) {
            if ($element instanceof ElementInterface) {
                $html .= $element->render();
            }
        }

        return $html;
    }

    /**
     * Render elements from config
     *
     * @param array $configs
     * @return string
     */
    public static function renderFromConfig(array $configs): string
    {
        return static::render(static::fromConfigMany($configs));
    }

    // ==================
    // Validation Export
    // ==================

    /**
     * Export validation rules for JavaScript
     *
     * @param array<ElementInterface>|Form $elements
     * @return array
     */
    public static function exportValidation(array|Form $elements): array
    {
        if ($elements instanceof Form) {
            return $elements->exportValidation();
        }

        return ClientRuleExporter::export($elements);
    }

    /**
     * Export validation rules as script tag
     *
     * @param array<ElementInterface>|Form $elements
     * @param string|null $formId
     * @return string
     */
    public static function exportValidationScript(array|Form $elements, ?string $formId = null): string
    {
        if ($elements instanceof Form) {
            return $elements->exportValidationScript();
        }

        return ClientRuleExporter::toScript($elements, $formId);
    }

    // ==================
    // Quick Builders
    // ==================

    /**
     * Create a form with fields from config
     *
     * @param string $action
     * @param array $fields Field configurations
     * @param string $submitText
     * @return Form
     */
    public static function quickForm(string $action, array $fields, string $submitText = 'Submit'): Form
    {
        $form = static::form($action);

        foreach ($fields as $field) {
            $form->add(ElementFactory::create($field));
        }

        $form->add(static::submit($submitText));

        return $form;
    }

    /**
     * Create a row with columns
     *
     * @param array $columns Array of column sizes or [size => content] pairs
     * @return Row
     */
    public static function quickRow(array $columns): Row
    {
        $row = static::row();

        foreach ($columns as $key => $value) {
            if (is_numeric($key)) {
                // Just size: [6, 6]
                $row->col($value);
            } elseif (is_array($value)) {
                // Size with content: [6 => [...elements]]
                $col = static::col($key);
                foreach ($value as $element) {
                    if ($element instanceof ElementInterface) {
                        $col->add($element);
                    } elseif (is_array($element)) {
                        $col->add(ElementFactory::create($element));
                    }
                }
                $row->add($col);
            }
        }

        return $row;
    }

    /**
     * Create a card with content
     *
     * @param string $title
     * @param array $content Content elements
     * @param array $options Card options
     * @return Card
     */
    public static function quickCard(string $title, array $content, array $options = []): Card
    {
        $card = static::card($title);

        foreach ($content as $element) {
            if ($element instanceof ElementInterface) {
                $card->add($element);
            } elseif (is_array($element)) {
                $card->add(ElementFactory::create($element));
            }
        }

        // Apply options
        if ($options['shadow'] ?? false) {
            $card->shadow($options['shadowSize'] ?? 'md');
        }

        if (isset($options['variant'])) {
            $card->variant($options['variant']);
        }

        if (isset($options['footer'])) {
            $card->footer($options['footer']);
        }

        return $card;
    }

    /**
     * Create a modal with content
     *
     * @param string $id
     * @param string $title
     * @param array $content
     * @param array $buttons
     * @return Modal
     */
    public static function quickModal(string $id, string $title, array $content, array $buttons = []): Modal
    {
        $modal = static::modal($id)->title($title);

        foreach ($content as $element) {
            if ($element instanceof ElementInterface) {
                $modal->add($element);
            } elseif (is_array($element)) {
                $modal->add(ElementFactory::create($element));
            }
        }

        foreach ($buttons as $button) {
            $modal->addButton(
                $button['text'] ?? 'Button',
                $button['variant'] ?? 'secondary',
                $button['dismiss'] ?? false,
                $button['attributes'] ?? []
            );
        }

        return $modal;
    }

    // ==================
    // Element Registration
    // ==================

    /**
     * Register a custom element type
     *
     * @param string $type
     * @param string $class
     * @return void
     */
    public static function registerElement(string $type, string $class): void
    {
        ElementFactory::register($type, $class);
    }

    /**
     * Check if an element type is registered
     *
     * @param string $type
     * @return bool
     */
    public static function hasElement(string $type): bool
    {
        return ElementFactory::hasType($type);
    }

    /**
     * Get all registered element types
     *
     * @return array
     */
    public static function getElementTypes(): array
    {
        return ElementFactory::getTypes();
    }
}
