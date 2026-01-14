<?php

namespace App\Patterns\Command;

use function Pest\Laravel\get;

class AppendTextCommand implements Command
{
    private Editor $editor;
    private string $text;

    public function __construct(Editor $editor, string $text)
    {
        $this->editor = $editor;
        $this->text = $text;
    }

    public function execute(): string
    {
        $this->editor->append($this->text);
        return $this->editor->get();
    }

    public function undo(): string
    {
        $this->editor->deleteLast(strlen($this->text));
        return $this->editor->get();
    }
}
