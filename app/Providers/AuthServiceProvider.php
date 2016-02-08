<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Certbody;
use App\Models\Producer;

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

        $gate->define('update-producer', function ($user, $producerId) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            $producer = Producer::find($producerId);
            if (!$producer) {
                return false;
            }
            if ($producer->producer_user_id == $user->id) {
                return true;
            }
            if ($producer->certbody_id == $user->certbody_id) {
                return true;
            }
            return false;
        });

        $gate->define('add-certbody', function ($user) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            return false;
        });

        $gate->define('update-certbody', function ($user, Certbody $certbody) {
            if ($user->isSiteAdmin()) {
                return true;
            }
            if (!$user->isCertbodyAdmin()) {
                return false;
            }
            if ($certbody->id == $user->certbody_id) {
                return true;
            }
            return false;
        });

    }
}
