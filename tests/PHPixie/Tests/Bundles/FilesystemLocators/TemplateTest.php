<?php

namespace PHPixie\Tests\Bundles\FilesystemLocators;

/**
 * @coversDefaultClass \PHPixie\Bundles\FilesystemLocators\Template
 */
class TemplateTest extends \PHPixie\Tests\Bundles\FilesystemLocatorsTest
{
    /**
     * @covers ::get
     * @covers ::<protected>
     */
    public function testGetInvalidBundle()
    {
        $bundle = $this->quickMock('\PHPixie\Bundles\Bundle');
        $this->method($this->bundleRegistry, 'get', $bundle, array('pixie'), 0);
        
        $filesystemLocators = $this->filesystemLocators;
        $this->assertException(function() use($filesystemLocators) {
            $filesystemLocators->get('pixie');
        }, '\PHPixie\Bundles\Exception');
    }
    
    protected function prepareGetBundleLocator($locator)
    {
        $bundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\TemplateLocator');
        $this->method($bundle, 'templateLocator', $locator, array());
        return $bundle;
    }
    
    protected function filesystemLocators()
    {
        return new \PHPixie\Bundles\FilesystemLocators\Template(
            $this->bundleRegistry
        );
    }
}