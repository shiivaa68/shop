<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;
use Cart;
use Zarinpal\Zarinpal;

class CartController extends Controller
{
    //

    public function cart()
    {

         // echo '<pre>';
         // print_r(Cart::content());
         // echo '</pre>';
       return View('pages.cart');
    }
    public function add(Request $request)
    {

     $product_info = DB::table('tbl_product')
     ->where('product_id',$request->product_id)
     ->get()
     ->first();

        $data['id'] = $product_info->product_id;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        $data['qty'] = $request->qty;

        Cart::add($data);
     
        return Redirect::to('/cart');
     
    }

    public function deletItem($cart_id)
    {
            Cart::update($cart_id,0);
             return  Redirect::to('/cart');
    }

    public function increment($cart_id)
    {
           $cart = Cart::get($cart_id);
            $cart->qty = $cart->qty+1;
            return Redirect('/cart');

                     
    }
    public function decrement($cart_id)
    {
        $cart = Cart::get($cart_id);
        if($cart->qty <= 1)
        {
            return Redirect('/cart');
        }else
        {
            $newQty=$cart->qty-1;
            $cart->qty=$newQty;
             return Redirect('/cart');
        }

    
    }

    public function checkout()
    {
        if (session::get('customer_id')) {
           return View('pages.checkout');
        }
        else
        {
          return Redirect('/customer/auth');
        }

    }


    public function save_shipping(Request $request)
    {   
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_tel'] = $request->shipping_tel;

        $shipping_id =  DB::table('tbl_shipping')->insertGetId($data);

        session::put('shipping_id',$shipping_id);
        return Redirect::to('cart/payment');


    }

    public function payment()
    {
      return View('pages.payment');
    }

    public function do_payment(Request $request)
    {
        $payment_method = $request->payment_method;
        switch ($payment_method) {
            case 'inhome':
                echo 'you must pay in your home';
                break;
             case 'zarinpal':
                    $this->pay_by_zarinpal();     
                break;

            default:
                echo 'this payment method not supported right now ';
                break;
        }
    }

    public function pay_by_zarinpal()
    {
        $total_cart = (int)Cart::total(0,'','','');
        $name = session::get('customer_name');
        $email = session::get('customer_email');
        $zarinpal = new Zarinpal('aae0a368-021a-11e6-a1db-005056a205be');
        $zarinpal->enableSandbox(); // active sandbox mod for test env
        $zarinpal->isZarinGate(); // active zarinGate mode
        $results = $zarinpal->request(
            route('payment.zarinpal.callback'),          //required
             $total_cart,                                  //required
            $name,                             //required
            $email,                      //optional
            '09000000000',                         //optional
            json_encode([                          //optional
                "Wages" => [
                    "zp.1.1"=> [
                        "Amount"=> 120,
                        "Description"=> "part 1"
                    ],
                    "zp.2.5"=> [
                        "Amount"=> 60,
                        "Description"=> "part 2"
                    ]
                ]
            ])
        );

        echo json_encode($results);
        if (isset($results['Authority'])) {
            file_put_contents('Authority', $results['Authority']);
            $zarinpal->redirect();
        }
        //it will redirect to zarinpal to do the transaction or fail and just echo the errors.
        //$results['Authority'] must save somewhere to do the verification
    }

    public function zarinpalCallback()
    {
        $status = $_GET['Status'] ;
            if ($status == 'OK') {
                 $this->finalStep('zarinpal'); 
                 return Redirect::to('cart/success');  

            }else if($status == 'NOK')
            {

                // wrong payment 
                echo 'your payment is not completed';
            }
    }


    public function finalStep($payment_method)
    {

        // echo '<pre>';
        // print_r(Cart::content());
        // echo '</pre>';

        //exit();

        // 1 INSERT PAYMENT TABLE
        // 2 INSERT ORDER TABLE 
        // 3 INSERT ORDER_DETAIL TABLE 

        // ------------- payment table -----------
        $payment_data = array();
        $payment_data['payment_method'] = $payment_method;
        $payment_data['payment_status'] = 'pending';

        $payment_id = DB::table('tbl_payment')
        ->insertGetId($payment_data);
        // ------------- END payment table -----------

        // ------------- order table -----------
        $order_data = array();
        $order_data['customer_id'] = session::get('customer_id') ;
        $order_data['shipping_id'] = session::get('shipping_id') ;
        $order_data['payment_id'] = $payment_id ;
        $order_data['order_total'] = (int)Cart::total(0,'','','');;
        $order_data['order_status'] = 'pending' ;

        $order_id = DB::table('tbl_order')
        ->insertGetId($order_data);
        // ------------- END order table -----------

        // -------------  order details table -----------
        // $od_data = array();
        // $od_data['order_id']= $order_id;
        $order_details_data = array();

        $cart_content = Cart::content();
        foreach ($cart_content as $content) {
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $content->id;
            $order_details_data['product_name'] = $content->name;
            $order_details_data['product_price'] = $content->price;
            $order_details_data['product_sale_quantity'] = $content->qty;

            DB::table('tbl_order_details')
            ->insert($order_details_data);      
        }
        // ------------- END  order details table -----------


         
    }


    public function success()
    {
        return View('pages.cart_success');
    }


}
