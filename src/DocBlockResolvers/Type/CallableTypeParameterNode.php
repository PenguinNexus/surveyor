<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\Debug\Debug;
use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class CallableTypeParameterNode extends AbstractResolver
{
    public function resolve(Ast\Type\CallableTypeParameterNode $node)
    {
        $templateTag = $this->scope->getTemplateTag($node->type->name);

        if ($templateTag) {
            return $templateTag;
        }

        Debug::ddAndOpen($node, $node::class.' dealing with a non-template tag callable');
    }
}
