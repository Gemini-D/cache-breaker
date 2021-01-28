# CacheBreaker

![PHPUnit](https://github.com/Gemini-D/cache-breaker/workflows/PHPUnit/badge.svg)

为 hyperf/cache 扩展熔断能力

```
composer require gemini/cache-breaker
```

## 使用

### 添加 Aspect 配置

> 本组件并不是默认生效，所以需要配置对应的 Aspect

修改配置文件 `config/autoload/aspects.php` 如下：

```php
<?php

declare(strict_types=1);

return [
    Gemini\CacheBreaker\Aspect\CacheableAspect::class,
];

```

### 增加熔断注解

如果不增加 `熔断注解`，则 `Aspect` 在捕获到异常后，会执行 `ThrowExceptionFallback`，当然，你也可以通过 `dependencies` 配置重写 `ThrowExceptionFallback`。

```php
<?php

declare(strict_types=1);

namespace App\Service;

use Gemini\CacheBreaker\Annotation\Breaker;
use Gemini\CacheBreaker\Fallback\DefaultFallback;
use Hyperf\Cache\Annotation\Cacheable;

class RedisService
{
    /**
     * @Breaker(data={"id": 1}, fallback=DefaultFallback::class)
     * @Cacheable(prefix="redis:test")
     */
    public function get()
    {
        return uniqid();
    }
}

```

`DefaultFallback` 行为是，如果抛出的异常是 `RedisException`，则会直接执行实际代码 `processOriginalMethod()`，反之则会抛出错误。

同理，你也可以使用 `dependencies` 重写 `DefaultFallback`。

上述代码，当 `Redis` 宕机后，便每次都会执行 `uniqid()`，不会抛出异常。
