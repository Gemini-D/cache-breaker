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
namespace Gemini\CacheBreaker\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Breaker extends AbstractAnnotation
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @var null|string
     */
    public $fallback;

    public function __construct($value = null)
    {
        parent::__construct($value);
    }
}
