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
            if ($samplingContext->getParentSampled() === true) {
                return 1;
            }

            if (is_null($request = $this->requestStack->getCurrentRequest())) {
                return 0;
            }

            if (preg_match('/\/(admin|media|_profiler|_wdt)\//', $request->getRequestUri()) !== false) {
                return 0;
            }

            return 1;
        };
    }
}
