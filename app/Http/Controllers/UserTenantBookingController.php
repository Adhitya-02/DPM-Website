<?php

namespace App\Http\Controllers;
use App\Models\Tenant;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Models\UserTenantBooking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;



class UserTenantBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $midtrans_client_key = env('MIDTRANS_CLIENT_KEY', '');
        if (auth()->user()->tipe_user_id == 2) {
            $data = UserTenantBooking::where('tenant_id', auth()->user()->tenant->id)->orderBy('id', 'desc')->get();
        }
        else{
            $data = UserTenantBooking::orderBy('id', 'desc')->get();
        }
        $tenant = Tenant::where('tipe_tenant_id' , 1)->get();
        $user = User::all();
        return view('user_tenant_booking.index', compact('tenant', 'user', 'data', 'midtrans_client_key'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['status'] = 2;
        $data['user_id'] = 10;
        $data['kode_booking'] = $this->generateBookingCode();
        $user_tenant_boo = UserTenantBooking::create($data);

        // Call API Midtrans to create payment flow
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', '');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $tenant = Tenant::where('id', $data['tenant_id'])->first();

        $params = [
            'transaction_details' => [
                'order_id' => $user_tenant_boo->id,
                'gross_amount' => (int)$data['jumlah'] * $tenant->harga,
            ],
            // 'customer_details' => [
            //     'first_name' => $request->first_name,
            //     'last_name' => $request->last_name,
            //     'email' => $request->email,
            //     'phone' => $request->phone,
            // ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $user_tenant_boo->update(['snap_token' => $snapToken]);
        $user_tenant_boo->save();

        return redirect()->back();
    }
    
    private function generateBookingCode()
    {
        return strtoupper(uniqid('BOOK-'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $user_tenant_booking = UserTenantBooking::where('id', $id)->first();
        $user_tenant_booking->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserTenantBooking::where('id', $id)->delete();
        return redirect()->back();
    }
    public function scan()
    {
        return view('user_tenant_booking.scan');
    }
    public function scanStore(Request $request)
    {
        $data = $request->all();
        $user_tenant_booking = UserTenantBooking::where('kode_booking', $data['kode_booking'])->first();
        if ($user_tenant_booking) {
            $user_tenant_booking->status = 2;
            $user_tenant_booking->updated_at = date('Y-m-d H:i:s');
            $user_tenant_booking->save();
            return response()->json(['success' => true, 'message' => 'Booking successfully scanned']);
        }
        return response()->json(['success' => false, 'message' => 'Booking not found']);
    }
}
