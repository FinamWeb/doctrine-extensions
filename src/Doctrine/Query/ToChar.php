<?php

namespace Just2trade\DoctrineExtensions\Doctrine\Query;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class ToChar extends FunctionNode
{
    /**
     * @var PathExpression $field
     */
    private $field;

    /**
     * @var PathExpression $format
     */
    private $format;

    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_COMMA);
        $this->format = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'to_char(' . $this->field->dispatch($sqlWalker) . ',' . $this->format->dispatch($sqlWalker) . ')';
    }
}