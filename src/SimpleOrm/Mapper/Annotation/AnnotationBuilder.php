<?php

namespace SimpleOrm\Mapper\Annotation;

use ArrayObject;
use SimpleOrm\Example\Model\User;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\Parser;
use Zend\Code\Reflection\ClassReflection;
use Zend\Stdlib\ArrayUtils;

/**
 * Class AnnotationBuilder
 * @package SimpleOrm\Mapper\Annotation
 */
class AnnotationBuilder
{

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
     * @var Factory
     */
    protected $formFactory;

    /**
     * @var object
     */
    protected $entity;

    /**
     * @var array Default annotations to register
     */
    protected $defaultAnnotations = [
        'Entity',
        'Table',
        'Id',
//        'GeneratedValue',
        'Column',
    ];

    public function create()
    {
        $this->getSpecification(new User());
    }

    public function getSpecification($entity)
    {
//        $this->entity      = $entity;
        $annotationManager = $this->getAnnotationManager();
        $formSpec          = new ArrayObject();
        $filterSpec        = new ArrayObject();

        $reflection  = new ClassReflection($entity);
        $annotations = $reflection->getAnnotations($annotationManager);
var_dump($annotations); die;
        if ($annotations instanceof AnnotationCollection) {
            $this->configureForm($annotations, $reflection, $formSpec, $filterSpec);
        }

        foreach ($reflection->getProperties() as $property) {
            $annotations = $property->getAnnotations($annotationManager);

            if ($annotations instanceof AnnotationCollection) {
                $this->configureElement($annotations, $property, $formSpec, $filterSpec);
            }
        }

        if (!isset($formSpec['input_filter'])) {
            $formSpec['input_filter'] = $filterSpec;
        } elseif (is_array($formSpec['input_filter'])) {
            $formSpec['input_filter'] = ArrayUtils::merge($filterSpec->getArrayCopy(), $formSpec['input_filter']);
        }

        return $formSpec;
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
