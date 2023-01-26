<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ScopeChecks
{
    protected function isCheckScopeMethod(string $method): bool
    {
        return Str::startsWith($method, 'scopeCheck');
    }

    protected function getOriginalScopeMethodName($checkMethodName): string
    {
        return preg_replace('/^(scopeCheck)(.*)$/m', '$2', $checkMethodName);
    }

    protected function forwardCallTo($object, $method, $parameters)
    {
        if ($this->isCheckScopeMethod($method)) {
            $originalScopeMethodName = $this->getOriginalScopeMethodName($method);

            return method_exists($this, "scope{$originalScopeMethodName}");
        }

        return parent::forwardCallTo($object, $method, $parameters);
    }
}
