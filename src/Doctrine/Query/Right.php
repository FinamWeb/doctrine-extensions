<?php

namespace Just2trade\DoctrineExtensions\Doctrine\Query;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\ASTException;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class Right extends FunctionNode
{
    /** @var Node */
    private $fieldNode;

    /** @var ArithmeticExpression */
    private $sizeExpression;

    /**
     * @return string
     *
     * @throws ASTException
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'right('.$this->fieldNode->dispatch($sqlWalker).', '.$this->sizeExpression->dispatch($sqlWalker).')';
    }

    /**
     * @return void
     *
     * @throws QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->fieldNode = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->sizeExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
