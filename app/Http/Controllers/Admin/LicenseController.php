<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LicenseController extends Controller
{
    /**
     * Display a listing of the licenses.
     */
    public function index(Request $request)
    {
        $query = License::with(['product', 'user', 'orderItem'])
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->product_id, function($query, $productId) {
                return $query->where('product_id', $productId);
            });

        $licenses = $query->latest()->paginate(15);
        $products = Product::orderBy('name')->get();
        $statusOptions = ['available', 'assigned', 'revoked'];

        return view('admin.licenses.index', [
            'licenses' => $licenses,
            'products' => $products,
            'statusOptions' => $statusOptions,
            'selectedStatus' => $request->status,
            'selectedProduct' => $request->product_id,
        ]);
    }

    /**
     * Show the form for creating a new license.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        
        return view('admin.licenses.create', [
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created license in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'status' => ['required', Rule::in(['available', 'assigned'])],
            'user_id' => 'nullable|required_if:status,assigned|exists:users,id',
            'expires_at' => 'nullable|date|after:today',
            'activation_limit' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $generatedCount = 0;
            $quantity = $validated['quantity'];
            
            while ($generatedCount < $quantity) {
                $license = new License();
                $license->product_id = $validated['product_id'];
                $license->license_key = License::generateLicenseKey();
                $license->status = $validated['status'];
                
                if ($validated['status'] === 'assigned' && isset($validated['user_id'])) {
                    $license->user_id = $validated['user_id'];
                    $license->assigned_at = now();
                }
                
                if (isset($validated['expires_at'])) {
                    $license->expires_at = $validated['expires_at'];
                }
                
                if (isset($validated['activation_limit'])) {
                    $license->activation_limit = $validated['activation_limit'];
                }
                
                $license->save();
                $generatedCount++;
            }
            
            DB::commit();
            
            return redirect()->route('admin.licenses.index')
                ->with('success', "$generatedCount licenses generated successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to generate licenses: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified license.
     */
    public function edit(License $license)
    {
        $products = Product::orderBy('name')->get();
        $customers = User::where('role', 'customer')->orderBy('name')->get();
        
        return view('admin.licenses.edit', [
            'license' => $license,
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    /**
     * Update the specified license in storage.
     */
    public function update(Request $request, License $license)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['available', 'assigned', 'revoked'])],
            'user_id' => 'nullable|required_if:status,assigned|exists:users,id',
            'expires_at' => 'nullable|date',
            'activation_limit' => 'nullable|integer|min:1',
        ]);

        // If status is changing to assigned and it wasn't before, set assigned_at
        if ($validated['status'] === 'assigned' && $license->status !== 'assigned') {
            $license->assigned_at = now();
        }
        
        // If status is changing from assigned to something else, clear user_id and assigned_at
        if ($license->status === 'assigned' && $validated['status'] !== 'assigned') {
            $license->user_id = null;
            $license->assigned_at = null;
        }
        
        $license->status = $validated['status'];
        
        if ($validated['status'] === 'assigned' && isset($validated['user_id'])) {
            $license->user_id = $validated['user_id'];
        }
        
        if (isset($validated['expires_at'])) {
            $license->expires_at = $validated['expires_at'];
        }
        
        if (isset($validated['activation_limit'])) {
            $license->activation_limit = $validated['activation_limit'];
        }
        
        $license->save();
        
        return redirect()->route('admin.licenses.index')
            ->with('success', 'License updated successfully.');
    }

    /**
     * Remove the specified license from storage.
     */
    public function destroy(License $license)
    {
        // Only allow deletion if license is not assigned to a user or order
        if ($license->status === 'available') {
            $license->delete();
            return redirect()->route('admin.licenses.index')
                ->with('success', 'License deleted successfully.');
        }
        
        return redirect()->route('admin.licenses.index')
            ->with('error', 'Cannot delete a license that is already assigned or revoked.');
    }
}
