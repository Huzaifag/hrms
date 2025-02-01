# 2024-12-08

## 1. Creating a Multi-Auth-System
**Install Breeze**
```bash
composer require laravel/breeze --dev
```
**Install Breeze**
```bash
php artisan breeze:install
```
**Modify the migration(users table)**
```php
Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role')->default(1); // 1: admin, 2: manager, 3: hr, 4: employee
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
    $table->timestamps();
});
```
**Run the migration**
```bash
php artisan migrate
```

**Create view**
```bash
php artisan make:view admin.dashboard
php artisan make:view employee.dashboard
php artisan make:view hr.dashboard
php artisan make:view manager.dashboard
```

**Create routes**
```php
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::view('manager/dashboard', 'manager.dashboard')
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.dashboard');

Route::view('hr/dashboard', 'hr.dashboard')
    ->middleware(['auth', 'verified', 'hr'])
    ->name('hr.dashboard');

Route::view('employee/dashboard', 'employee.dashboard')
    ->middleware(['auth', 'verified', 'employee'])
    ->name('employee.dashboard');
```
**Create middlewares**
```bash
php artisan make:middleware AdminMiddleware
php artisan make:middleware ManagerMiddleware
php artisan make:middleware HrMiddleware
php artisan make:middleware EmployeeMiddleware
```
**Modify the middleware**
```php
public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::check()){
            return redirect()->route('login');
        }
        $userRole = Auth::user()->role;
        if($userRole == 1){
            return $next($request);
        }
        if($userRole == 2){
            return redirect()->route('manager.dashboard');
        }
        if($userRole == 3){
            return redirect()->route('hr.dashboard');
        }
        if($userRole == 4){
            return redirect()->route('employee.dashboard');
        }
    }
```
**Declare the middleware bootstrap>app.php**
```php
$middleware->alias([
            'admin' => AdminMiddleware::class,
            'manager' => ManagerMiddleware::class,
            'hr' => HrMiddleware::class,
            'employee' => EmployeeMiddleware::class,
        ]);
```

**Modify the views>livewire>layout>pages>login.blade.php**

```php
$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();
    $userRole = Auth::user()->role;
    switch($userRole){
        case 1:
        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
            break;
        case 2:
            $this->redirectIntended(default: route('manager.dashboard', absolute: false), navigate: true);
            break;
        case 3:
            $this->redirectIntended(default: route('hr.dashboard', absolute: false), navigate: true);
            break;
        case 4:
            $this->redirectIntended(default: route('employee.dashboard', absolute: false), navigate: true);
            break;
        default:
            return redirect('/');
    }


};
```



