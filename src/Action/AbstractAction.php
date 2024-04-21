<?php

namespace Ntfy\Action;

/**
 * Base class for button actions
 *
 * @see https://ntfy.sh/docs/publish/#action-buttons
 */
abstract class AbstractAction
{
    /** @var string $type Button action type */
    protected string $type = '';

    /** @var string $label Button label */
    protected string $label = '';

    /** @var bool $clear Notification clear status */
    protected bool $clear = false;

    /**
     * Get action as an array
     *
     * @return array<string, mixed>
     */
    final public function get(): array
    {
        return $this->generate();
    }

    /**
     * Set button label
     *
     * @param string $label Button label
     */
    final public function label(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Enable clearing notification after action button is tapped
     */
    final public function enableNoteClear(): void
    {
        $this->clear = true;
    }

    /**
     * Generate array with action button parameters
     *
     * @return array<string, mixed>
     */
    protected function generate(): array
    {
        $action = [];
        $action['action'] = $this->type;
        $action['label'] = $this->label;
        $action['clear'] = $this->clear;

        return $action;
    }
}
