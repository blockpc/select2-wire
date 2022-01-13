<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Tests\Feature;

use Blockpc\Select2Wire\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

final class CreateSingleSelect2Test extends TestCase
{
    private $view_foo;
    private $class_foo;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // destination path of the Selecte2 class
        $this->class_foo = app_path('Http/Livewire/Select2/FooSelect2.php');
        $this->view_foo = resource_path('views/livewire/select2/foo-select2.blade.php');

        // make sure we're starting from a clean state
        if (File::exists($this->class_foo)) {
            unlink($this->class_foo);
        }
        if (File::exists($this->view_foo)) {
            unlink($this->view_foo);
        }
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->artisan('select2:single')
            ->expectsOutput('A name is required!')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_creates_a_foo_select2_class_without_model_and_create_view()
    {
        $this->assertFalse(File::exists($this->class_foo));

        // Run the make command
        $this->artisan('select2:single foo')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)? [yes/np]', 'yes');

        // Assert a foo file component and view
        $this->assertTrue(File::exists($this->class_foo));
        $this->assertTrue(File::exists($this->view_foo));
    }

    /** @test */
    public function it_creates_a_foo_select2_class_without_model_and_no_create_view()
    {
        $this->assertFalse(File::exists($this->class_foo));

        // Run the make command
        $this->artisan('select2:single foo')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)? [yes/np]', 'no');

        // Assert a foo file component and view
        $this->assertTrue(File::exists($this->class_foo));
        $this->assertTrue(File::missing($this->view_foo));
    }
}