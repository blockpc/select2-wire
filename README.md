# Select 2 Wire


## Example

### Let's suppose
`Our company sells vehicles and each vehicle has one code, a brand and can be in various colors`
From what has been read above we understand that we have a **parent model** called `vehicle`. And it has properties like one code, one brand and many colors 

### Brand
And this parent model have to relate one-to-one with `brand`  
`One vehicle has one brand`  
This relation we called like `single` relation

### Colors
And this parent model have to relate many-to-many with `color`  
`One vehicle has many colors and one color can be set in many vehicles`  
This relation we called like `multiple` relation  

### Extra Migration
For this we need a migration that creates the table that contains the foreign keys for color and vehicle
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