<?php

/**
 * This file is part of Direct Sponsor Accounts
 *
 * @copyright Copyright (c) 2015 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */

namespace app\Process\Support;

use Illuminate\Support\Facades\DB;
use App\Models\Project as Project;
use App\Models\User;
use App\Models\CoordinatorMember;
use App\Models\SponsorMember;
use App\Models\RecipientMember;
use App\Models\ProjectMember;
use App\Models\SponsoredRecipient;
use App\Process\Receipt\Manager as ReceiptManager;


/**
 * Description of Manager
 *
 * @author Paul McGarry <mcgarryit@gmail.com>
 */
class Manager {

    private $project;

    public function __construct(Project $project) {
        $this->project = $project;
    }

    public function getSupportAmountsAvailable() {
        $requiredSupport = [];
        $amounts = [];
        if ($this->project->isFullySupported()) {
            return $amounts;
        }
        foreach($this->project->getRecipients(true) as $recipientMember) {
            $requiredSupport[] = $recipientMember->getSupportRequired();
        }

        $minEuroAmt = $this->project->getMinEuroAmountPerRecipient();

        foreach($requiredSupport as $supportAmount) {
            $multiplier = 1;
            while(($minEuroAmt * $multiplier) <= $supportAmount) {
                $possibleAmt = (int) floor($minEuroAmt * $multiplier);

                if (!array_key_exists($possibleAmt, $amounts)) {
                    $amounts[$possibleAmt] = $possibleAmt;
                }

                $multiplier +=1;
            }
        }
        return $amounts;
    }

    public function createSupportedRecipient(User $user, $amount_promised_euro) {
        $sponsorMember = $user->isSponsorOfProject($this->project->id);
        if (!$sponsorMember) {
           $sponsorMember = $this->project->addMemberToProject($user->getSponsorRole());
        }
        $selectedRecipient = $this->selectRecipient($amount_promised_euro);
        $this->supportRecipient($sponsorMember, $selectedRecipient, $amount_promised_euro);
        return $selectedRecipient;
    }

    private function selectRecipient($amount_promised_euro=0) {
        if ($this->project->isFullySupported()) {
            return false;
        }
        if ($this->project->status === 'Budget Building') {
            return $this->selectCoordinatorAsRecipient();
        } else {
            return $this->selectFromRecipients($amount_promised_euro);
        }
    }

    private function selectCoordinatorAsRecipient() {
        $coordinator = $this->project->getCoordinator(true);
        if ($coordinator instanceof CoordinatorMember) {
            return $coordinator;
        } else {
            abort(404, 'Apologies - There are no suitable recipients for this project.');
        }
    }

    private function selectFromRecipients($amount_promised_euro=0) {
        $selectedRecipient = null;
        $selectedRecipientSupportRequired = 0;

        foreach($this->project->getRecipients(true) as $recipientMember) {
            if ($recipientMember->getSupportRequired() < $amount_promised_euro) {
                continue;
            }
            if ($recipientMember->getSupportRequired() > $selectedRecipientSupportRequired) {
                $selectedRecipient = $recipientMember;
                $selectedRecipientSupportRequired = $recipientMember->getSupportRequired();
            }
        }
        return $selectedRecipient;
    }

    private function supportRecipient(SponsorMember $sponsor, ProjectMember $recipient, $amount_promised_euro=0) {
        $sponsoredRecipient = $sponsor->isAlreadySponsoringRecipient($recipient);

        if (!$sponsoredRecipient) {
            $sponsoredRecipient = $this->createNewSponsorship($sponsor, $recipient, $amount_promised_euro);
        } else {
            $sponsoredRecipient->euro_amount_promised = $sponsoredRecipient->euro_amount_promised + $amount_promised_euro;
            $sponsoredRecipient->save();
        }
        return $this;
    }

    public function createNewSponsorship(SponsorMember $sponsor, ProjectMember $recipient, $amount_promised_euro=0) {
        $sponsoredRecipient = new SponsoredRecipient();

        DB::transaction(function() use($sponsoredRecipient, $sponsor, $recipient, $amount_promised_euro){
            $sponsoredRecipient->initialiseNew($sponsor, $recipient, $amount_promised_euro);
            $sponsoredRecipient->save();

            $receiptManager = new ReceiptManager();
            $receiptManager->initialiseFirstSponsorProjectPayment($sponsoredRecipient);
        });

        return $sponsoredRecipient;
    }
}
