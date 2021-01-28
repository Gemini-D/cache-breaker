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

use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

/**
 * Must handled before `Hyperf\Cache\Aspect\CacheableAspect`.
 */
class CacheableAspect extends AbstractAspect
{
    /**
     * The default priority is PHP_INT_MAX / 2 in Hyperf 2.x.
     * @var float|int
     */
    public $priority = 4611686018427387904 + 100;

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        return $proceedingJoinPoint->process();
    }
}
