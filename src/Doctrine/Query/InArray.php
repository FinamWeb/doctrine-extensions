<?php

namespace Just2trade\DoctrineExtensions\Doctrine\Query;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * InArrayFunction ::= "inarray" "(" StringPrimary "," StringPrimary ")" = TRUE.
 */
class InArray extends FunctionNode
{
    /** @var \Doctrine\ORM\Query\AST\PathExpression */
    public $fieldName = null;

    /** @var \Doctrine\ORM\Query\AST\PathExpression */
    public $value = null;

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->value = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->fieldName = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @return string
     *
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return '('.$this->value->dispatch($sqlWalker).' <@ '.$this->fieldName->dispatch($sqlWalker).')';
    }
}
