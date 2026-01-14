<?php

namespace App\Patterns\Command;

class ReplaceTextCommand implements Command
{
    private Editor $editor;
    private string $newText;
    private ?string $prev = null;

    public function __construct(Editor $editor, string $newText)
    {
        $this->editor = $editor;
        $this->newText = $newText;
    }


    public function execute(): string
    {
        $this->editor->append($this->newText);
        return $this->editor->get();
    }

    public function undo(): string
    {
        $this->editor->deleteLast(strlen($this->newText));
        return $this->editor->get();
    }
}
