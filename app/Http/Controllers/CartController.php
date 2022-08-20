<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use DataTables;

class CartController extends Controller
{
    public function cartTable(Request $request)
    {
        if ($request->ajax()) {
            $items = [];
            if (isset($_COOKIE['beinCart'])) {
                $cartItems = $_COOKIE['beinCart'];
            } else {
                $cartItems = '[]';
            }
            $cartItems = json_decode($cartItems);
            foreach ($cartItems as $item) {
                $cartItem = Package::where('id', $item->id)->select('packages.*')->first();
                if ($cartItem) {
                    $cartItem->count = $item->count;
                    array_push($items, $cartItem);
                }
            }
            return DataTables()->of($items)->addIndexColumn()->make(true);
        }
    }
    public function add_to_cart(Request $request)
    {
        if (isset($_COOKIE['beinCart'])) {
            $cartItems = $_COOKIE['beinCart'];
        } else {
            $cartItems = '[]';
        }
        $id = $request->id;
        $qty = $request->qty;
        $exist = false;

        $cartItems = json_decode($cartItems);

        foreach ($cartItems as $item) {
            if ($item->id == $id) {
                $exist = true;
                break;
            }
        }
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'الباقة موجودة بالفعل في سلة المشتريات'
            ]);
        } else {
            array_push($cartItems, ['id' => $id, 'count' => $qty]);
            $cartItems = json_encode($cartItems);
            setcookie('beinCart', $cartItems, time() + (86400 * 365 * 10), "/");
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الباقة إلى سلة المشتريات'
            ]);
        }
    }


    public function change_cart_count(Request $request)
    {
        if (isset($_COOKIE['beinCart'])) {
            $cartItems = $_COOKIE['beinCart'];
        } else {
            $cartItems = [];
        }
        $id = $request->id;
        $count = $request->count;
        $cartItems = json_decode($cartItems);

        foreach ($cartItems as $item) {
            if ($item->id == $id) {
                $item->count = $count;
                break;
            }
        }
        $cartItems = json_encode($cartItems);
        setcookie('beinCart', $cartItems, time() + (86400 * 365 * 10), "/");
        return response()->json([
            'success' => true,
        ]);
    }

    public function remove_from_cart(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        if (isset($_COOKIE['beinCart'])) {
            $cartItems = $_COOKIE['beinCart'];
        } else {
            $cartItems = [];
        }
        $id = $request->id;
        $cartItems = json_decode($cartItems);

        for ($i = 0; $i < count($cartItems); $i++) {
            if ($cartItems[$i]->id == $id) {
                array_splice($cartItems, $i, 1);
            }
        }
        $cartItems = json_encode($cartItems);
        setcookie('beinCart', $cartItems, time() + (86400 * 365 * 10), "/");
        return response()->json([
            'success' => true,
            'message' => 'تم الحذف بنجاح',
        ]);
    }
    public function get_total_labels()
    {
        $total = 0;
        if (isset($_COOKIE['beinCart'])) {
            $cartItems = $_COOKIE['beinCart'];
        } else {
            $cartItems = [];
        }
        $cartItems = json_decode($cartItems);
        foreach ($cartItems as $item) {
            $cartItem = Package::where('id', $item->id)->select('price')->first();
            if ($cartItem) {
                $total += ($item->count * $cartItem->price);
            }
        }
        return response()->json([
            'total' => $total
        ]);
    }
    public function get_cart_counter()
    {
        if (isset($_COOKIE['beinCart'])) {
            $cartItems = $_COOKIE['beinCart'];
        } else {
            $cartItems = [];
        }
        $cartItems = json_decode($cartItems);
        return response()->json([
            'counter' => count($cartItems),
        ]);
    }
}
