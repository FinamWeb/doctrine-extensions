<?php

namespace Just2trade\DoctrineExtensions\Doctrine\Query;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class DateTrunc extends FunctionNode
{
    /**
     * holds the timestamp of the date_trunc DQL statement
     * @var mixed
     */
    protected $dateExpression;

    /**
     * holds a parameter of the date_trunc DQL statement
     * @var string
     */
    protected $param;

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
    {
        return 'date_trunc(' .
            $sqlWalker->walkStringPrimary($this->param) .
            ','.
            $sqlWalker->walkArithmeticExpression($this->dateExpression) .
            ')';
    }

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     *
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->param = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_COMMA);

        $this->dateExpression = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}