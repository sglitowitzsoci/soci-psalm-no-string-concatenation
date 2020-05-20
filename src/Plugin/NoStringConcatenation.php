<?php

    namespace SOCi\Psalm\Plugin;

    use PhpParser\Node\Expr;
    use PhpParser\Node\Expr\BinaryOp\Concat;
    use Psalm\Codebase;
    use Psalm\CodeLocation;
    use Psalm\Context;
    use Psalm\IssueBuffer;
    use Psalm\Plugin\Hook\AfterExpressionAnalysisInterface;
    use Psalm\Plugin\PluginEntryPointInterface;
    use Psalm\Plugin\RegistrationInterface;
    use Psalm\StatementsSource;
    use SimpleXMLElement;
    use SOCi\Psalm\Issue\StringConcatenation;

final class NoStringConcatenation implements PluginEntryPointInterface, AfterExpressionAnalysisInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(RegistrationInterface $api, SimpleXMLElement $config = null)
    {
        // TODO: Implement __invoke() method.
    }

    /**
     * @inheritDoc
     */
    public static function afterExpressionAnalysis(
        Expr $expr,
        Context $context,
        StatementsSource $statements_source,
        Codebase $codebase,
        array &$file_replacements = []
    ) {
        if ($expr instanceof Concat) {
            if (
                IssueBuffer::accepts(
                    new StringConcatenation(
                        'Use string interpolation instead of concatenation.',
                        new CodeLocation($statements_source->getSource(), $expr)
                    ),
                    $statements_source->getSuppressedIssues()
                )
            ) {
                return null;
            }
        }
        return null;
    }
}
