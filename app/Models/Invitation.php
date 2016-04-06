<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DirectSponsorBaseModel;
use App\Models\MailerDS as Mailer;
use App\Models\CoordinatorMember;


class Invitation extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invitation';

    protected $guarded = array();

    protected $fillable = array('email', 'role_type', 'processed');

    protected $mailer;

    public function project() {
        return $this->belongsTo("App\Models\Project");
    }

    public function saveData(Request $request, $projectId) {
        $project = Project::find($projectId);
        if ($request->role_type === 'Coordinator') {
            $coordinator = $project->getCoordinator(true);
            if ($coordinator instanceof CoordinatorMember) {
                $coordinator->status = 'Cancelled';
                $coordinator->save();
            }
        }
        if ($project->isFullySupported()) {
            abort("403", "The maximum number of recipients have already been assigned to this project");
        }
        DB::transaction(function() use($request, $project) {
            $this->fill($request->all());
            /*
             * Link Project
             */
            $this->project()->associate($project);
            $this->save();
        });
        return $this;
    }

    public function send() {
        $this->getMailer()->sendInvitation($this);
        return $this;
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }
}
