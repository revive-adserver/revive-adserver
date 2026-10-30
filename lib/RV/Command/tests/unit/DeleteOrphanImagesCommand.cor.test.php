<?php

require_once MAX_PATH . '/lib/RV/Command/DeleteOrphanImagesCommand.php';

class TestableDeleteOrphanImagesCommand extends \RV\Command\DeleteOrphanImagesCommand
{
    public static function getBannerImageReferencesForTest(array $banner): array
    {
        return parent::getBannerImageReferences($banner);
    }
}

class Test_RV_Command_DeleteOrphanImagesCommand extends UnitTestCase
{
    public function testReferencedPrimaryAndAlternateImagesAreRetained(): void
    {
        $references = array_merge(
            TestableDeleteOrphanImagesCommand::getBannerImageReferencesForTest([
                'filename' => 'primary.png',
                'alt_filename' => 'alternate.png',
            ]),
            TestableDeleteOrphanImagesCommand::getBannerImageReferencesForTest([
                'filename' => 'another-primary.png',
                'alt_filename' => '',
            ]),
        );

        $orphanCandidates = array_values(array_diff(
            ['primary.png', 'alternate.png', 'another-primary.png', 'orphan.png'],
            $references,
        ));

        $this->assertEqual($orphanCandidates, ['orphan.png']);
    }
}
