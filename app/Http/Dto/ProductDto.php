<?php

namespace App\Http\Dto;


class ProductDto implements DtoInterface
{
    public string $article;
    public string $name;
    public string $status;
    public array $attributeName;
    public array $attributeValue;

    public static function map(array $data)
    {
        $o = new self();

        $o->article = $data['article'];
        $o->name = $data['name'];
        $o->status = $data['status'];
        $o->attributeName = $data['attribute_name'] ?? [];
        $o->attributeValue = $data['attribute_value'] ?? [];

        return $o;
    }
}
