<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Tests\Feature;

use Blockpc\Select2Wire\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;

final class CreateSingleSelect2Test extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->artisan('select2:single')
            ->expectsOutput('A name is required!')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_creates_a_new_select2_class_without_model()
    {
        // destination path of the Selecte2 class
        $select2Class = app_path('Http/Livewire/Select2/FooSelect2.php');
        $viewFile = resource_path('views/livewire/select2/foo-select2.blade.php');

        // make sure we're starting from a clean state
        if (File::exists($select2Class)) {
            unlink($select2Class);
            unlink($viewFile);
        }
        if (File::exists($viewFile)) {
            unlink($viewFile);
        }

        $this->assertFalse(File::exists($select2Class));

        // Run the make command
        Artisan::call('select2:single foo');

        // Assert a new file is created
        $this->assertTrue(File::exists($select2Class));
        $this->assertTrue(File::exists($viewFile));
    }

    /** @test */
    public function select2_livewire_foo_exists()
    {
        Artisan::call('select2:single foo');

        Livewire::test(\App\Http\Livewire\Select2\FooSelect2::class);
            // ->assertSet('foo', \App\Models\Foo::class);

        $this->assertTrue(true);

        //$this->assertInstanceOf(App\Models\Foo::class, $livewire->foo);
    }
}