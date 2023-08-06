<?php

namespace Output;

final class HTMLElement
{
    private string $element;
    public string $content;
    public StyleDef|string $style;
    public ?iterable $children;
    public string $debugAttr;

    public function __construct(
        string $element = 'div', 
        StyleDef|string $style = '', 
        iterable $children = null, 
        string $content = '',
        string $debugAttr = ''
    ) 
    {
        $this->element = $element;
        $this->content = $content;
        $this->style = $style;
        $this->children = $children;
        $this->debugAttr = $debugAttr;
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

        $debugAttrStripped = htmlspecialchars(strip_tags($this->debugAttr));
        $debugAttr = $this->debugAttr ? "data-debug='$debugAttrStripped'" : '';  
        
        return "
            <$this->element style='$this->style' $debugAttr>
                $markupContent
            </$this->element>
        ";
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

    public function setDebugAttr(string $debugAttr) : HTMLElement
    {
        $this->debugAttr = $debugAttr;
        return $this;
    }
}
