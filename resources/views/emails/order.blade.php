<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>


<body dir="rtl">
    @include('emails.styles')
    <div class="row">
        <div class="col-lg-12">
            <div class="row fs-2">
                <h1>التفاصيل</h1>
                <div class="col-6 row">
                    <label class="col-5 text-primary">رقم الطلب:</label>
                    <label class="col-7">{{ $order->id }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">رقم الفاتورة:</label>
                    <label class="col-7">{{ $order->invoice_details->invoice_number }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">رقم العملية:</label>
                    <label class="col-7">{{ $order->invoice_details->id }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">حالة الفاتورة:</label>
                    <label class="col-7">{{ $order->invoice_details->status }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">التاريخ:</label>
                    <label class="col-7">{{ $order->created_at->translatedFormat('Y ,d F') }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">الدولة:</label>
                    <label class="col-7">{{ $order->country->name }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">الاسم الأول:</label>
                    <label class="col-7">{{ $order->first_name }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">الاسم الأخير:</label>
                    <label class="col-7">{{ $order->last_name }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">البريد الاليكتروني:</label>
                    <label class="col-7">{{ $order->email }}</label>
                </div>
                <div class="col-6"></div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">الهاتف:</label>
                    <label class="col-7">{{ $order->mobile }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">المدة:</label>
                    <label class="col-7">{{ $order->duration }} يوم</label>
                </div>
                @foreach($order->invoice_details->order->items as $item)
                @if($item->description=='new'||$item->description=='renew')
                <div class="col-6 row">
                    <label class="col-5 text-primary">نوع الاشتراك:</label>
                    <label class="col-7">{{$item->description=='new'?'اشتراك جديد':'تجديد إشتراك' }}</label>
                </div>
                @if($item->description=='renew')
                <div class="col-6 row">
                    <label class="col-5 text-primary">Bein card number:</label>
                    <label class="col-7">{{$order->bein_card_number}}</label>
                </div>
                @endif
                <div class="col-6 row">
                    <label class="col-5 text-primary">الباقة:</label>
                    <label class="col-7">{{$item->name }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">سعر الباقة:</label>
                    <label class="col-7">{{$item->amount }} {{$item->currency}}</label>
                </div>
                @elseif($item->description=='device')
                <div class="col-6 row">
                    <label class="col-5 text-primary">الجهاز:</label>
                    <label class="col-7">{{$item->name }}</label>
                </div>
                <div class="col-6 row">
                    <label class="col-5 text-primary">سعر الجهاز:</label>
                    <label class="col-7">{{$item->amount }} {{$item->currency}}</label>
                </div>
                @endif
                @endforeach
                @if(isset($order->invoice_details->order->shipping))
                <div class="col-6 row">
                    <label class="col-5 text-primary">مصاريف الشحن:</label>
                    <label class="col-7">{{$order->invoice_details->order->shipping->amount }} {{$order->invoice_details->order->shipping->currency}}</label>
                </div>
                @endif
                @if($order->taxes>0)
                <div class="col-6 row">
                    <label class="col-5 text-primary">إجمالي الضريبة:</label>
                    <label class="col-7">{{ceil($order->taxes) }} {{$order->invoice_details->order->currency}}</label>
                </div>
                @endif
                <div class="col-6 row">
                    <label class="col-5 text-primary">الإجمالي:</label>
                    <label class="col-7">{{$order->invoice_details->order->amount }} {{$order->invoice_details->order->currency}}</label>
                </div>
                

            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-lg-8">
            <div class="row fs-2">
                <h1>التفاصيل</h1>
                <div class="col-12 row">
                    <label class="col-5 text-primary">رقم الطلب:</label>
                    <label class="col-7">{{ $order->id }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">رقم الفاتورة:</label>
                    <label class="col-7">{{ $order->invoice_details->invoice_number }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">رقم العملية:</label>
                    <label class="col-7">{{ $order->invoice_details->id }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">حالة الفاتورة:</label>
                    <label class="col-7">{{ $order->invoice_details->status }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">التاريخ:</label>
                    <label class="col-7">{{ $order->created_at->translatedFormat('Y ,d F') }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">الدولة:</label>
                    <label class="col-7">{{ $order->country->name }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">الاسم الأول:</label>
                    <label class="col-7">{{ $order->first_name }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">الاسم الأخير:</label>
                    <label class="col-7">{{ $order->last_name }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">البريد الاليكتروني:</label>
                    <label class="col-7">{{ $order->email }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">الهاتف:</label>
                    <label class="col-7">{{ $order->mobile }}</label>
                </div>
                <div class="col-12 row">
                    <label class="col-5 text-primary">المدة:</label>
                    <label class="col-7">{{ $order->duration }} يوم</label>
                </div>
                @foreach ($order->invoice_details->order->items as $item)
                    @if ($item->description == 'new' || $item->description == 'renew')
                        <div class="col-12 row">
                            <label class="col-5 text-primary">نوع الاشتراك:</label>
                            <label
                                class="col-7">{{ $item->description == 'new' ? 'اشتراك جديد' : 'تجديد إشتراك' }}</label>
                        </div>
                        @if ($item->description == 'renew')
                            <div class="col-12 row">
                                <label class="col-5 text-primary">Bein card number:</label>
                                <label class="col-7">{{ $order->bein_card_number }}</label>
                            </div>
                        @endif
                        <div class="col-12 row">
                            <label class="col-5 text-primary">الباقة:</label>
                            <label class="col-7">{{ $item->name }}</label>
                        </div>
                        <div class="col-12 row">
                            <label class="col-5 text-primary">سعر الباقة:</label>
                            <label class="col-7">{{ $item->amount }} {{ $item->currency }}</label>
                        </div>
                    @else
                        <div class="col-12 row">
                            <label class="col-5 text-primary">الجهاز:</label>
                            <label class="col-7">{{ $item->name }}</label>
                        </div>
                        <div class="col-12 row">
                            <label class="col-5 text-primary">سعر الجهاز:</label>
                            <label class="col-7">{{ $item->amount }} {{ $item->currency }}</label>
                        </div>
                    @endif
                    @if (isset($order->invoice_details->order->shipping))
                        <div class="col-12 row">
                            <label class="col-5 text-primary">مصاريف الشحن:</label>
                            <label class="col-7">{{ $order->invoice_details->order->shipping->amount }}
                                {{ $order->invoice_details->order->shipping->currency }}</label>
                        </div>
                    @endif
                    <div class="col-12 row">
                        <label class="col-5 text-primary">الإجمالي:</label>
                        <label class="col-7">{{ $order->invoice_details->order->amount }}
                            {{ $order->invoice_details->order->currency }}</label>
                    </div>
                @endforeach

            </div>
        </div>
    </div> --}}

</body>

</html>
