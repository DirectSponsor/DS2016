<?php
namespace App\Http\Controllers;

use app\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\Receipt;
use App\Process\Receipt\Manager as ReceiptManager;


class TransactionsController extends DirectSponsorBaseController {

    protected $receiptManager;

    public function __construct(ReceiptManager $manager){
        $this->middleware('auth', array('only' => array(
                'index', 'myTransactions', 'accept', 'reject', 'add', 'save'
        )));
        $this->receiptManager = $manager;
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

    public function pendingReceipts($projectId=0, $memberId=0) {
        $project = Project::find($projectId);
        $receipts = $this->receiptManager->getPending($projectId, $memberId);
        return view('transactions.list_receipts',
                array('project' => $project,
                    'enableSupport' => true,
                    'receipts' => $receipts));
    }

    public function confirmReceipt(Request $request, ReceiptManager $manager, $receiptId) {
        $response = $manager->processAcceptedPaymentRecipient($receiptId, $request->amount);
        if($response['result'] == 404) {
            http_response_code(404);
        }
        echo json_encode($response);
    }

    public function confirmLate() {

    }

}
