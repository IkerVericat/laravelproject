c# Guia d'Aprenentatge Completa - Laravel Project

## Índex
1. Instal·lació i Configuració Inicial
2. Estructura del Projecte
3. Base de Dades i Migracions
4. Models i Relacions
5. CRUD amb Controllers
6. Vistes amb Blade
7. API REST
8. Exportació de Dades (Excel)
9. Factories i Seeders
10. Desplegament

---

## 1. Instal·lació i Configuració Inicial

### 1.1 Requisits previs
```bash
# PHP >= 8.2
php --version

# Composer
composer --version

# Node.js i npm
node --version
npm --version
```

### 1.2 Instal·lació de Laravel
```bash
# Crear un nou projecte Laravel
composer create-project laravel/laravel laravelproject

# Entrar al directori
cd laravelproject

# Instal·lar dependències
composer install
npm install
```

### 1.3 Configuració del fitxer .env
Basant-se en el `.env.example`, crea el teu fitxer `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:xxxxx
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelproject
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# Generar clau d'aplicació
php artisan key:generate
```

### 1.4 Configuració de la base de dades
```bash
# Crear la base de dades (MySQL)
mysql -u root -p
CREATE DATABASE laravelproject;
exit;

# Executar migracions
php artisan migrate
```

---

## 2. Estructura del Projecte

### 2.1 Directoris principals
```
laravelproject/
├── app/
│   ├── Http/
│   │   └── Controllers/      # Controladors
│   ├── Models/               # Models Eloquent
│   ├── Exports/              # Classes d'exportació
│   └── Providers/            # Service Providers
├── database/
│   ├── migrations/           # Migracions BD
│   ├── factories/            # Factories per testing
│   └── seeders/              # Seeders
├── resources/
│   ├── views/                # Vistes Blade
│   ├── css/                  # Estils
│   └── js/                   # JavaScript
├── routes/
│   ├── web.php               # Rutes web
│   └── api.php               # Rutes API
├── config/                   # Configuracions
└── public/                   # Fitxers públics
```

### 2.2 Configuració important
- **config/app.php**: Configuració general de l'aplicació
- **config/database.php**: Configuració de base de dades
- **config/excel.php**: Configuració per exportar Excel
- **bootstrap/app.php**: Bootstrap de l'aplicació

---

## 3. Base de Dades i Migracions

### 3.1 Crear migracions
```bash
# Crear migració per taula students
php artisan make:migration create_students_table

# Crear migració per taula teachers
php artisan make:migration create_teachers_table

# Crear migració per taula courses
php artisan make:migration create_courses_table

# Afegir columna course_id a students
php artisan make:migration add_course_id_to_student_table
```

### 3.2 Exemple de migració: Students
Fitxer: `database/migrations/2025_11_21_144803_create_students_table.php`

```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->integer('age');
        $table->string('course');
        $table->timestamps();
    });
}
```

### 3.3 Exemple de migració: Teachers
Fitxer: `database/migrations/2025_11_23_104726_create_teachers_table.php`

```php
public function up(): void
{
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('subject');
        $table->integer('phone');
        $table->timestamps();
    });
}
```

### 3.4 Exemple de migració: Courses
Fitxer: `database/migrations/2025_11_28_142359_create_courses_table.php`

```php
public function up(): void
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('teacher_id')
              ->nullable()
              ->constrained('teachers')
              ->onDelete('set null');
        $table->timestamps();
    });
}
```

### 3.5 Relació entre Students i Courses
Fitxer: `database/migrations/2025_12_02_155725_add_course_id_to_student_table.php`

```php
public function up(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->foreignId('course_id')
              ->nullable()
              ->constrained('courses')
              ->onDelete('set null');
    });
}
```

### 3.6 Executar migracions
```bash
# Executar totes les migracions
php artisan migrate

# Revertir última migració
php artisan migrate:rollback

# Refrescar tota la BD
php artisan migrate:fresh

# Refrescar i executar seeders
php artisan migrate:fresh --seed
```

---

## 4. Models i Relacions

### 4.1 Crear Models
```bash
# Crear model Student
php artisan make:model Student

# Crear model Teacher
php artisan make:model Teacher

# Crear model Course
php artisan make:model Course
```

### 4.2 Model Student amb relacions
Fitxer: `app/Models/Student.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'age', 'course_id'];

    // Relació: Un student pertany a un curs
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
```

### 4.3 Model Teacher amb relacions
Fitxer: `app/Models/Teacher.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'subject', 'phone'];

    // Relació: Un professor té molts cursos
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
```

### 4.4 Model Course amb relacions
Fitxer: `app/Models/Course.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'teacher_id'];

    // Relació: Un curs pertany a un professor
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relació: Un curs té molts estudiants
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
```

### 4.5 Tipus de relacions Eloquent
- **`belongsTo`**: Relació 1:1 o N:1 (l'entitat actual pertany a una altra)
- **`hasMany`**: Relació 1:N (l'entitat actual té moltes instàncies d'una altra)
- **`belongsToMany`**: Relació N:M (amb taula pivot)
- **`hasOne`**: Relació 1:1 (l'entitat actual té una instància d'una altra)

---

## 5. CRUD amb Controllers

### 5.1 Crear Controllers
```bash
# Controller amb tots els mètodes CRUD
php artisan make:controller StudentsController --resource

# Controller per API
php artisan make:controller API/StudentApiController --api
```

### 5.2 StudentsController - CRUD complet
Fitxer: `app/Http/Controllers/StudentsController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    // Llistar tots els estudiants (READ)
    public function index()
    {
        $students = Student::oldest()->paginate(5);
        return view('students.index', compact('students'));
    }

    // Formulari per crear (CREATE - Vista)
    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    // Guardar nou estudiant (CREATE - Acció)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    // Mostrar un estudiant (READ - Detall)
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    // Formulari per editar (UPDATE - Vista)
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    // Actualitzar estudiant (UPDATE - Acció)
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    // Eliminar estudiant (DELETE)
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    // Exportar a Excel
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    // Assignar curs a estudiant
    public function assignCourse(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $student->update(['course_id' => $request->course_id]);
        return redirect()->back()
            ->with('success', 'Estudiante asignado al curso correctamente');
    }

    // Eliminar curs d'estudiant
    public function removeCourse(Student $student)
    {
        $student->update(['course_id' => null]);
        return redirect()->back()
            ->with('success', 'Estudiante removido del curso');
    }
}
```

### 5.3 TeachersController
Fitxer: `app/Http/Controllers/TeachersController.php` - Segueix el mateix patró CRUD

### 5.4 CoursesController
Fitxer: `app/Http/Controllers/CoursesController.php` - Segueix el mateix patró CRUD

---

## 6. Vistes amb Blade

### 6.1 Layout principal
Fitxer: `resources/views/layouts/app.blade.php`

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>
```

### 6.2 Vista Index (Llistat)
Fitxer: `resources/views/students/index.blade.php`

```php
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Students List</h2>
    <div class="d-flex gap-2">
        <a class="btn btn-primary" href="{{ route('students.create') }}">Create Student</a>
        <a class="btn btn-success" href="{{ route('students.export') }}">Export Excel</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->age }}</td>
            <td>{{ $student->course ? $student->course->name : 'Sin curso' }}</td>
            <td>
                <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $students->links() }}
@endsection
```

### 6.3 Vista Create (Formulari creació)
Fitxer: `resources/views/students/create.blade.php`

```php
@extends('layouts.app')

@section('content')
<h2>Create Student</h2>
<form action="{{ route('students.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Course</label>
        <select name="course_id" class="form-control">
            <option value="">Sin curso</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
```

### 6.4 Directives Blade més comunes
```php
// Mostrar dades
{{ $variable }}                          // Escapada (segura)
{!! $variable !!}                        // Sense escapar (HTML)

// Estructures de control
@if ($condition)
    ...
@elseif ($other)
    ...
@else
    ...
@endif

@foreach ($items as $item)
    ...
@endforeach

@forelse ($items as $item)
    ...
@empty
    <p>No items</p>
@endforelse

// Formularis
@csrf                                     // Token CSRF
@method('PUT')                            // Method spoofing

// Herència
@extends('layouts.app')                   // Estendre layout
@section('content')                       // Definir secció
@yield('content')                         // Mostrar secció

// Inclusió
@include('partials.header')               // Incloure vista
```

---

## 7. API REST

### 7.1 Definir rutes API
Fitxer: `routes/api.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentApiController;
use App\Http\Controllers\API\CourseApiController;

// CRUD complet per Students
Route::apiResource('students', StudentApiController::class);

// Rutes addicionals
Route::post('students/{id}/assign-course', [StudentApiController::class, 'assignCourse']);
Route::delete('students/{id}/remove-course', [StudentApiController::class, 'removeCourse']);

// CRUD complet per Courses
Route::apiResource('courses', CourseApiController::class);
```

### 7.2 StudentApiController
Fitxer: `app/Http/Controllers/API/StudentApiController.php`

```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentApiController extends Controller
{
    // GET /api/students - Llistar tots
    public function index()
    {
        $students = Student::with('course')->get();
        return response()->json($students);
    }

    // POST /api/students - Crear nou
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'age' => 'required|integer',
            'course_id' => 'nullable|exists:courses,id'
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    // GET /api/students/{id} - Mostrar un
    public function show($id)
    {
        $student = Student::with('course')->findOrFail($id);
        return response()->json($student);
    }

    // PUT/PATCH /api/students/{id} - Actualitzar
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:students,email,' . $id,
            'age' => 'integer',
        ]);

        $student->update($validated);
        return response()->json($student);
    }

    // DELETE /api/students/{id} - Eliminar
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }

    // POST /api/students/{id}/assign-course - Assignar curs
    public function assignCourse(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $student->update(['course_id' => $validated['course_id']]);
        return response()->json($student->load('course'));
    }

    // DELETE /api/students/{id}/remove-course - Eliminar curs
    public function removeCourse($id)
    {
        $student = Student::findOrFail($id);
        $student->update(['course_id' => null]);
        return response()->json($student);
    }
}
```

### 7.3 Provar l'API amb cURL o Postman

```bash
# Llistar tots els estudiants
curl http://localhost:8000/api/students

# Crear un estudiant
curl -X POST http://localhost:8000/api/students \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","age":25}'

# Mostrar un estudiant
curl http://localhost:8000/api/students/1

# Actualitzar un estudiant
curl -X PUT http://localhost:8000/api/students/1 \
  -H "Content-Type: application/json" \
  -d '{"name":"John Smith","age":26}'

# Eliminar un estudiant
curl -X DELETE http://localhost:8000/api/students/1

# Assignar curs
curl -X POST http://localhost:8000/api/students/1/assign-course \
  -H "Content-Type: application/json" \
  -d '{"course_id":1}'
```

### 7.4 Codis de resposta HTTP
- **200 OK**: Petició exitosa
- **201 Created**: Recurs creat
- **204 No Content**: Acció exitosa sense contingut de resposta
- **400 Bad Request**: Dades incorrectes
- **404 Not Found**: Recurs no trobat
- **422 Unprocessable Entity**: Validació fallida
- **500 Internal Server Error**: Error del servidor

---

## 8. Exportació de Dades (Excel)

### 8.1 Instal·lar Laravel Excel
```bash
composer require maatwebsite/excel
```

### 8.2 Crear classe Export
```bash
php artisan make:export StudentsExport --model=Student
```

### 8.3 StudentsExport
Fitxer: `app/Exports/StudentsExport.php`

```php
<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    // Definir les dades a exportar
    public function collection()
    {
        return Student::with('course')->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'age' => $student->age,
                'course' => $student->course ? $student->course->name : 'Sin curso',
            ];
        });
    }

    // Definir les capçaleres
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Age',
            'Course',
        ];
    }
}
```

### 8.4 Afegir ruta d'exportació
Fitxer: `routes/web.php`

```php
Route::get('/students/export', [StudentsController::class, 'export'])
    ->name('students.export');
```

### 8.5 Configuració Excel
Fitxer: `config/excel.php` - Configuració per defecte del paquet

---

## 9. Factories i Seeders

### 9.1 Crear Factories
```bash
php artisan make:factory StudentFactory --model=Student
php artisan make:factory TeacherFactory --model=Teacher
php artisan make:factory CourseFactory --model=Course
```

### 9.2 StudentFactory
Fitxer: `database/factories/StudentFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'age' => $this->faker->numberBetween(18, 30),
            'course_id' => \App\Models\Course::inRandomOrder()->first()?->id,
        ];
    }
}
```

### 9.3 TeacherFactory
Fitxer: `database/factories/TeacherFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'subject' => $this->faker->randomElement(['Mathematics', 'Physics', 'Chemistry', 'History']),
            'phone' => $this->faker->numberBetween(600000000, 699999999),
        ];
    }
}
```

### 9.4 CourseFactory
Fitxer: `database/factories/CourseFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Web Development',
                'Data Science',
                'Mobile Development',
                'DevOps',
                'UI/UX Design'
            ]),
            'teacher_id' => \App\Models\Teacher::inRandomOrder()->first()?->id,
        ];
    }
}
```

### 9.5 DatabaseSeeder
Fitxer: `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 5 professors
        Teacher::factory()->count(5)->create();
        
        // Crear 10 cursos
        Course::factory()->count(10)->create();
        
        // Crear 15 estudiants
        Student::factory()->count(15)->create();
    }
}
```

### 9.6 Executar Seeders
```bash
# Executar tots els seeders
php artisan db:seed

# Executar un seeder específic
php artisan db:seed --class=DatabaseSeeder

# Refrescar BD i executar seeders
php artisan migrate:fresh --seed
```

---

## 10. Desplegament

### 10.1 Preparació per producció

#### 10.1.1 Optimitzar configuració
```bash
# Cache de configuració
php artisan config:cache

# Cache de rutes
php artisan route:cache

# Cache de vistes
php artisan view:cache

# Optimitzar autoload de Composer
composer install --optimize-autoloader --no-dev
```

#### 10.1.2 Compilar assets
```bash
# Compilar per producció
npm run build
```

#### 10.1.3 Configurar .env per producció
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudomini.com

DB_CONNECTION=mysql
DB_HOST=tu_servidor_bd
DB_PORT=3306
DB_DATABASE=prod_database
DB_USERNAME=prod_user
DB_PASSWORD=contrasenya_segura
```

### 10.2 Desplegament amb servidor tradicional (Apache/Nginx)

#### 10.2.1 Configuració Apache
```apache
<VirtualHost *:80>
    ServerName tudomini.com
    DocumentRoot /var/www/laravelproject/public

    <Directory /var/www/laravelproject/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

#### 10.2.2 Configuració Nginx
```nginx
server {
    listen 80;
    server_name tudomini.com;
    root /var/www/laravelproject/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

#### 10.2.3 Permisos
```bash
# Donar permisos d'escriptura
sudo chown -R www-data:www-data /var/www/laravelproject
sudo chmod -R 755 /var/www/laravelproject
sudo chmod -R 775 /var/www/laravelproject/storage
sudo chmod -R 775 /var/www/laravelproject/bootstrap/cache
```

### 10.3 Desplegament amb Laravel Forge

1. Crear servidor a [Laravel Forge](https://forge.laravel.com)
2. Connectar repositori Git
3. Configurar variables d'entorn
4. Executar script de desplegament:

```bash
cd /home/forge/tudomini.com
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm ci
npm run build
```

### 10.4 Desplegament amb Docker

#### 10.4.1 Dockerfile
```dockerfile
FROM php:8.2-fpm

# Instal·lar extensions PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instal·lar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directori de treball
WORKDIR /var/www

# Copiar fitxers
COPY . .

# Instal·lar dependències
RUN composer install --optimize-autoloader --no-dev

# Permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

#### 10.4.2 docker-compose.yml
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: laravel-app
    volumes:
      - .:/var/www
    depends_on:
      - db
    networks:
      - laravel

  nginx:
    image: nginx:alpine
    container_name: laravel-nginx
    ports:
      - "80:80"
    volumes:
      - .:/var/www
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - laravel

  db:
    image: mysql:8.0
    container_name: laravel-db
    environment:
      MYSQL_DATABASE: laravelproject
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - laravel

volumes:
  dbdata:

networks:
  laravel:
```

#### 10.4.3 Executar amb Docker
```bash
# Construir i executar
docker-compose up -d

# Executar migracions
docker-compose exec app php artisan migrate

# Executar seeders
docker-compose exec app php artisan db:seed
```

### 10.5 Desplegament amb Heroku

```bash
# Instal·lar Heroku CLI
# Crear aplicació
heroku create nom-app

# Afegir buildpack PHP
heroku buildpacks:set heroku/php

# Configurar base de dades
heroku addons:create cleardb:ignite

# Configurar variables d'entorn
heroku config:set APP_KEY=$(php artisan key:generate --show)
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false

# Crear Procfile
echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile

# Deploy
git push heroku main

# Executar migracions
heroku run php artisan migrate --force
```

### 10.6 Checklist de desplegament

- [ ] Configurar `.env` per producció
- [ ] Generar `APP_KEY`
- [ ] Configurar base de dades de producció
- [ ] Executar migracions: `php artisan migrate --force`
- [ ] Cache de configuració: `php artisan config:cache`
- [ ] Cache de rutes: `php artisan route:cache`
- [ ] Cache de vistes: `php artisan view:cache`
- [ ] Compilar assets: `npm run build`
- [ ] Optimitzar Composer: `composer install --optimize-autoloader --no-dev`
- [ ] Configurar permisos de `storage` i `bootstrap/cache`
- [ ] Configurar servidor web (Apache/Nginx)
- [ ] Configurar HTTPS amb certificat SSL
- [ ] Configurar backups de base de dades
- [ ] Configurar logs i monitorització

---

## Comandes Artisan útils

```bash
# Servidor de desenvolupament
php artisan serve

# Migracions
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:fresh --seed

# Models, Controllers, etc.
php artisan make:model NomModel
php artisan make:controller NomController
php artisan make:migration create_nom_table
php artisan make:factory NomFactory
php artisan make:seeder NomSeeder

# Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Informació
php artisan route:list
php artisan about
php artisan tinker
```

---

## Recursos addicionals

- **Documentació oficial**: [https://laravel.com/docs](https://laravel.com/docs)
- **Laracasts**: [https://laracasts.com](https://laracasts.com)
- **Laravel News**: [https://laravel-news.com](https://laravel-news.com)
- **Repositori GitHub**: [https://github.com/laravel/laravel](https://github.com/laravel/laravel)

---

**Aquesta guia cobreix tot el procés de desenvolupament d'una aplicació Laravel, des de la instal·lació fins al desplegament en producció.**
