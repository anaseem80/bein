<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Device;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Package;
use App\Models\Setting;
use App\Models\PackageDevice;

class FrontController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('ar');
    }

    public function index()
    {
        $title = "الصفحة الرئيسية";
        //Get active sliders
        $sliders = Setting::where('type', 'sliders')->where('status', 1)->get(['key as image', 'value as title', 'description as renew', 'description_2 as new']);
        //Get Important pakages
        $impPackages = Setting::rightJoin('packages', 'packages.id', 'key')->where('settings.type', 'packages')->where('status', 1)->latest()->get(['settings.*', 'packages.name', 'packages.description', 'packages.price_90', 'packages.price_180', 'packages.price_365', 'packages.image', 'packages.type']);

        $mainPackagesParagraph = Setting::where('key', 'mainPackages')->where('type', 'paragraphs')->first();
        if (!$mainPackagesParagraph) {
            $mainPackagesParagraph = [];
            $mainPackagesParagraph['value'] = '';
        }
        $devices = Device::with('newTypePackages', 'packages')->get();
        $lastNews = Blog::where('type', 'article')->where('is_published', 1)->orderBy('id', 'desc')->limit(3)->get();
        $worldCup = Setting::rightJoin('packages', 'packages.id', 'value')->where('settings.type', 'worldCup')->where('status', 1)->select('settings.*', 'packages.name', 'packages.description', 'packages.price_90', 'packages.price_180', 'packages.price_365', 'packages.image', 'packages.type')->first();
        if (!$worldCup) {
            $worldCup = null;
        }
        return view('front.index', compact('title', 'sliders', 'impPackages', 'mainPackagesParagraph', 'lastNews', 'devices', 'worldCup'));
    }
    public function articles()
    {
        $title = "الأخبار";
        $articles = Blog::where('is_published', 1)->with('categories', 'lastComment')->where('type', 'article')->latest()->paginate(10);
        return view('front.articles', compact('title', 'articles'));
    }
    public function article($id)
    {
        $title = "الأخبار";
        $user = auth()->user();
        $article = Blog::where('id', $id)->where('is_published', 1)->where('type', 'article')->firstOrFail();
        $title .= ' | ' . $article->name;
        return view('front.article', compact('title', 'article', 'user'));
    }
    public function redirectProduct($id)
    {
        $product = Package::where('id', $id)->firstOrFail();
        $type = "";
        if ($product->type == "both") {
            $type = "new";
        } else {
            $type = $product->type;
        }
        return redirect(route('product', ["id" => $id, "type" => $type]));
    }
    public function product($id, $type, $device_id = 0)
    {
        if ($type == 'new' && $device_id == 0) {
            $devices=PackageDevice::leftJoin('devices','devices.id','device_id')->where('package_id',$id)->get('devices.*');
            $title='الأجهزة المرتبطة بالباقة في الاشتراك الجديد';
            return view('front.choosedevice',compact('devices','title','id','type'));
        }
        $package = Package::where('id', $id)->where(function ($q) use ($type) {
            $q->where('type', $type)->orWhere('type', 'both');
        })
            ->firstOrFail();

        $relatedPackages = Package::where('id', '<>', $package->id)->limit(4)->get();
        if (count($relatedPackages) > 0) {
            $relatedPackages = $relatedPackages->random(count($relatedPackages));
        }
        $title = $package->name;
        if ($device_id != 0) {
            $attachedDevice = Device::find($device_id);
            return view('front.product', compact('title', 'package', 'relatedPackages', 'type', 'device_id', 'attachedDevice'));
        }
        return view('front.product', compact('title', 'package', 'relatedPackages', 'type', 'device_id'));
    }
    public function device($id)
    {
        $device = Device::where('id', $id)->with('packages')->firstOrFail();
        $title = $device->name;
        $price_device = count($device->packages) > 0 ? $device->packages[0]->price_device : 0;
        return view('front.device', compact('title', 'device', 'price_device'));
    }
    public function products($type, $device_id = 0)
    {
        if ($type == 'new' && $device_id == 0) {
            abort(404);
        }
        $title = $type == "new" ? "إشتراك جديد" : "تجديد إشتراك";
        if ($device_id != 0) {
            $device=Device::find($device_id);
            $title.=" بالجهاز : ";
            $title.=$device->name;
            $packagesInDevice = PackageDevice::where('device_id', $device_id)->pluck('package_id');
            $packages = Package::whereIn('packages.id', $packagesInDevice)->where(function ($q) use ($type) {
                $q->where('type', $type)->orWhere('type', 'both');
            })->get();
        } else {
            $packages = Package::where('type', $type)->orWhere('type', 'both')->get();
        }
        return view('front.products', compact('title', 'packages', 'type', 'device_id'));
    }
    public function newSubscription()
    {
        $title = "إشتراك جديد";
        $devices = Device::get();
        return view('front.newSubscription', compact('title', 'devices'));
    }
    public function offers()
    {
        $title = "العروض";
        $packages = Package::where('is_offer', 1)->get();
        return view('front.products', compact('title', 'packages'));
    }
    public function devicePackages(Device $device)
    {
        $title = "الباقات التي تحتوي على الجهاز ";
        $title .= $device->name;
        $packages = $device->newTypePackages;
        $type = "new";
        return view('front.products', compact('title', 'packages', 'type'));
    }
    public function mainProducts()
    {
        $title = "الباقات الأساسية";
        $is_main = true;
        $packages = Package::whereNull('parent_id')->get();
        return view('front.products', compact('title', 'packages', 'is_main'));
    }
    public function shoppingCart()
    {
        $title = "سلة المشتريات";
        return view('front.shopping_cart', compact('title'));
    }
    public function completeOrder($id, $type, $device_id = 0, $duration = 365)
    {
        $title = "إتمام الطلب";
        $user = auth()->user();
        $taxes=Setting::where('type','taxes')->where('status',1)->where('description_2',1)->get();

        $product = Package::where('id', $id)->where(function ($q) use ($type) {
            $q->where('type', $type)->orWhere('type', 'both');
        })
            // ->with('device')
            ->firstOrFail();

        if ($duration == 365) {
            if ($product->price_365 == null) {
                $duration = 180;
                if ($product->price_180 == null) {
                    $duration = 90;
                }
            }
        }
        $countries = Country::get();
        if ($device_id != 0) {
            $device = Device::where('id', $device_id)->with('countries')->first();
            $product->price_device=$device->price;
            return view('front.completeorder', compact('title', 'user', 'product', 'type', 'duration', 'countries', 'device','taxes'));
        }

        return view('front.completeorder', compact('title', 'user', 'product', 'type', 'duration', 'countries','taxes'));
    }
    // public function completeOrder()
    // {
    //     $title = "إتمام الطلب";
    //     $user = auth()->user();
    //     $items = [];
    //     if (isset($_COOKIE['beinCart'])) {
    //         $cartItems = $_COOKIE['beinCart'];
    //     } else {
    //         $cartItems = '[]';
    //     }
    //     $cartItems = json_decode($cartItems);
    //     foreach ($cartItems as $item) {
    //         $cartItem = Package::where('id', $item->id)->select('packages.*')->first();
    //         if ($cartItem) {
    //             $cartItem->count = $item->count;
    //             array_push($items, $cartItem);
    //         }
    //     }

    //     return view('front.completeorder', compact('title', 'user', 'items'));
    // }
    public static function comments_latestArticles($key)
    {
        $latestArticles = Blog::where('is_published', 1)->where('type', 'article')->latest()->take(5)->get();
        $comments = Comment::latest()->take(5)->get();
        $data = [];
        $data['latestArticles'] = $latestArticles;
        $data['comments'] = $comments;
        return $data[$key];
    }
}
