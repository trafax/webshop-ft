<?php

namespace App\Http\Controllers;

//use DrewM\MailChimp\MailChimp;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Newsletter;
//use MailchimpAPI\Mailchimp;
use \DrewM\MailChimp\MailChimp;

class MailchimpController extends Controller
{
    public function block($block)
    {
        return view('mailchimp.block', compact('block'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
        ]);

        if (Newsletter::isSubscribed($request->get('email')) == false) {
            Newsletter::subscribe($request->get('email'), ['FNAME' => $request->get('fname'), 'LNAME' => $request->get('lname')]);
            Session::flash('message', it('newsletter-success', 'U bent succesvol ingeschreven.'));
        } else {
            Session::flash('message', it('newsletter-not-success', 'U bent al ingeschreven.'));
        }

        return redirect()->to(url()->previous() . '#mailchimp');
    }

    public function product()
    {

        $mailchimp = new MailChimp(env('MAILCHIMP_APIKEY'));

        $products = Product::where('visible', 1)->where('sold_out', 0)->get();
        foreach ($products as $product) {
            if ($product->has('assets')->first()) {
                $variations = [];
                foreach ($product->variations as $variation) {
                    $variations = [
                        'id' => $variation->title,
                        'title' => $variation->pivot->title,
                        'sku' => $product->sku,
                        'price' => $product->price,
                    ];
                }

                if (isset($product->assets()->get()->first()->file)) {

                    $result = $mailchimp->delete('/ecommerce/stores/666816fab4/products/' . $product->sku);

                    $result = $mailchimp->post('/ecommerce/stores/666816fab4/products', [
                        'id' => $product->sku,
                        'title' => $product->title,
                        'price' => $product->price,
                        'url' => route('product', $product->slug),
                        'image_url' => url('/storage/'.$product->assets()->get()->first()->file),
                        'variants' => [$variations]
                    ]);
                }
            }
        }

        echo 'Done!';

        //$result = $mailchimp->delete('/ecommerce/stores/666816fab4/products/' . $product->sku);

        // $result = $mailchimp->post('/ecommerce/stores/666816fab4/products', [
        //     'id' => $product->sku,
        //     'title' => $product->title,
        //     'price' => $product->price,
        //     'url' => route('product', $product->slug),
        //     'image_url' => url('/storage/'.$product->assets()->get()->first()->file),
        //     'variants' => [$variations]
        // ]);



        //$result = $mailchimp->get("/lists");

        //dd($result);
        // $products = $mailchimp->ecommerceStores(1);

        // dd($products->get());
    }
}
