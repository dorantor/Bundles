<?php

namespace PHPixie\Bundles;

interface Registry
{
    public function get($name);
    public function bundles();
}