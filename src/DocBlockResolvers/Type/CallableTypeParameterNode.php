<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

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

        dd($node, $node::class.' not implemented yet');
    }
}
