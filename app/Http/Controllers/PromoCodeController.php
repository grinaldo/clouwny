<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PromoCode;

class PromoCodeController extends Controller
{
    public function check(Request $request) 
    {
        if ($request->ajax()) {
            $response = [
                'status'  => 'failed',
                'message' => 'Invalid Request'
            ];
            $promotion = PromoCode::where('name', '=', $request->promotion)
                ->whereNotNull('published_at')
                ->first();
            if (!empty($promotion)) {
                $response = [
                    'data'   => 'Anda mendapat diskon ' . $promotion->discount . '% dengan maksimal Rp ' . number_format($promotion->limit) . ',-',
                    'status' => 'success',
                    'type'   => 'success',
                ];
            } else {
                \Log::info('sini');
                $response = [
                    'data'   => 'Tidak ada kode promo yang berlaku',
                    'status' => 'success',
                    'type'   => 'fail',
                ];
            }
            return response()->json($response); 
        }
        return null;
    }

}
