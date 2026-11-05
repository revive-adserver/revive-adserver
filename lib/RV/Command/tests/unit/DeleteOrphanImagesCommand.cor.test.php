<?php

require_once MAX_PATH . '/lib/RV/Command/DeleteOrphanImagesCommand.php';

class TestableDeleteOrphanImagesCommand extends \RV\Command\DeleteOrphanImagesCommand
{
    public static function appendBannerImageReferencesForTest(array &$references, array $banner): void
    {
        parent::appendBannerImageReferences($references, $banner);
    }
}

class Test_RV_Command_DeleteOrphanImagesCommand extends UnitTestCase
{
    public function testReferencedPrimaryAndAlternateImagesAreRetained(): void
    {
        $references = [];
        TestableDeleteOrphanImagesCommand::appendBannerImageReferencesForTest($references, [
            'filename' => 'primary.png',
            'alt_filename' => 'alternate.png',
        ]);
        TestableDeleteOrphanImagesCommand::appendBannerImageReferencesForTest($references, [
            'filename' => 'another-primary.png',
            'alt_filename' => '',
        ]);

        $orphanCandidates = array_values(array_diff(
            ['primary.png', 'alternate.png', 'another-primary.png', 'orphan.png'],
            $references,
        ));

        $this->assertEqual($orphanCandidates, ['orphan.png']);
    }
}
