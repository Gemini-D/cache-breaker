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
namespace Gemini\CacheBreaker;

use Gemini\CacheBreaker\Annotation\Breaker;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Throwable;

interface FallbackInterface
{
    public function fallback(ProceedingJoinPoint $joinPoint, Throwable $throwable, Breaker $breaker);
}
