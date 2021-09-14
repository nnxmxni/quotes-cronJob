<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SendMail;

class WeeklyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive quote to everyone weekly via email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $quotes = [
            'mahatma Ghandi' => 'Live as if you were to die tomorrow. Learn as if you were to live forever.',
            'Friedrich Nietzsche' => 'That which does not kill us makes us stronger.',
            'Theodore Roosevelt' => 'Do what you can, with what you have, where you are.',
            'Oscar Wilde' => 'Be yourself; everyone else is already taken',
            'William Shakespeare' => 'This above all: to thine own self be true',
            'Napoleon Hill' => 'If you cannot do great things, do small things in great way',
            'Milton Berle' => "If opportunity doesn't knock, build a door.", 
        ];

        $key = array_rand($quotes);
        $data = $quotes[$key];
        
        $users = User::all();

        foreach ($users as $user){
            Mail::raw("{$key} -> {$data}", function($mail) use ($user){
                 $mail->from('ushebaresources@gmail.com', 'Take a Breather');
                 $mail->to($user->email)
                        ->subject('Keep it moving...');
            });
        }

           $this->info('Successfully send weekly quote to everyone');

    }
}
