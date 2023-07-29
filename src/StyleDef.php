<?php

namespace Output;

final class StyleDef
{
    public array $definition;

    public function __construct(array $definition = []) {
        $this->definition = $definition;
    }

    public function __toString()
    {
        $result = '';
        foreach ($this->definition as $key => $value) {
            $result .= "$key: $value; ";
        }
        return $result;
    }

    public function createHTMLProperty() : string
    {
        return (string) $this;
    }

    public function addProperty(string $name, string|int|float $value) {
        $this->definition[$name] = (string) $value;
    } 
}
