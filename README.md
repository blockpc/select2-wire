# Select2 Wire

<p align="center"><a href="https://blockpc.cl" target="_blank"><img src="https://banners.beyondco.de/Select2%20Wire.png?theme=light&packageManager=composer+require&packageName=blockpc%2Fselect2-wire&pattern=architect&style=style_1&description=Select2+livewire+component&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg"></a></p>

This package create a select2 livewire component via commands.
The package is built under a TALL stack. Make sure you have the requirements (see composer.json)
One command creates a livewire component as well as its view, plus it gives you the option to create a trait to receive basic events on a parent component.

## Installation

```bash
    composer require blockpc/select2-wire
```

## Commands

> **Single component**
Create a component that works as a single selectable, allows you to add data on the fly

```bash
    php artisan select2:single
```

> **Multiple component**
Create a component that works as a multiple selectable, allows you to add data on the fly, data must be separated by commas

```bash
    php artisan select2:multiple
```

> **Delete component**
This commando delete a component created 

```bash
    php artisan select2:delete
```

### Single Component Foo

```bash
    php artisan select2:single foo
```

This command create a `single` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Foo` related.

### Single Component Foo with model Baz

```bash
    php artisan select2:single foo --model=baz
    # or
    php artisan select2:single foo -m baz
```

This command create a `single` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related.

### Single Component Foo with model Baz and parent model Taz

This is the suggested command. It has the same behavior as the others but adds some events (and listeners) that allow you to interact with a foreign component (ex CRUD). It also allows you to create a trait to help you in this.

```bash
    php artisan select2:single foo --model=baz --parent=taz
    # or
    php artisan select2:single foo -m baz -p taz
```

This command create a `single` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related and parent model `Taz`, Gives you the option to create a trait if you need to interact with an external component (under directory app `Livewire/Select2/Traits/SingleSelect2.php`)

### Multiple Component Foo

```bash
    php artisan select2:multiple foo
```

This command create a `multiple` component select2 class (under `Livewire/Select2/FooSelect2.php` directory app) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Foo` related.

### Multiple Component Foo with model Baz

```bash
    php artisan select2:multiple foo --model=baz
    # or
    php artisan select2:multiple foo -m baz
```

This command create a `multiple` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related.

### Multiple Component Foo with model Baz and parent model Taz

This is the suggested command. It has the same behavior as the others but adds some events (and listeners) that allow you to interact with a foreign component (ex CRUD). It also allows you to create a trait to help you in this.

```bash
    php artisan select2:multiple foo --model=baz --parent=taz
    # or
    php artisan select2:multiple foo -m baz -p taz
```

This command create a `multiple` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related and parent model `Taz`, Gives you the option to create a trait if you need to interact with an external component (under directory app `Livewire/Select2/Traits/MultipleSelect2.php`)

## Usage

### Let's suppose
> Our company sells vehicles and each vehicle has one code, a brand and can be in various colors.

From what has been read above we understand that we have a **parent model** called `vehicle`. And each one has properties like one name, one brand and could be has many colors.

_In the example directory you find all files you needs for this tutorial_

### Brand
The model `brand` have a relation one-to-one with parent model `vehicle`  
`One vehicle has one brand`  
This relation we called like `single` relation

### Colors
The model `color` have a relation many-to-many with parent model `vehicle` 
`One vehicle has many colors and one color can be set in many vehicles`  
This relation we called like `multiple` relation  

### Extra Migration
For a `multiple` relation we need a migration that creates the table that contains the foreign keys for `color` and `vehicle` models
`php artisan make:migration create_color_vehicle_table`

_you find all the migrations in example directory_

**run mingrations**

### Models
So, your parent model `vehicle` should look like this  

```php
class Vehicle extends Model
{
    // ... 
    protected $fillable = ['code'];

    // one-to-one brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // many-to-many colors
    public function colors(): BelongsToMany // Dont forget import this class
    {
        return $this->belongsToMany(Color::class);
    }
}
```

Your `single relation brand` should look like this:

```php
class Brand extends Model
{
    // ...
    protected $fillable = ['name'];

    // one-to-many vehicles 
    public function vehicles(): HasMany // Dont forget import this class
    {
        return $this->hasMany(Vehicle::class);
    }
}
```

Your `multiple relation colors` should look like this:

```php
class Color extends Model
{
    // ...
    protected $fillable = ['name'];

    // One color has many vehicle
    public function vehicles(): BelongsToMany // Dont forget import this class
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
```

### Route and Controller
After this, we need a route and one controller

- Controller: `php artisan make:controller VehiclesController -i`
- Route: _Route::get('/vehicle', VehiclesController::class)->name('vehicles')_

### Commands needed
We run two commands

- php artisan select2:single brand -p vehicle
- php artisan select2:multiple color -p vehicle

And we make sure to accept the creation of the traits. Then we add the components we created to use in the controller view. you can see the example and how it was structured.

**enjoy**


## 💖 Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate](https://paypal.me/blockpc)

Select2-Wire is open-sourced software licensed under the [MIT license](LICENSE.md).
