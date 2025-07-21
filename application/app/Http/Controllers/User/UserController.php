<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\Review;
use App\Models\Deposit;
use App\Models\Product;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $userBalace = $user->balance;
        $ordersCount = Order::where('user_id', $user->id)->count();
        $productCount = Product::where('user_id', $user->id)->count();

        // Monthly Deposit & Withdraw Report Graph
        $deposits = Deposit::selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name")
            ->orderByRaw('MIN(created_at)')
            ->whereYear('created_at', date('Y'))
            ->where('user_id', $user->id)
            ->whereStatus(1)
            ->groupByRaw("MONTHNAME(created_at)")
            ->pluck('amount', 'month_name');

        $depositsChart['labels'] = $deposits->keys();
        $depositsChart['values'] = $deposits->values();

        $withdrawalsReport = Withdrawal::selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name")
            ->orderByRaw('MIN(created_at)')
            ->whereYear('created_at', date('Y'))
            ->where('user_id', $user->id)
            ->whereStatus(1)
            ->groupByRaw("MONTHNAME(created_at)")
            ->pluck('amount', 'month_name');

        $withdrawalsChart['labels'] = $withdrawalsReport->keys();
        $withdrawalsChart['values'] = $withdrawalsReport->values();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'userBalace', 'ordersCount', 'productCount', 'depositsChart', 'withdrawalsChart'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx', $request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx', $request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type', $request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark', $request->remark);
        }

        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function reviewStore(Request $request)
    {
        $auth = auth()->user();
        $product_id = $request->product_id;
        $product = Product::findOrFail($product_id);

        $existingReview = Review::where('user_id', $auth->id)
            ->where('product_id', $product_id)
            ->first();

        if ($existingReview) {
            $notify[] = ['error', 'You have already submitted a review for this product'];
            return back()->withNotify($notify);
        }

        $isOrder = Order::where('user_id', $auth->id)
            ->where('status', 1)
            ->where('product_id', $product_id)
            ->exists();

        if (!$isOrder) {
            $notify[] = ['error', 'Please purchase this product first before reviewing it'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5'
        ]);

        $review = new Review();
        $review->product_id = $product_id;
        $review->user_id = $auth->id;
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->save();

        $reviews = $product->reviews()->get();
        $reviewCount = $reviews->count();
        $totalRating = $reviews->sum('rating');
        $newAverageRating = $totalRating / $reviewCount;

        // Update review_count and average_rating
        $product->review_count = $reviewCount;
        $product->average_rating = $newAverageRating;
        $product->save();

        $notify[] = ['success', 'Review submitted successfully'];
        return back()->withNotify($notify);
    }

    // get orders table
    public function getOrders()
    {
        $pageTitle = 'Orders List';
        $orders = Order::where('user_id', auth()->user()->id)
            ->latest()
            ->with('product')
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'user.orders.index', compact('pageTitle', 'orders'));
    }

    // file download
    public function productFileDownload($id, $orderId)
    {

        $user = auth()->user();
        $siteName = gs()->site_name;
        $product = Product::findOrFail($id);
        $order = Order::findOrFail($orderId);


        if ($order->status != 1 && !$order->product->external_link) {
            $notify[] = ['error', 'Can not download this file'];
            return back()->withNotify($notify);
        }

        if ($product->is_free == 1) {
            if ($order->downlaoad_count > 10) {
                $notify[] = ['error', 'Your download limit is over'];
                return back()->withNotify($notify);
            }
        }
        $membership = $user->activeMembership();   
        
        if ($membership) {
            
            if ($membership->last_download_reset->diffInHours(now()) >= 24) {
                $membership->downloads_today = 0;
                $membership->last_download_reset = now();
                $membership->save();
            }

            if ($membership->downloads_today < $membership->plan->daily_download_limit) {
                // Allow download
                $membership->downloads_today += 1;
                $membership->save();
            } else {
                return back()->withErrors(['You reached your daily download limit.']);
            }
        } 

        if (isset($product->file)) {
            $file = getFilePath('productFile') . '/' . $product->file;
            $fileName = $siteName . '_' . $user->username . '_' . $product->file;

            $order->downlaoad_count += 1;
            $order->save();

            return response()->download($file, $fileName);
        } else {
            $notify = ['error', 'This File Empty'];
            return back()->withNotify($notify);
        }

    }


    // file download preminum product
    
    public function productpreminumFileDownload($id)
    {

        $user = auth()->user();
        $siteName = gs()->site_name;
        $product = Product::findOrFail($id);        


        if ($product->is_free == 1) {
            //if ($order->downlaoad_count > 10) {
                $notify[] = ['error', 'Your download limit is over'];
                return back()->withNotify($notify);
           // }
        }
        $membership = $user->activeMembership();  
              
        if ($membership) {            
            if ($membership->last_download_reset->diffInHours(now()) >= 24) {
                $membership->downloads_today = 0;
                $membership->last_download_reset = now();
                
                $membership->save();
            }
            if ($membership->downloads_today < $membership->plan->daily_download_limit) {
                // Allow download
               
                $membership->downloads_today += 1;
                $membership->save();
            } else {
                return back()->withErrors(['You reached your daily download limit.']);
            }
        } 
        
        if (isset($product->file)) {
            $file = getFilePath('productFile') . '/' . $product->file;
            $fileName = $siteName . '_' . $user->username . '_' . $product->file;
           

            return response()->download($file, $fileName);
        } else {
            $notify = ['error', 'This File Empty'];
            return back()->withNotify($notify);
        }

    }

}
