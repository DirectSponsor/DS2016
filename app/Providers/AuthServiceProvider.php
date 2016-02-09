<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use app\Models\Transaction;
use App\Models\Project;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('create-project', function ($user) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            return false;
        });

        $gate->define('update-project', function ($user, $projectId) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            $project = Project::find($projectId);
            if (!$project) {
                return false;
            }
            $coordinator = $project->coordinator();
            if (!$coordinator) {
                return false;
            }
            if ($coordinator->userRole->user_id == $user->id) {
                return true;
            }
            return false;
        });

        $gate->define('update-transaction', function ($user, $transactionId) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            $transaction = Transaction::find($transactionId);
            if (!$transaction) {
                return false;
            }
            if ($transaction->projectMember->userRole->user_id == $user->id) {
                return true;
            }
            $coordinator = $transaction->project()->coordinator();
            if (!$coordinator) {
                return false;
            }
            if ($coordinator->userRole->user_id == $user->id) {
                return true;
            }
            return false;
        });

    }
}
