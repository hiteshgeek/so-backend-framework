<?php

namespace Core\View\Contracts;

/**
 * Interface for class-based view composers
 *
 * View composers are callbacks that automatically inject data
 * into views when they are rendered.
 */
interface ViewComposer
{
    /**
     * Compose data for the view
     *
     * @param string $viewName The view being rendered
     * @param array $data Existing view data
     * @return array Data to merge into view
     */
    public function compose(string $viewName, array $data): array;
}
