<?php

namespace Output;

final class HTMLElement
{
    private string $element;
    public string $content;
    public StyleDef|string $style;
    public ?iterable $children;

    public function __construct(
        string $element = 'div', 
        StyleDef|string $style = '', 
        iterable $children = null, 
        string $content = ''
    ) 
    {
        $this->element = $element;
        $this->content = $content;
        $this->style = $style;
        $this->children = $children;
    }

    public function __toString()
    {
        $markupContent = $this->content;
        if (isset($this->children)) {
            foreach ($this->children as $child) {
                if ($child instanceof HTMLElement) {
                    $markupContent .= (string) $child;
                }
            }
        }
        return "<$this->element style='$this->style'>$markupContent</$this->element>";
    }

    public function getMarkup() : string
    {
        return (string) $this;
    }

    public function setContent(string $content) : HTMLElement
    {
        $this->content = $content;
        return $this;
    }

    public function setChildren(iterable $children) : HTMLElement
    {
        $this->children = $children;
        return $this;
    }
}
