<?php

namespace SimpleOrm\Entity\Annotation;

use SimpleOrm\Entity\EntityInterface;
use SimpleOrm\Mapper\Annotation\EntityAnnotationListener;
use SimpleOrm\Mapper\Annotation\PropertyAnnotationListener;
use SimpleOrm\Mapper\MapperBuilder;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\PropertyReflection;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\ArrayObject;
use Zend\Stdlib\ArrayUtils;

/**
 * Class AnnotationBuilder
 * @package SimpleOrm\Mapper\Annotation
 */
class AnnotationBuilder implements EventManagerAwareInterface
{
    /**
     * @var \SimpleOrm\Mapper\MapperBuilder
     */
    protected $mapperBuilder;

    /**
     * @var Parser\DoctrineAnnotationParser
     */
    protected $annotationParser;

    /**
     * @var AnnotationManager
     */
    protected $annotationManager;

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * @var array Default annotations to register
     */
    protected $defaultAnnotations = [
        'Table',
        'Id',
        'Column',
        'OneToOne',
        'OneToMany',
        'ManyToOne',
        'ManyToMany'
    ];

    /**
     * Create annotations from entity
     * @param EntityInterface $entity
     * @return ArrayObject
     */
    public function create($entity)
    {
        if (is_object($entity) && !$entity instanceof EntityInterface) {
            throw new \RuntimeException('Entity must implement `EntityInterface`');
        }

        $spec = $this->getSpecification($entity);
        $factory = $this->getMapperBuilder();
        $factory->create($spec);
    }

    /**
     * @param $entity
     * @return ArrayObject
     */
    protected function getSpecification($entity)
    {
        $annotationManager = $this->getAnnotationManager();

        $spec = new ArrayObject();

        $reflection  = new ClassReflection($entity);
        $annotations = $reflection->getAnnotations($annotationManager);

        if ($annotations instanceof AnnotationCollection) {
            $this->configureEntity($annotations, $reflection, $spec);
        }

        foreach ($reflection->getProperties() as $property) {
            $annotations = $property->getAnnotations($annotationManager);

            if ($annotations instanceof AnnotationCollection) {
                $this->configureProperty($annotations, $property, $spec);
            }
        }

        return $spec;
    }


    /**
     * @param AnnotationCollection $annotations
     * @param ClassReflection      $reflection
     * @param ArrayObject          $spec
     */
    protected function configureEntity($annotations, $reflection, $spec)
    {
        $name = $reflection->getShortName();
        $spec['entity'] = $name;

        $events = $this->getEventManager();
        foreach ($annotations as $annotation) {
            $events->trigger(
                __FUNCTION__,
                $this,
                [
                    'annotation' => $annotation,
                    'spec'       => $spec
                ]
            );
        }
    }

    /**
     * @param AnnotationCollection $annotations
     * @param PropertyReflection   $reflection
     * @param ArrayObject          $spec
     */
    protected function configureProperty($annotations, $reflection, $spec)
    {
        $name = $reflection->getName();
        $propertySpec = new ArrayObject();

        $events = $this->getEventManager();
        foreach ($annotations as $annotation) {
            $events->trigger(
                __FUNCTION__,
                $this,
                [
                    'annotation' => $annotation,
                    'spec'       => $propertySpec,
                    'name'       => $name
                ]
            );
        }

        if (!isset($spec['properties'])) {
            $spec['properties'] = [];
        }
        $spec['properties'][] = $propertySpec;
    }

    /**
     * Set event manager instance
     *
     * @param  EventManagerInterface $events
     * @return AnnotationBuilder
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $events->attach(new EntityAnnotationListener());
        $events->attach(new PropertyAnnotationListener());
        $this->events = $events;
        return $this;
    }

    /**
     * Get event manager
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    /**
     * Get mapper builder
     * @return MapperBuilder
     */
    public function getMapperBuilder()
    {
        if (!$this->mapperBuilder) {
            $this->setMapperBuilder(new MapperBuilder());
        }
        return $this->mapperBuilder;
    }

    public function setMapperBuilder(MapperBuilder $mapperBuilder)
    {
        $this->mapperBuilder = $mapperBuilder;
    }

    /**
     * @return mixed
     */
    public function getAnnotationManager()
    {
        if ($this->annotationManager) {
            return $this->annotationManager;
        }

        $this->setAnnotationManager(new AnnotationManager());
        return $this->annotationManager;
    }

    /**
     * @param mixed $annotationManager
     */
    public function setAnnotationManager(AnnotationManager $annotationManager)
    {
        $parser = $this->getAnnotationParser();
        foreach ($this->defaultAnnotations as $annotationName) {
            $class = __NAMESPACE__ . '\\' . $annotationName;
            $parser->registerAnnotation($class);
        }
        $annotationManager->attach($parser);
        $this->annotationManager = $annotationManager;
    }

    /**
     * @return \Zend\Code\Annotation\Parser\DoctrineAnnotationParser
     */
    public function getAnnotationParser()
    {
        if (null === $this->annotationParser) {
            $this->annotationParser = new Parser\DoctrineAnnotationParser();
        }

        return $this->annotationParser;
    }
}
