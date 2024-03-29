<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Tests\Feature;

use Blockpc\Select2Wire\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

final class DeleteSelect2ComponentTest extends TestCase
{
    private $component;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        // destination path of the Selecte2 class
        $this->component = app_path('Http/Livewire/Select2/FooSelect2.php');
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->artisan('select2:delete')
            ->expectsOutput('A name is required!')
            ->assertExitCode(1);
    }

    /** @test */
    public function can_not_delete_a_select2_component_does_not_exists()
    {
        $this->artisan('select2:delete fake')
            ->expectsOutput('A Component FakeSelect2 does not exists!')
            ->assertExitCode(1);
    }

    /** @test */
    public function can_delete_a_select2_component()
    {
        $this->artisan('select2:single foo');

        $this->assertTrue(File::exists($this->component));

        $this->artisan('select2:delete foo')
            ->expectsConfirmation("Do you really want to delete FooSelect2 component?", 'yes')
            ->expectsOutput('A Component FooSelect2 was deleted!')
            ->expectsOutput('A View livewire/select2/foo-select2.blade.php was deleted!');

        $this->assertTrue(File::missing($this->component));
    }

    /** @test */
    public function cancel_delete_a_select2_component()
    {
        $this->artisan('select2:single foo');

        $this->assertTrue(File::exists($this->component));

        $this->artisan('select2:delete foo')
            ->expectsConfirmation("Do you really want to delete FooSelect2 component?", 'no')
            ->expectsOutput('No action executed!');

        $this->assertFalse(File::missing($this->component));
    }
}