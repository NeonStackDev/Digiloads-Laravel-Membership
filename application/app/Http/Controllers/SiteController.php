<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\MembershipPlan;
use App\Models\UserMembership;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();

        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language)
            $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog()
    {
        $pageTitle = 'Blog';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->firstOrFail();
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'blog', compact('sections', 'blogs', 'pageTitle'));
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        $latests = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->limit(5)->get();
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latests'));
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX = ($imgWidth - $textWidth) / 2;
        $textY = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function subscribe(Request $request)
    {

        $request->validate([
            'email' => 'required|unique:subscribers',
        ]);

        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();

        $notify[] = ['success', 'You have successfully subscribed to the Newsletter'];
        return back()->withNotify($notify);

    }

    // shop
    public function browse()
    {
        $pageTitle = 'Browse';
        $products = Product::with(['productImages', 'category', 'reviews'])
            ->where('status', 1)
            ->latest()
            ->paginate(getPaginate());
        $categories = Category::where('status', 1)->get();
        $membership = null;
        if (auth()->check()) {
            $user = auth()->user();
            $membership = $user->activeMembership(); 
        }
        return view($this->activeTemplate . 'shop.shop', compact('products', 'pageTitle', 'categories','membership'));
    }

    //membership pricing
    public function pricing()
    {
        $pageTitle = 'Pricing';
        $membership = null;
        if (auth()->check()) {
            $user = auth()->user();
            $membership = $user->activeMembership(); 
        }
        $plans = MembershipPlan::all();
        return view($this->activeTemplate . 'pricing', compact('plans', 'pageTitle','membership'));
    }

    public function checkout($id)
    {
        if (!auth()->check()) {
            $notify[] = ['error', 'Please login to continue'];
            return redirect()->route('user.login')->withNotify($notify);
        }
        $plan = MembershipPlan::findOrFail($id);
        $pageTitle = 'Checkout';
        return view($this->activeTemplate.'checkout',compact('plan','pageTitle'));
    }

    // product details
    public function productDetails($slug, $id)
    {
        $product = Product::with(['productImages', 'category', 'reviews'])
            ->where('id', $id)
            ->firstOrFail();
        $productImages = $product->productImages ? $product->productImages->pluck('image')->toArray() : [];
        $relatedProducts = Product::with(['productImages', 'category', 'reviews'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->with('user')->paginate(getPaginate(5));
        $pageTitle = $product->name;
        return view($this->activeTemplate . 'shop.product_details', compact('pageTitle', 'product', 'productImages', 'relatedProducts', 'reviews'));
    }

    // product filter by ajax
    public function productFilter(Request $request)
    {
        $search = $request->input('search');
        $categories = $request->input('categories', []);
        $min = $request->input('min');
        $max = $request->input('max');

        $query = Product::with(['productImages', 'category', 'reviews'])
            ->where('status', 1);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhereHas('category', function ($category) use ($search) {
                        $category->where('name', 'LIKE', "%$search%");
                    });
            });
        }

        if ($min !== null && $max !== null) {
            $query->where(function ($q) use ($min, $max) {
                $q->where('price', '>=', $min)
                    ->where('price', '<=', $max);
            });
        }

        $products = $query->whereHas('category', function ($query) {
            $query->where('status', 1);
        })->get();

        $view = View::make($this->activeTemplate . 'shop.filtered_search', compact('products', 'categories'))->render();
        return response()->json([
            'html' => $view
        ]);
    }

    // prodcut search home page
    public function productSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")->get();

        return response()->json($products);
    }

    //category product
    public function categoryProducts(Request $request)
    {
        $findCategory = Category::findOrFail($request->id);
        $pageTitle = $findCategory->name;
        $products = Product::with(['productImages', 'category', 'reviews'])
            ->where('status', 1)
            ->where('category_id', $request->id)
            ->latest()
            ->paginate(getPaginate());
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'browse')->firstOrFail();
        $categories = Category::where('status', 1)->latest()->paginate(getPaginate());
        $membership = null;
        if (auth()->check()) {
            $user = auth()->user();
            $membership = $user->activeMembership(); 
        }
        return view($this->activeTemplate . 'shop.shop', compact('sections', 'products', 'pageTitle', 'categories','membership'));

    }

    // vendor
    public function vendorPage($slug, $id)
    {

        $user = User::findOrFail($id);
        $pageTitle = $user->username;
        $products = Product::with(['productImages', 'category', 'reviews'])
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->latest()
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'user.vendor.index', compact('products', 'pageTitle', 'user'));
    }

    public function vendorProductSearch(Request $request, $id)
    {
        $pageTitle = 'Search';
        $user = User::findOrFail($id);
        $search = $request->input('search');
        
        $query = Product::with(['productImages', 'category', 'reviews'])
            ->where('user_id', $user->id)
            ->where('status', 1);
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhereHas('category', function ($category) use ($search) {
                        $category->where('name', 'LIKE', "%$search%");
                    });
            });
        }
    
        $products = $query->paginate(getPaginate());
        return view($this->activeTemplate . 'user.vendor.index', compact('products', 'pageTitle', 'user'));
    }
    


}
