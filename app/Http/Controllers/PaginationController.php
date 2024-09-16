<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginationController extends Controller
{
    public function updateCheckboxState(Request $request, $productId) {
        return response()->json('mohamad');
        $isChecked = $request->query('checked', false);

        // Store the checkbox state in the database or session
        // Update your storage mechanism as needed

        return response()->json(['status' => 'success']);
    }
}
