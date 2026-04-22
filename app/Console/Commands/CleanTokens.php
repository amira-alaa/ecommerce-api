<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;

class CleanTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Old Tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // PersonalAccessToken::where('created_at', '<', now()->subDay())->delete();

        // $this->info('Old tokens deleted successfully');

        $users = \App\Models\User::with('tokens')->get();

        foreach ($users as $user) {
            if ($user->tokens->count() > 1) {
                $latestToken = $user->tokens()->latest()->first();

                $user->tokens()
                    ->where('id', '!=', $latestToken->id)
                    ->delete();
            }
        }

        $this->info('Extra tokens removed');
    }
}
