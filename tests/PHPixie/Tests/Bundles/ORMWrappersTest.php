<?php

namespace PHPixie\Tests\Bundles;

/**
 * @coversDefaultClass \PHPixie\Bundles\ORMWrappers
 */
class ORMWrappersTest extends \PHPixie\Test\Testcase
{
    protected $ormWrappers;
    
    protected $bundleMap = array();
    protected $wrappersMap = array();
    
    protected $typeSuffixes = array(
        'databaseRepositories' => 'Repository',
        'databaseQueries'      => 'Query',
        'databaseEntities'     => 'Entity',
        'embeddedEntities'     => 'Embedded'
    );
    
    public function setUp()
    {
        $bundles = array();
        
        $bundleNames = array('trixie', 'stella');
        foreach($bundleNames as $name) {
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\ORMWrappers');
            $bundles[]= $bundle;
            
            $this->method($bundle, 'name', $name, array());
            
            $wrappers = $this->quickMock('\PHPixie\ORM\Wrappers');
            $this->method($bundle, 'ormWrappers', $wrappers, array());
            $this->wrappersMap[$name] = $wrappers;
            
            foreach($this->typeSuffixes as $type => $suffix) {
                $return = array($name.$suffix.'1', $name.$suffix.'2');
                $this->method($wrappers, $type, $return, array());
            }
        }
        
        $bundles[]= $this->quickMock('\PHPixie\Bundles\Bundle');
        
        $emptyBundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\ORMWrappers');
        $this->method($emptyBundle, 'ormWrappers', null, array());
        $bundles[]= $emptyBundle;
        
        $bundleRegistry =  $this->quickMock('\PHPixie\Bundles\Registry');
        $this->method($bundleRegistry, 'bundles', $bundles, array());
        
        $this->ormWrappers = new \PHPixie\Bundles\ORMWrappers(
            $bundleRegistry
        );
    }
    
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::databaseRepositories
     * @covers ::databaseQueries
     * @covers ::databaseEntities
     * @covers ::embeddedEntities
     * @covers ::<protected>
     */
    public function testModelNames()
    {
        foreach($this->typeSuffixes as $type => $suffix) {
            $expect = array();
            foreach(array_keys($this->wrappersMap) as $bundleName) {
                $expect[]=$bundleName.$suffix.'1';
                $expect[]=$bundleName.$suffix.'2';
            }
            
            $this->assertSame($expect, $this->ormWrappers->$type());
        }
    }
    
    /**
     * @covers ::databaseRepositoryWrapper
     * @covers ::databaseQueryWrapper
     * @covers ::databaseEntityWrapper
     * @covers ::embeddedEntityWrapper
     * @covers ::<protected>
     */
    public function testWrappers()
    {
        $methodClasses = array(
            'databaseRepositories' => 'Database\Repository',
            'databaseQueries'      => 'Database\Query',
            'databaseEntities'     => 'Database\Entity',
            'embeddedEntities'     => 'Embedded\Entity'
        );
        
        $wrapperMethods = array(
            'databaseRepositories' => 'databaseRepositoryWrapper',
            'databaseQueries'      => 'databaseQueryWrapper',
            'databaseEntities'     => 'databaseEntityWrapper',
            'embeddedEntities'     => 'embeddedEntityWrapper'
        );
        
        foreach($this->typeSuffixes as $type => $suffix) {
            $class = $methodClasses[$type];
            $method = $wrapperMethods[$type];
            
            foreach(array_keys($this->wrappersMap) as $bundleName) {
                $wrapped = $this->quickMock('\PHPixie\ORM\Models\Type\\'.$class);
                $wrapper = $this->quickMock('\PHPixie\ORM\Wrappers\Type\\'.$class);
            
                $this->method($wrapped, 'modelName', $bundleName.$suffix.'1', array(), 0);
                
                $wrappers = $this->wrappersMap[$bundleName];
                $this->method($wrappers, $method, $wrapper, array($wrapped), 0);
                
                $this->assertSame($wrapper, $this->ormWrappers->$method($wrapped));
            }
        }
    }
}