<?php

namespace Core\UiEngine\Elements;

/**
 * RawHtml - Outputs raw HTML without wrapper tags
 *
 * Unlike Html element which wraps content in tags,
 * RawHtml outputs the HTML content directly without any wrapper.
 * Useful for inserting pre-rendered HTML into containers.
 */
class RawHtml extends Element
{
    /**
     * Element type identifier
     *
     * @var string
     */
    protected string $type = 'rawhtml';

    /**
     * Initialize element properties from configuration
     *
     * @param array $config
     * @return void
     */
    protected function initializeFromConfig(array $config): void
    {
        parent::initializeFromConfig($config);

        if (isset($config['innerHTML'])) {
            $this->content = $config['innerHTML'];
        }
    }

    /**
     * Set raw HTML content
     *
     * @param string $html
     * @return static
     */
    public function html(string $html): static
    {
        $this->content = $html;
        return $this;
    }

    /**
     * Render the raw HTML (no wrapper tags)
     *
     * @return string
     */
    public function render(): string
    {
        return $this->content ?? '';
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $config = parent::toArray();
        if ($this->content !== null) {
            $config['innerHTML'] = $this->content;
        }
        return $config;
    }
}
