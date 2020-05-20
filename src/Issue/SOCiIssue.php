<?php

    namespace SOCi\Psalm\Issue;

    use Psalm\Config;
    use Psalm\Issue\PluginIssue;

    use function array_pop;
    use function explode;
    use function get_called_class;

class SOCiIssue extends PluginIssue
{
    /**
     * @param  string          $severity
     *
     * @return \SOCi\Psalm\Internal\Analyzer\IssueData
     */
    public function toIssueData($severity = Config::REPORT_ERROR)
    {
        $location = $this->getLocation();
        $selection_bounds = $location->getSelectionBounds();
        $snippet_bounds = $location->getSnippetBounds();

        $fqcn_parts = explode('\\', get_called_class());
        $issue_type = array_pop($fqcn_parts);

        return new \SOCi\Psalm\Internal\Analyzer\IssueData(
            $severity,
            $location->getLineNumber(),
            $location->getEndLineNumber(),
            $issue_type,
            $this->getMessage(),
            $location->file_name,
            $location->file_path,
            $location->getSnippet(),
            $location->getSelectedText(),
            $selection_bounds[0],
            $selection_bounds[1],
            $snippet_bounds[0],
            $snippet_bounds[1],
            $location->getColumn(),
            $location->getEndColumn(),
            (int) static::SHORTCODE,
            (int) static::ERROR_LEVEL
        );
    }
}
