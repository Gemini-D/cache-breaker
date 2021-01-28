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
namespace Gemini\CacheBreaker\Fallback;

use Gemini\CacheBreaker\Annotation\Breaker;
use Gemini\CacheBreaker\FallbackInterface;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Throwable;

class DefaultFallback implements FallbackInterface
{
    public function fallback(ProceedingJoinPoint $joinPoint, Throwable $throwable, Breaker $breaker)
    {
        return $joinPoint->processOriginalMethod();
    }
}
