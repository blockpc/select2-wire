<?php

namespace Blockpc\Select2Wire\Helpers;

abstract class Parser
{
	abstract public function createSelect2() : void;

    abstract public function createView(): void;

    abstract protected function get_type_class() : string;

    abstract protected function get_type_view() : string;
}