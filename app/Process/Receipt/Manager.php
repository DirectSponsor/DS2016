<?php

/**
 * This file is part of Direct Sponsor Accounts
 *
 * @copyright Copyright (c) 2015 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */

namespace app\Process\Receipt;

use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Receipt as ReceiptTrans;
use App\Models\ProjectMember;
use App\Models\RecipientMember as RecipientMember;
use app\Models\CoordinatorMember as CoordinatorMember;
use App\Models\SponsoredRecipient;


/**
 * Description of Manager
 *
 * @author Paul McGarry <mcgarryit@gmail.com>
 */
class Manager {

    public function __construct() {

    }

    public function getPending($projectId=0, $memberId=0) {
        if ($memberId == 0) {
            return $this->getProjectPending($projectId);
        } else {
            return $this->getMemberPending($memberId);
        }
    }

    private function getProjectPending($projectId) {
        $project = Project::find($projectId);
        return $project->getPaymentsDue();
    }

    private function getMemberPending($projectMemberId) {
        $projectMember = ProjectMember::find($projectMemberId);
        $projectMemberRole = $projectMember->castMemberRole();
        return $projectMemberRole->receiptsDue();
    }

    public function initialiseFirstSponsorProjectPayment(SponsoredRecipient $sponsoredRecipient) {
        $receiptTrans = new ReceiptTrans();
        DB::transaction(function() use($sponsoredRecipient, $receiptTrans){
            $receiptTrans->project_member_id = $sponsoredRecipient->recipient_member_id;
            $receiptTrans->sender_member_id = $sponsoredRecipient->project_member_id;
            $receiptTrans->trans_type = 'Receipt';
            $receiptTrans->description = 'First payment from Sponsor';
            $receiptTrans->euro_amount = $sponsoredRecipient->euro_amount_promised;
            $receiptTrans->due_date = $sponsoredRecipient->next_due;
            $receiptTrans->month = $receiptTrans->due_date->format('M');
            $receiptTrans->save();
        });
        return $receiptTrans;
    }

    public function processAcceptedPaymentRecipient($receiptId=0, $amount=0) {
        $response = [
            'result'=>'true',
            'text' => "text describing result"
                ];
        $receipt = ReceiptTrans::where('id', $receiptId)
                ->where('status', '<>', 'Confirmed')
                ->first();
        if (!$receipt) {
            $response['result'] = 404;
            $response['text'] = 'Receipt Not Found';
            return $response;
        }
        DB::transaction(function() use($receipt) {
            $receipt->setStatusConfirmed();
            /*
             *  Create a group funds payment to coordinator from this recipient
             */
            /* @var $recipientMember RecipientMember */
            $recipientMember = $receipt->recipient;
            $coordinatorMember = $recipientMember->project->getCoordinator(true);
            $this->newPaymentForCoordinator($recipientMember, $coordinatorMember, $receipt);

            /*
             *  The recipient accepts payment from sponsor,
             *  - Update next payment date for this sponsor for this project
             *  - Create next months pending payment for Recipient
             */
            $monthEndDate = $this->setNextPayDateForSponsor($receipt);
            $this->newMonthPayment($receipt, $monthEndDate);
        });
        $response['text'] = "Transaction from ".$receipt->senderName()." - Confirmed for amount of ".$amount;
        return $response;
    }

    private function setNextPayDateForSponsor(ReceiptTrans $receipt) {
        $sponsoredRecipient = SponsoredRecipient::where('project_member_id', '=', $receipt->sender_member_id)
                ->where('recipient_member_id', '=', $receipt->project_member_id)
                ->first();
        if ($sponsoredRecipient) {
            $sponsoredRecipient->setNextPaymentDueFromSponsor();
            $sponsoredRecipient->save();
            return $sponsoredRecipient->next_due;
        } else {
            abort(404, 'System Error : A valid Sponsor->Recipient relationship could not be found.');
        }
    }

    private function newPaymentForCoordinator(RecipientMember $recipientMember, CoordinatorMember $coordinatorMember, ReceiptTrans $receipt) {
        $data = array(
                'sender_member_id' => $recipientMember->id,
                'project_member_id' => $coordinatorMember->id,
                'trans_type' => 'Fund Receipt',
                'status' => 'Pending',
                'due_date' => $receipt->due_date
                );
        $newReceipt = new ReceiptTrans();
        $formattedData = $newReceipt->formatTransData($data);
        return $newReceipt->initialiseData($formattedData)->save();
    }

    private function newMonthPayment(ReceiptTrans $receipt, $nextMonthEndDate) {
        $data = array(
                'sender_member_id' => $receipt->sender_member_id,
                'project_member_id' => $receipt->project_member_id,
                'trans_type' => 'Receipt',
                'status' => 'Pending',
                'due_date' => $nextMonthEndDate
                );
        $newReceipt = new ReceiptTrans();
        $formattedData = $newReceipt->formatTransData($data);
        return $newReceipt->initialiseData($formattedData)->save();
    }

    private function newFirstMonthPayment($monthEndDate, $senderId, $receiverId) {
        $data = $this->formatTransData(
                $senderId,
                $receiverId,
                'Receipt',
                'Pending',
                $monthEndDate
                );
        $this->newPayment($data);
        return true;
    }

    private function newPayment($data) {
        $payment = new Transaction($data);
        $payment->save();
        return true;
    }


}
