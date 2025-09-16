<?php

namespace Laravel\Surveyor\Result;

use Laravel\Surveyor\Types\Contracts\Type;
use PhpParser\NodeAbstract;

class VariableState
{
    public function __construct(
        public Type $type,
        public int $startLine,
        public int $startTokenPos,
        public int $endLine,
        public int $endTokenPos,
        public ?int $terminatedAt = null,
    ) {
        //
    }

    public static function fromNode(Type $type, NodeAbstract $node): self
    {
        return new self(
            $type,
            $node->getStartLine(),
            $node->getStartTokenPos(),
            $node->getEndLine(),
            $node->getEndTokenPos(),
        );
    }

    public function terminate(int $line): self
    {
        $this->terminatedAt = $line;

        return $this;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function startLine(): int
    {
        return $this->startLine;
    }

    public function startTokenPos(): int
    {
        return $this->startTokenPos;
    }

    public function endTokenPos(): int
    {
        return $this->endTokenPos;
    }

    public function terminatedAt(): ?int
    {
        return $this->terminatedAt;
    }

    // TODO: Is this the right name?
    public function isTerminatedAfter(int $line): bool
    {
        if ($this->terminatedAt === null) {
            return true;
        }

        return $this->terminatedAt >= $line;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'startLine' => $this->startLine,
            'startTokenPos' => $this->startTokenPos,
            'endLine' => $this->endLine,
            'endTokenPos' => $this->endTokenPos,
            'terminatedAt' => $this->terminatedAt,
        ];
    }
}
