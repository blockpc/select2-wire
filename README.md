# Select 2 Wire

This package create a select2 livewire component via commands.
The package is built under a TALL stack.
One command creates a livewire component as well as its view, plus it gives you the option to create a trait to receive basic events on a parent component.

## Installation

```bash
    composer require blockpc/select2-wire
```

## Commands

- **Single component**: Create a component that works as a single selectable, allows you to add data on the fly
- **Multiple component**: Create a component that works as a multiple selectable, allows you to add data on the fly, data must be separated by commas

### Single Component Foo

```bash
    php artisan select2:single foo
```

This command create a `single` component select2 class (under `Livewire/Select2/FooSelect2.php` directory app) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Foo` related

### Single Component Foo with model Baz

```bash
    php artisan select2:single foo --model=baz
    # or
    php artisan select2:single foo -m baz
```

This command create a `single` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related

### Single Component Foo with model Baz and parent model Taz

This is the suggested command. It has the same behavior as the others but adds some events (and listeners) that allow you to interact with a foreign component (ex CRUD). It also allows you to create a trait to help you in this

```bash
    php artisan select2:single foo --model=baz --parent=taz
    # or
    php artisan select2:single foo -m baz -p taz
```

This command create a `single` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related, Gives you the option to create a trait if you need to interact with an external component (under directory app `Livewire/Select2/Traits/SingleSelect2.php`)

### Multiple Component Foo

```bash
    php artisan select2:multiple foo
```

This command create a `multiple` component select2 class (under `Livewire/Select2/FooSelect2.php` directory app) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Foo` related

### Multiple Component Foo with model Baz

```bash
    php artisan select2:multiple foo --model=baz
    # or
    php artisan select2:multiple foo -m baz
```

This command create a `multiple` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related

### Multiple Component Foo with model Baz and parent model Taz

This is the suggested command. It has the same behavior as the others but adds some events (and listeners) that allow you to interact with a foreign component (ex CRUD). It also allows you to create a trait to help you in this

```bash
    php artisan select2:multiple foo --model=baz --parent=taz
    # or
    php artisan select2:multiple foo -m baz -p taz
```

This command create a `multiple` component select2 class (under directory app `Livewire/Select2/FooSelect2.php`) and one view (under directory resource `livewire/select2/foo-select2.blade.php`) with a model `Baz` related, Gives you the option to create a trait if you need to interact with an external component (under directory app `Livewire/Select2/Traits/MultipleSelect2.php`)


## Usage

### Let's suppose
> Our company sells vehicles and each vehicle has one code, a brand and can be in various colors

From what has been read above we understand that we have a **parent model** called `vehicle`. And it has properties like one code, one brand and many colors 

### Brand
The model `brand` have a relation one-to-one with parent model `vehicle`  
`One vehicle has one brand`  
This relation we called like `single` relation

### Colors
The model `color` have a relation many-to-many with parent model `vehicle` 
`One vehicle has many colors and one color can be set in many vehicles`  
This relation we called like `multiple` relation  

### Extra Migration
For this we need a migration that creates the table that contains the foreign keys for `color` and `vehicle` models
`php artisan make:migration create_color_vehicle_table`

### Models
So, your parent model `vehicle` should look like this  

```php
class Vehicle extends Model
{
    // ... 
    protected $fillable = ['code'];

    // one-to-one brand
    public function brand(): belongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    // many-to-many colors
    public function colors(): BelongsToMany
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
    public function vehicles(): HasMnay
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
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
```

## 💖 Support the development
**Do you like this project? Support it by donating**

- PayPal: [Donate](https://paypal.me/blockpc)

Select2-Wire is open-sourced software licensed under the [MIT license](LICENSE.md).