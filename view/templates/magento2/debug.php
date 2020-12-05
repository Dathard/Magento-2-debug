<span style="color: #0000BB">
<?= $block->parsePhpCode(<<<'EOD'
public function addComplexSuccessMessage($identifier, array $data = [], $group = null);
public function addComplexErrorMessage($identifier, array $data = [], $group = null);
public function addComplexWarningMessage($identifier, array $data = [], $group = null);
public function addComplexNoticeMessage($identifier, array $data = [], $group = null);
EOD
); ?>
</span>

<hr>

<span style="color: #0000BB">
<?= $block->parsePhpCode(<<<'EOD'
if( isset($_GET["templatehints"]) ) 
{
    return $this->debugHintsFactory->create([
        "subject" => $invocationResult,
        "showBlockHints" => 1 ]);
}
EOD
); ?>
</span>
