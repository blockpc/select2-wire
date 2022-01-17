<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Tests\Feature;

use Blockpc\Select2Wire\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

final class CreateMultipleSelect2Test extends TestCase
{
    private $view;
    private $class;
    private $trait;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // destination path of the Selecte2 class
        $this->trait = app_path('Http/Livewire/Select2/Traits/MultipleTrait.php');
        $this->class = app_path('Http/Livewire/Select2/BarSelect2.php');
        $this->view = resource_path('views/livewire/select2/bar-select2.blade.php');
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->artisan('select2:multiple')
            ->expectsOutput('A name is required!')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_creates_a_bar_select2_class_without_model_and_view()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));

        // Run the make command
        $this->artisan('select2:multiple bar')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'yes')
            ->expectsOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::exists($this->view));
    }

    /** @test */
    public function it_creates_a_bar_select2_class_without_model_and_without_view()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));

        // Run the make command
        $this->artisan('select2:multiple bar')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'no')
            ->doesntExpectOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::missing($this->view));
    }

    /** @test */
    public function it_creates_a_bar_select2_class_with_model_and_view()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));

        // Run the make command
        $this->artisan('select2:multiple bar --model=foo')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'yes')
            ->expectsOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::exists($this->view));
    }

    /** @test */
    public function it_creates_a_bar_select2_class_with_model_and_without_view()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));

        // Run the make command
        $this->artisan('select2:multiple bar --model=foo')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'no')
            ->doesntExpectOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::missing($this->view));
    }

    /** @test */
    public function it_create_a_bar_select2_with_parent()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));
        $this->assertFalse(File::exists($this->trait));

        $this->artisan('select2:multiple bar --parent=bar')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'yes')
            ->expectsOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php')
            ->expectsConfirmation('Do you wish to create a trait for parent model?', 'yes')
            ->expectsOutput('Created a trait: App/Http/Livewire/Select2/Traits/MultipleTrait.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::exists($this->view));
        $this->assertTrue(File::exists($this->trait));
    }

    /** @test */
    public function can_create_a_bar_select2_with_parent_use_shortcut()
    {
        $this->deleteFiles();
        $this->assertFalse(File::exists($this->class));
        $this->assertFalse(File::exists($this->trait));

        $this->artisan('select2:multiple bar -p foo')
            ->expectsOutput('Created a component: BarSelect2')
            ->expectsConfirmation('Do you wish to create the view file (Tailwind CSS)?', 'yes')
            ->expectsOutput('Created a view: resources/views/livewire/select2/bar-select2.blade.php')
            ->expectsConfirmation('Do you wish to create a trait for parent model?', 'yes')
            ->expectsOutput('Created a trait: App/Http/Livewire/Select2/Traits/MultipleTrait.php');

        // Assert a bar file component and view
        $this->assertTrue(File::exists($this->class));
        $this->assertTrue(File::exists($this->view));
        $this->assertTrue(File::exists($this->trait));
    }

    /** @test */
    public function cannot_create_bar_select2_when_the_component_exists()
    {
        $this->artisan('select2:multiple bar')
            ->expectsOutput('A Component BarSelect2 exists!')
            ->assertExitCode(1);
    }

    protected function deleteFiles() : void
    {
        // make sure we're starting from a clean state
        if (File::exists($this->class)) {
            unlink($this->class);
        }
        if (File::exists($this->view)) {
            unlink($this->view);
        }
        if (File::exists($this->trait)) {
            unlink($this->trait);
        }
    }
}