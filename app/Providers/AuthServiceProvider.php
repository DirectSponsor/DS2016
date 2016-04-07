<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Transaction;
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
            if ($user->isAdministrator()) {
                return true;
            }
            return false;
        });

        $gate->define('admin-project', function ($user) {
            if ($user->isAdministrator()) {
                return true;
            }
            if ($user->isCoordinator()) {
                return true;
            }
            return false;
        });

        $gate->define('update-project', function ($user, $projectId) {
            if ($user->isAdministrator()) {
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

        $gate->define('valid-sponsor', function ($user) {
            if ($user->isSponsor()) {
                return true;
            }
            return false;
        });

        $gate->define('sponsor-project', function ($user, $projectId) {
            if ($user->isSponsorOfProject($projectId)) {
                return true;
            }
            return false;
        });

        $gate->define('update-transaction', function ($user, $transactionId) {
            if ($user->isAdministrator()) {
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
