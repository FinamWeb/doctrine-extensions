<?php

namespace Just2trade\DoctrineExtensions\Doctrine\Query;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * EveryFunction ::= "EVERY" "(" ConditionalExpression ")".
 *
 * usage example: ->having('every( ' . $expr->orX($expr->isNotNull('memb.user'), $expr->isNotNull('memb.mailingList')). ') = :isInternal')
 */
class Every extends FunctionNode
{
    /** @var Node|null */
    private $conditionalExpression = null;

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->conditionalExpression = $parser->ConditionalExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'EVERY('.$this->conditionalExpression->dispatch($sqlWalker).')';
    }
}
