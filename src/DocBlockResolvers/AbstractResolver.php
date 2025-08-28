<?php

namespace Laravel\StaticAnalyzer\DocBlockResolvers;

use Laravel\StaticAnalyzer\Analysis\Scope;
use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\Parser\DocBlockParser;
use Laravel\StaticAnalyzer\Resolvers\DocBlockResolver;
use Laravel\StaticAnalyzer\Resolvers\NodeResolver;
use PhpParser\Node\Expr\CallLike;
use PHPStan\PhpDocParser\Ast\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;

abstract class AbstractResolver
{
    public function __construct(
        public DocBlockResolver $typeResolver,
        protected DocBlockParser $docBlockParser,
        protected PhpDocNode $parsed,
        protected ?CallLike $referenceNode,
        protected Scope $scope,
        protected NodeResolver $nodeResolver,
    ) {
        //
    }

    protected function from(Node $node)
    {
        Debug::log('📄 Resolving DocBlock: '.get_class($node));

        return $this->typeResolver
            ->setParsed($this->parsed)
            ->setReferenceNode($this->referenceNode)
            ->from($node, $this->scope);
    }
}
