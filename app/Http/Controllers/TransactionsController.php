<?php
namespace app\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Session;

use App\Models\Transaction;


class TransactionsController extends DirectSponsorBaseController {
    public function __construct(){
        $this->middleware('auth', array('only' => array(
                'index', 'myTransactions', 'accept', 'reject', 'add', 'save'
        )));
    }

    public function index(){
        if (Auth::user()->account_type != 'Admin') {
            return redirect()->route('myTransactions');
        }
        $payments = Transaction::all();
        $this->render('payments.index','Transactions',array(
            'payments' => $payments
        ));
        return $this->layout;
    }

    public function myTransactions(){
        $user = Auth::user();
        switch($user->account_type){
            case 'Admin' :
                return redirect()->route('payments.index');
            case 'Coordinator' :
                $payments = $user->account->receivedPayments;
                $this->render('payments.index','Received Transactions',array(
                    'payments' => $payments
                ));
                return $this->layout;
            case 'Recipient' :
                $payments = $user->account->receivedPayments;
                $this->render('payments.recipient_view','Received Transactions',array(
                    'payments' => $payments
                ));
                return $this->layout;
            case 'Sponsor' :
                $payments = $user->account->payments;
                $this->render('payments.index','My Transactions',array(
                    'payments' => $payments
                ));
                return $this->layout;
            default:
                abort(404, 'Account Type could not be identified');
        }
    }

    public function accept($id){
        return response()->json(array('result'=>'error', 'errors' => array('Something is wrong', 'Really Wrong')));
        $payment = Transaction::find($id);
        if(is_null($payment)) {
            return response()->json(array('result'=>'Payment Not Found'));
        }
        $user = Auth::user();

        if($user->account_type == 'Admin' || $user->account_type == 'Sponsor') {
            return response()->json(array('result'=>'Not Authorised'));
        }
        if($user->id == $payment->receiver_id) {
            //continue;
        } else {
            if($user->id != $payment->project->coordinator->user_id) {
                return response()->json(array('result'=>'Not Authorised'));
            }
        }

        if($payment->receiver->account_type == 'Coordinator'){
            $payment->processAcceptedPaymentCoordinator();
            Session::put('success','Transaction was successfuly confirmed !');
            return response()->json(array('result'=>'success'));
        } else {
            $payment->processAcceptedPaymentRecipient();
            Session::put('success','Transaction was successfuly confirmed !');
            Session::put('info','Please make sure you sent the group fund commission to coordinator !');
            return response()->json(array('result'=>'success'));
        }
    }

    public function late($id) {
        $payment = Transaction::find($id);
        if(is_null($payment)) {
            return response()->json(array('result'=>'Payment Not Found'));
        }
        $user = Auth::user();

        if($user->account_type == 'Admin' || $user->account_type == 'Sponsor') {
            return response()->json(array('result'=>'Not Authorised'));
        }
        if($user->id == $payment->receiver_id) {
            //continue;
        } else {
            if($user->id != $payment->project->coordinator->user_id) {
                return response()->json(array('result'=>'Not Authorised'));
            }
        }

        $payment->markLate();
        Session::put('info','Thank you.  Your Sponsor for this payment will be sent a reminder!');
        return response()->json(array('result'=>'success'));
    }
}
