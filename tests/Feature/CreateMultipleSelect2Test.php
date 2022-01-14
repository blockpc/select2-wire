<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Tests\Feature;

use Blockpc\Select2Wire\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

final class CreateMultipleSelect2Test extends TestCase
{
    private $view_foo;
    private $class_foo;
    private $trait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // destination path of the Selecte2 class
        $this->trait = app_path('Http/Livewire/Select2/Traits/MultipleTrait.php');
        $this->class_foo = app_path('Http/Livewire/Select2/FooSelect2.php');
        $this->view_foo = resource_path('views/livewire/select2/foo-select2.blade.php');
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->artisan('select2:multiple')
            ->expectsOutput('A name is required!')
            ->assertExitCode(1);
    }
}