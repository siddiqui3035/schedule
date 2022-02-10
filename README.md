1. Create a laravel file and create a database.
2. Create authentication.
3. add last_login fiend in user table.
4. run php artisan migrate.
5. check user databse by php artisan tinker -> App\Models\User::all();
6. add last_login in user model fillable array.

7. add last_login save process on App\Http\Controller\Auth\AuthenticatedSessionController 

    public function store(LoginRequest $request)
        {
            $request->authenticate();

            $user = auth()->user();

            $user->last_login = Carbon::now();
            $user->save();

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

8. Create a artisan command for scheduleing 

    php artisan make:command EmailInactiveUsers 

9. add created command signiture and discription.

    protected $signature = 'email:inactive-users';

    protected $description = 'Email Inactive Users';

10. add logic on handel() method.

    public function handle()
    {
        $limit = Carbon::now()->subDay(7);

        $inactive_users = User::where('last_login', '<', '2022-02-10 09:00:00')->get();

        foreach($inactive_users as $user)
        
        {
            $user->notify(new NotifyInactiveUser());
            $this->info('Email send to' .$user->email);
        }
        
        // $this->info($limit);
        // return 0;
    }
11. Now create a notification for email tamplate

    php artisan make:notification NotifyInactiveUser

    now implement (implements ShouldQueue) on Notification class.

12. Go to App\Console\kernel.php file and register artisan command

    protected $commands =[

        EmailInactiveUsers::class,
    ];

13. Add schedule command on schedule function

    protected function schedule(Schedule $schedule)

    {
        $schedule->command('email:inactive-users')->hourlyAt(17);
    }

14. Now run schedule for make it autometically.
    php artisan schedule:work




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
