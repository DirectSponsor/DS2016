<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App as app;

use View;
use Session;
use Auth;


class DirectSponsorBaseController extends Controller {

    public $layout = 'layouts.cpanel';

    protected function setupLayout() {

    }

    protected function render($view, $title = false, $data = array()) {
        $l = $this->layout;
        $this->layout = View::make($this->layout);
        $this->setLinksForLayout();
        $app = app::getFacadeApplication();
        if ($title) {
            $this->layout->title = $title;
        }
        if (Session::has('error')) {
            $this->layout->error = Session::get('error');
            Session::forget('error');
        }
        if (Session::has('status')) {
            $this->layout->status = Session::get('status');
            Session::forget('status');
        }
        if (Session::has('success')) {
            $this->layout->success = Session::get('success');
            Session::forget('success');
        }
        if (Session::has('info')) {
            $this->layout->info = Session::get('info');
            Session::forget('info');
        }
        // General Messages:
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->account_type == 'Sponsor') {
                $sponsor = $user->sponsor;
                if ($sponsor->hasNotPaidProjects()) {
                    $this->layout->notification = 'Some of your promised payments are overdue. Please send payments as soon as possible !';
                }
            }
        }

        $this->layout->content = View::make($view)->with($data);
    }

    private function setLinksForLayout() {
        /* Views Composers */
        // Navigation
        $links = array();

        if(Auth::check()){
            $user = Auth::user();
            if ($user->hasMultipleRoles()) {
                abort("404", "Multiple Roles - Fix System to Select Active Role");
            } else {
                $role = $user->roles()->first();
                $projectMember = $user->projectMemberships()->where("role_id", $role->id)->first();
            }
            switch($role){
                case 'Administrator':
                    $links = array(
                        array(
                            'name' => 'Project(s)',
                            'link' => route('projects.index'),
                            'page' =>'projects'
                        ),
                        array(
                            'name' => 'Invitations',
                            'link' => route('invitations.sponsors'),
                            'page' =>'invitations'
                        ),
                        array(
                            'name' => 'My Account',
                            'link' => route('users.edit',$user->id),
                            'page' =>'myaccount'
                        ),
                        array(
                            'name' => 'Logout',
                            'link' => route('logout'),
                            'page' =>'logout'
                        )
                    );
                    break;
                case 'Coordinator' :
                    $links = array(
                        array(
                            'name' => 'Project(s)',
                            'link' => route('projects.index', $projectMember->project_id),
                            'page' =>'projects'
                        ),
                        array(
                            'name' => 'Invitations',
                            'link' => route('invitations.index', $projectMember->project_id),
                            'page' =>'invitations'
                        ),
                        array(
                            'name' => 'My Account',
                            'link' => route('users.edit',$user->id),
                            'page' =>'myaccount'
                        ),
                        array(
                            'name' => 'Logout',
                            'link' => route('logout'),
                            'page' =>'logout'
                        )
                    );
                    break;
                case 'Recipient' :
                    $links = array(
                        array(
                            'name' => 'Project(s)',
                            'link' => route('projects.index', $projectMember->project_id),
                            'page' =>'projects'
                        ),
                        array(
                            'name' => 'My Account',
                            'link' => route('users.edit',$user->id),
                            'page' =>'myaccount'
                        ),
                        array(
                            'name' => 'Logout',
                            'link' => route('logout'),
                            'page' =>'logout'
                        )
                    );
                    break;
                case 'Sponsor' :
                default:
                    $links = array(
                        array(
                            'name' => 'Project(s)',
                            'link' => route('projects.index', $projectMember->project_id),
                            'page' =>'projects'
                        ),
                        array(
                            'name' => 'My Account',
                            'link' => route('users.edit',$user->id),
                            'page' =>'myaccount'
                        ),
                        array(
                            'name' => 'Logout',
                            'link' => route('logout'),
                            'page' =>'logout'
                        )
                    );
                    break;
            }
        }
        $this->layout->links = $links;
    }
}
