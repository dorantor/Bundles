<?php

namespace PHPixie\Tests\Bundles;

/**
 * @coversDefaultClass \PHPixie\Bundles\FilesystemLocators
 */
abstract class FilesystemLocatorsTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    
    protected $filesystemLocators;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        $this->filesystemLocators = $this->filesystemLocators();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::get
     * @covers ::<protected>
     */
    public function testGet()
    {
        $filesystemLocators = $this->filesystemLocators;
        
        $locator = $this->prepareGetTest('pixie');
        $this->assertSame($locator, $filesystemLocators->get('pixie'));
        
        $this->prepareGetTest('pixie.trixie', true, false);
        $this->assertException(function() use($filesystemLocators) {
            $filesystemLocators->get('pixie.trixie');
        }, '\PHPixie\Bundles\Exception');
        
        $locator = $this->prepareGetTest('pixie.trixie', true, true);
        $this->assertSame($locator, $filesystemLocators->get('pixie.trixie'));
    }
    
    protected function prepareGetTest($name, $nested = false, $isRegistry = false)
    {
        $name = explode('.', $name, 2);
        
        if($isRegistry) {
            $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        }else{
            $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        }
            
        $bundle = $this->prepareGetBundleLocator($locator);
        $this->method($this->bundleRegistry, 'get', $bundle, array($name[0]), 0);
        
        if($isRegistry) {
            $nestedLocator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
            $this->method($locator, 'get', $nestedLocator, array($name[1]), 0);
            $locator = $nestedLocator;
        }
        
        return $locator;
    }
    
    abstract protected function prepareGetBundleLocator($locator);
    abstract protected function filesystemLocators();
}