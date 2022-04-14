<?php

declare(strict_types=1);

namespace App\Service;

use Sentry\Tracing\SamplingContext;
use Symfony\Component\HttpFoundation\RequestStack;

class Sentry
{
    public function __construct(protected RequestStack $requestStack)
    {
    }

    public function getTracesSampler(): callable
    {
        return function (SamplingContext $samplingContext): float {
            $request = $this->requestStack->getCurrentRequest();

            if (preg_match('/\/(admin|media|_profiler|_wdt)\//', $request->getRequestUri())) {
                return 0.0;
            }

            return 1.0;
        };
    }
}
