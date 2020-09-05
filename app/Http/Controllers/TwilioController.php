<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
    /** @var ProductService */
    public $productService;

    /** @var ChatService */
    public $chatService;

    /**
     * Constructor
     *
     * @param ProductService $productService
     * @param ChatService $chatService
     * @return void
     */
    public function __construct(ProductService $productService, ChatService $chatService)
    {
        $this->productService = $productService;
        $this->chatService = $chatService;
    }
    /**
     * Handle twilio message/sms webhook
     *
     * @param Request $request
     * @return void
     */
    public function messageWebhook(Request $request)
    {
        $this->productService->checkProductVerification($request);

        $this->chatService->checkOwnerApproval($request);

        $this->chatService->listenForChat($request);

        $this->chatService->checkIfBuyerGiveFeedback($request);
    }
}
