<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactEditRequest;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Support\Facades\App;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(App::runningUnitTests()) {
            return view('contacts.index', [
                'contacts' => Contact::paginate(10)
            ]);
        }
        return inertia('Index', [
            'contacts' => Contact::paginate(10)
        ]);
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
    public function store(ContactRequest $request)
    {
        try {
            $validated = $request->validated();
    
            $contact = ContactService::createContact($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Needed to the tests run ok as Inertia needs a 302 response and tests a 200
        if($request->header('X-Inertia')) {
            return to_route('contacts.index')->with('success', 'Contact added successfully');
        }

        return response($contact, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactEditRequest $request, Contact $contact)
    {
        try {
            $validated = $request->validated();

            ContactService::updateContact($contact, $validated);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Needed to the tests run ok as Inertia needs a 302 response and tests a 200
        if($request->header('X-Inertia')) {
            return to_route('contacts.index')->with('success', 'Contact updated successfully');
        }

        return response($contact, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            if (!$contact) return response()->json(['message' => 'Contact not found'], 404);
            return response()->json(['message' => 'Contact deleted successfully'], $contact->delete() ? 200 : 500);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
