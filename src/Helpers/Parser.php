<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Helpers;

abstract class Parser
{
    abstract protected function get_type_class() : string;

    abstract protected function get_type_view() : string;
}