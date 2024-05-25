<?php

namespace App\Dtos;

use App\Contract\AttributesFeature\Utils\AttributeExtractor;

class AttributeContainers
{
    public function __construct(
        public AttributeExtractor $attributeHandler,
    ) {
    }
}
