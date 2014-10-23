<?php

namespace WSP\ThirdBundle\Service;

class StudentService
{
    private $cache = [];

    public function encodeString($subject)
    {
        $sanitized = preg_replace('/\W/u', '_', $subject);
        $lower = strtolower($sanitized);
        $trimmed = trim($lower, '_');
        return preg_replace('/_{2,}/u', '_', $trimmed);
    }

    public function getUniquePath($path)
    {
        $path = $this->encodeString($path);
        if (isset($this->cache[$path])) {
            $i = 1;
            do {
                $pathCheck = $path . '_' . $i++;
            } while (isset($this->cache[$pathCheck]));
            $path = $pathCheck;
        }
        $this->cache[$path] = true;
        return $path;
    }
} 