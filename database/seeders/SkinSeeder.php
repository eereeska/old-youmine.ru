<?php

namespace Database\Seeders;

use App\Models\Skin;
use Illuminate\Database\Seeder;

class SkinSeeder extends Seeder
{
    public function run()
    {
        Skin::create([
            'owner_id' => 1,
            'slim' => false,
            'texture' => 'ewogICJ0aW1lc3RhbXAiIDogMTYwNDA1NjM3MzY0MiwKICAicHJvZmlsZUlkIiA6ICI5ZDIyZGRhOTVmZGI0MjFmOGZhNjAzNTI1YThkZmE4ZCIsCiAgInByb2ZpbGVOYW1lIiA6ICJTYWZlRHJpZnQ0OCIsCiAgInNpZ25hdHVyZVJlcXVpcmVkIiA6IHRydWUsCiAgInRleHR1cmVzIiA6IHsKICAgICJTS0lOIiA6IHsKICAgICAgInVybCIgOiAiaHR0cDovL3RleHR1cmVzLm1pbmVjcmFmdC5uZXQvdGV4dHVyZS9lZDkyNGQ0MTRiMzRlMzhmMGI4YzQ4YjBlOWJiNjRiM2VmZjY5NDE1NzM2YzdkNzY0ZDFiM2VhYjc5NTg0NzdjIgogICAgfQogIH0KfQ==',
            'signature' => 'Bx9dgj/ZoyHR5TAjbSEkQSsFAKBmigOqhJPDdwKUYl4Ztc33o3cDh6SZiWx6/XY7j6JlqEussnujVFjny+vNUD8i+N419xvPBQTy/Ee4zV4w/osNLfT1pmk+s+1q7olyBVKZP9fnNhUbZat0AUrAR95tnUN+b77RmpqAFCF4RFuJub69X3VWfgc9GKsP0fMNZ6M4CsidsLloJIKfwfxTsgBIoOytEITPU6asW1RFp1HQqBjZkm1Nk0Swq7UiYG5hr3OlZ41QyJ6WUEqOnIxxHuh8p6b9beY649YSLJ0FvVidAleiLOhAHNv3WZRVxffoVdTKP9tsElWt1vd9fmWO+XdWCXgFo5lShJ1IM6a0woKXc5wMYpZfQHZ4MviM1Jax84LFk0Ew5wz6YGrTNxijA1ghhpRoAYIcScQMltD2i28YvUkGCfzIKxcLKz1ys/VumwG+HkjujYzZJM5WG6KEEGjtltLfQwr/+JTktggitg1YncMcIb0cK8o/pFyVAyFIasgm4wWhY9GA8/62L1ro/BeK/OB3ir/fbYpZ8ZY+gyoyAX/QjddH/DzMH14rWHp+1XhgaumCkqGlFmKWkxedmuiGnkXp6RiljM/Pg3f43kMWdOlGg/cGsDJa4k2NOWcNEOaL29CfHgjzOj7xnvHXRPlcoh7RMGF6EVIOLTjiiD4='
        ]);
    }
}
