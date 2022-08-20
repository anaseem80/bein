<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\Device;
use App\Mail\OrderMail;
use App\Models\Country;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\DeviceCountry;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SettingController;

class OrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('manager')->except(['store','pay','payment_post_url','payment_redirect_url']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "الطلبات";
        $package_type = $request->package_type;
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            if ($package_type == 'both') {
                $orders = Order::with(['country', 'package', 'device'])->latest()->get();
            } else {
                $orders = Order::with(['country', 'package', 'device'])->where('package_type', $package_type)->latest()->get();
            }
            return DataTables()->of($orders)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.orders.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "first_name" => 'required',
    //         "last_name" => 'required',
    //         "country" => 'required',
    //         "address" => 'required',
    //         "city" => 'required',
    //         "zip_code" => 'required',
    //         "mobile" => 'required',
    //         "email" => 'required',
    //     ]);
    //     $data = $request->all();
    //     $user = auth()->user();
    //     if ($user) {
    //         $data['user_id'] = $user->id;
    //     }
    //     $order = Order::create($data);
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
    //     $offers = 0;
    //     $shipping = 0;
    //     $sub_total = 0;
    //     foreach ($items as $item) {
    //         $orderItem = [];
    //         $orderItem['order_id'] = $order->id;
    //         $orderItem['package_id'] = $item->id;
    //         $orderItem['qty'] = $item->count;
    //         $orderItem['unit_price'] = $item->price;
    //         $orderItem['total_price'] = $item->price * $item->count;
    //         $sub_total += $orderItem['total_price'];
    //         OrderItem::create($orderItem);
    //     }
    //     $order->total = $sub_total + $shipping - $offers;
    //     $order->sub_total = $sub_total;
    //     $order->shipping = $shipping;
    //     $order->offers = $offers;
    //     $order->save();
    //     setcookie('beinCart', "[]", time() + (86400 * 365 * 10), "/");

    //     return redirect()->route('home')->with('success', 'تم إرسال طلبك');
    // }
    public function store(Request $request)
    {
        $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "bein_card_number" => 'required_if:package_type,==,renew',
            "country" => 'required',
            "address" => 'required',
            // "mobile" => 'required',
            // "mobile_key" => 'required',
            // "email" => 'required',
        ]);
        $taxes = Setting::where('type', 'taxes')->where('status', 1)->get();
        $taxes_value = 0;
        $total_value = $request->sub_total + ($request->shipping ?? 0) + ($request->device_price ?? 0);
        foreach ($taxes as $tax) {
            if ($tax->description == 'percent') {
                $taxes_value += ($tax->value / 100) * ($total_value);
            } else {
                $taxes_value += $tax->value;
            }
        }
        $taxes_value = round($taxes_value);
        $data = $request->all();

        unset($data['total']);
        unset($data['taxes']);


        $data['total'] = $total_value + $taxes_value;
        $data['taxes'] = $taxes_value;


        $data['country_id'] = $data['country'];
        unset($data['country']);
        $user = auth()->user();
        if ($user) {
            $data['user_id'] = $user->id;
        }
        $order = Order::create($data);

        $invoice = $this->pay($order);

        try {
            if ($invoice) {
                $order->transaction_id = $invoice->id;
                $order->invoice_number = $invoice->invoice_number;
                $order->invoice_status = $invoice->status;
                $order->invoice_created_at = date("Y-m-d H:i:s", ($invoice->created / 1000));
                $order->invoice_details = $invoice;
                $order->status = 1;
                $order->save();

                if ($user) {
                    if (!$user->tap_id) {
                        $user->tap_id = $invoice->customer->id;
                        $user->save();
                    }
                }

                try {
                    $admins = User::whereNotNull('role')->pluck('email');
                    foreach ($admins as $admin) {
                        Mail::to($admin)->send(new OrderMail($order));
                    }
                    if ($order->email) {
                        Mail::to($order->email)->send(new OrderMail($order));
                    }
                } catch (Exception $e) {
                    //
                }


                return redirect()->away($invoice->url);
            }
        } catch (Exception $ex) {
            abort(400, "حدثت مشكلة أثناء انشاء الفاتورة");
        }
        return redirect()->route('home')->with('success', 'تم إرسال طلبك');
    }

    public function pay(Order $order)
    {
        $date_mill = round(microtime(true) * 1000);
        $currency = SettingController::getSettingValue('pay_currency');
        $package = Package::find($order->package_id);
        $taxes = Setting::where('type', 'taxes')->where('status', 1)->get();
        $sub_total = ($order->sub_total + ($order->shipping ?? 0) + ($order->device_price ?? 0)) * 1;

        if ($currency == '$') {
            $currency = 'USD';
        }

        $invoice = [
            "due" => $date_mill + (5 * 60 * 1000),
            "expiry" => $date_mill + (30 * 24 * 60 * 60 * 1000),
        ];

        $customer = [
            // "email" => $order->email,
            "first_name" => $order->first_name,
            "last_name" => $order->last_name,
            // "phone" => [
            //     "country_code" => $order->mobile_key,
            //     "number" => $order->mobile,
            // ],
        ];
        if ($order->email) {
            $customer["email"] = $order->email;
        }
        if ($order->mobile) {
            $customer["phone"] = [
                "country_code" => $order->mobile_key,
                "number" => $order->mobile,
            ];
        }

        if ($order->user_id) {
            $user = User::find($order->user_id);
            if ($user) {
                if ($user->tap_id) {
                    $customer['id'] = $user->tap_id;
                    $this->change_customer($customer);
                }
            }
        }
        $invoice['customer'] = $customer;
        $c_order = [
            "amount" => $order->total,
            "currency" => $currency,
        ];
        $items = [
            [
                "amount" => $package['price_' . $order->duration] * 1,
                "currency" => $currency,
                "name" => $package->name,
                "quantity" => 1,
                "description" => $order->package_type,
            ],
        ];
        if ($order->package_type == 'new') {
            $device = Device::find($order->device_id);
            array_push($items, [
                "amount" => $order->device_price * 1,
                "currency" => $currency,
                "name" => $device->name,
                "quantity" => 1,
                "description" => 'device',
            ]);
            $ship = DeviceCountry::where('device_id', $order->device_id)->where('country_id', $order->country_id)->first();

            $c_order["shipping"] = [
                "provider" => "Shipping",
                "amount" => $ship ? $ship->shipping_price * 1 : 0,
                "currency" => $currency,
            ];
        }
        if (count($taxes) > 0) {
            foreach ($taxes as $tax) {
                array_push($items, [
                    "amount" => $tax->description == 'percent' ? round((($tax->value * 1) / 100) * $sub_total) : $tax->value * 1,
                    "currency" => $currency,
                    "name" => $tax->key,
                    "quantity" => 1,
                    "description" => "tax " . ($tax->description == 'percent' ? 'P' : 'F'),
                ]);
            }
        }

        // if (count($taxes) > 0) {
        //     $taxes_order = [];
        //     foreach ($taxes as $tax) {

        //             array_push($taxes_order, [
        //                 "name" => $tax->key,
        //                 "rate" => [
        //                     "type" => $tax->description == 'percent' ? 'P' : 'F',
        //                     "value" => $tax->value*1
        //                     ]
        //                 ]);

        //     }
        //     $c_order['tax'] = $taxes_order;
        // }
        $c_order['items'] = $items;
        $invoice['order'] = $c_order;
        $invoice['post'] = [
            "url" => str_replace("http:", "https:", route('payment_post_url')),
        ];
        $invoice['redirect'] = [
            "url" => str_replace("http:", "https:", route('payment_redirect_url') . '?order_id=' . $order->id),
        ];
        $invoice['reference'] = [
            "order" => $order->id,
        ];
        // dd($invoice);
        $invoice = json_encode($invoice);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.tap.company/v2/invoices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $invoice,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('app.tap_key'),
                // 'lang_code: arabic',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function change_customer($customer)
    {

        $curl = curl_init();
        $newCustomer = [
            "id" => $customer["id"],
            // "email" => $customer["email"],
            "first_name" => $customer["first_name"],
            "last_name" => $customer["last_name"],
            // "phone" => [
            //     "country_code" => $customer["phone"]["country_code"],
            //     "number" => $customer["phone"]["number"],
            // ],
        ];
        if (isset($customer["email"])) {
            $newCustomer["email"] = $customer["email"];
        }else{
            $newCustomer["email"]=null;
        }
        if (isset($customer["phone"])) {
            $newCustomer["phone"] = [
                "country_code" => $customer["phone"]["country_code"],
                "number" => $customer["phone"]["number"],
            ];
        }else{
            $newCustomer["phone"] = null;
        }
        $newCustomer = json_encode($newCustomer);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/customers/" . $customer["id"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $newCustomer,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . config('app.tap_key'),
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return json_decode($err);
        }
        return json_decode($response);
    }

    public function payment_post_url(Request $request)
    {
        $invoice = $request->all();
        $order = Order::where('transaction_id', $request->id)->first();
        if ($order) {

            $order->invoice_status = $request->status;
            $order->invoice_details = $invoice;
            $order->status = 2;
            $order->save();

            // try {
            //     $admins = User::whereNotNull('role')->pluck('email');
            //     foreach ($admins as $admin) {
            //         Mail::to($admin)->send(new OrderMail($order));
            //     }
            //     Mail::to($order->email)->send(new OrderMail($order));
            // } catch (Exception $e) {
            //     //
            // }


            return response()->json([
                'message' => 'success',
                'invoice' => $invoice,
                'order' => $order,
            ]);
        } else {
            return response()->json([
                'message' => 'failed',
                'invoice' => $invoice,
                'order' => 'not found',
            ]);
        }
    }
    public function payment_redirect_url(Request $request)
    {
        $title = "تفاصيل الفاتورة";
        $order = Order::find($request->order_id);
        $response = [];

        switch ($order->invoice_status) {
            case 'SAVED':
                $response = [
                    "status" => "info",
                    "message" => "تم حفظ الفاتورة",
                ];
                break;
            case 'CREATED':
                $response = [
                    "status" => "info",
                    "message" => "تم إنشاء الفاتورة",
                ];
                break;
            case 'PAID':
                $response = [
                    "status" => "success",
                    "message" => "تم دفع الفاتورة بنجاح",
                ];
                break;
            case 'CANCELLED':
                $response = [
                    "status" => "error",
                    "message" => "تم إلغاء الفاتورة",
                ];
                break;
            case 'EXPIRED':
                $response = [
                    "status" => "warning",
                    "message" => "انتهت صلاحية الفاتورة",
                ];
                break;
        }

        return view('front.invoice', compact('title', 'order', 'response'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
