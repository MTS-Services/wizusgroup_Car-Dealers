<?php

namespace App\Http\Controllers\Backend\User\AuctionManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuctionBidPlaceRequest;
use App\Mail\AuctionBidMail;
use App\Models\Auction;
use App\Models\AuctionBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuctionBidPlaceController extends Controller
{
    public function placeBid(AuctionBidPlaceRequest $request, $slug)
    {

        $user = user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        $auction = Auction::where('slug', $slug)->firstOrFail();
        try {
            $validated = $request->validated();
            $validated['auction_id'] = $auction->id;
            $validated['user_id'] = $user->id;
            $validated['creater_id'] = $user->id;
            $validated['creater_type'] = get_class($user);
            $auctionBid = AuctionBid::create($validated);
            Mail::to('oasiffre@gmail.com')->send(new AuctionBidMail($auctionBid));
             session()->flash('success', 'Bid Place submitted successfully! We will contact you soon.');
            return response()->json([
                'slug' => $slug,
                'form_data' => $request->all(),
                'auction' => $auction,
                'bid' => $auctionBid
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to place bid', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to place bid',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
