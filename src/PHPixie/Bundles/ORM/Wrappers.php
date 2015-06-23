<?php

namespace PHPixie\Bundles\ORM;

class Wrappers
{
    protected $wrappersMap;
    protected $maps = array();
    protected $names;
    
    public function __construct($bundleRegistry)
    {
        $types = array(
            'databaseRepositories',
            'databaseQueries',
            'databaseEntities',
            'embeddedEntities'
        );
        
        $this->maps = array_fill_keys($types, array());
        
        foreach($bundleRegistry->bundles() as $bundle) {
            if(!($bundle instanceof \PHPixie\Bundles\Bundle\Provides\ORMWrappers)) {
                continue;
            }
            
            $bundleName  = $bundle->name();
            $ormWrappers = $bundle->ormWrappers();
            
            foreach($types as $type) {
                foreach($ormWrappers->$type() as $name) {
                    $this->maps[$type][$name] = $ormWrappers;
                }
            }
        }
        
        foreach($this->maps as $type => $map) {
            $this->names[$type] = array_keys($map);
        }
    }
    
    public function databaseRepositories()
    {
        return $this->names['databaseRepositories'];
    }
    
    public function databaseQueries()
    {
        return $this->names['databaseQueries'];
    }
    
    public function databaseEntities()
    {
        return $this->names['databaseEntities'];
    }
    
    public function embeddedEntities()
    {
        return $this->names['embeddedEntities'];
    }
    
    public function databaseRepositoryWrapper($repository)
    {
        return $this
            ->wrappers('databaseRepositories', $repository->modelName())
            ->databaseRepositoryWrapper($repository);
    }
    
    public function databaseQueryWrapper($query)
    {
        return $this
            ->wrappers('databaseQueries', $query->modelName())
            ->databaseQueryWrapper($query);
    }
    
    public function databaseEntityWrapper($entity)
    {
        return $this
            ->wrappers('databaseEntities', $entity->modelName())
            ->databaseEntityWrapper($entity);
    }
    
    public function embeddedEntityWrapper($entity)
    {
        return $this
            ->wrappers('embeddedEntities', $entity->modelName())
            ->embeddedEntityWrapper($entity);
    }
    
    protected function wrappers($type, $modelName)
    {
        return $this->maps[$type][$modelName];
    }
}