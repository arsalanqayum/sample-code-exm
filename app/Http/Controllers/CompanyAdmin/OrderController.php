<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Services\CompanyAdmin\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /** @var OrderService */
    public $orderService;

    /**
     * Constructor
     *
     * @param OrderService $orderService
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->authorizeResource(Order::class, 'order');
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isAdmin()) {
            $orders = Order::with(['user'])->where('company_id', null)->paginate(15);

            return response()->json($orders);
        }

        $orders = Order::with(['user'])->where('company_id', auth()->user()->company->id)->paginate(15);

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Take action to reward user
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function payReward(Request $request, $id)
    {
        $data = $request->validate([
            'accept' => 'required|boolean',
        ]);

        $order = Order::where('status', 'pending')->findOrFail($id);

        if(!$order->user->stripeAccount) {
            return response()->json(['flash' => 'This owner dont have payment account'], 422);
        }

        return $this->orderService->payReward($data, $order);
    }
}
