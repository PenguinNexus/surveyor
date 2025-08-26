<?php

namespace Laravel\StaticAnalyzer\DocBlockResolvers;

use Laravel\StaticAnalyzer\Parser\DocBlockParser;
use Laravel\StaticAnalyzer\Resolvers\DocBlockResolver;
use PhpParser\Node\Expr\CallLike;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;

abstract class AbstractResolver
{
    public function __construct(
        public DocBlockResolver $typeResolver,
        protected DocBlockParser $docBlockParser,
        protected PhpDocNode $parsed,
        public array $context = [],
        protected ?CallLike $referenceNode = null,
    ) {
        //
    }

    protected function from(Node $node)
    {
        return $this->typeResolver
            ->setParsed($this->parsed)
            ->setReferenceNode($this->referenceNode)
            ->from($node, $this->context);
    }
}
