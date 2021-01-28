<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Gemini\CacheBreaker\Aspect;

use Gemini\CacheBreaker\Annotation\Breaker;
use Gemini\CacheBreaker\Fallback\DefaultFallback;
use Gemini\CacheBreaker\FallbackInterface;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Psr\Container\ContainerInterface;

/**
 * Must handled before `Hyperf\Cache\Aspect\CacheableAspect`.
 */
class CacheableAspect extends AbstractAspect
{
    /**
     * The annotations that you want to weaving.
     *
     * @var array
     */
    public $annotations = [
        Cacheable::class,
    ];

    /**
     * The default priority is PHP_INT_MAX / 2 in Hyperf 2.x.
     * @var float|int
     */
    public $priority = 4611686018427387904 + 100;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        try {
            return $proceedingJoinPoint->process();
        } catch (\Throwable $exception) {
            if ($annotation = $this->getBreakerAnnotation($proceedingJoinPoint)) {
                /** @var FallbackInterface $fallback */
                $fallback = $this->container->get($annotation->fallback ?? DefaultFallback::class);
                return $fallback->fallback($proceedingJoinPoint, $exception, $annotation);
            }

            throw $exception;
        }
    }

    protected function getBreakerAnnotation($proceedingJoinPoint): ?Breaker
    {
        $meta = $proceedingJoinPoint->getAnnotationMetadata();
        return $meta->method[Breaker::class] ?? null;
    }
}
