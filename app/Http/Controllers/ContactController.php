<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
       
        return view('contact.index', compact('contacts'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData  = $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:contacts'
        ]);
        Contact::create($validatedData);
        return redirect()->route('contacts.index')->with('success', 'Contact added successfully');
    }
    

    public function importXML(Request $request)
    {
        $request->validate([
            'xml_file' => 'required'
        ]);

        $xmlContent = file_get_contents($request->file('xml_file')->getRealPath());
        $xml = simplexml_load_string($xmlContent);

        if (!$xml) {
            dd(libxml_get_errors());
        }

        if (isset($xml->contact)) {
            foreach ($xml->contact as $c) {
                Contact::updateOrCreate(
                    ['phone' => (string)$c->phone],
                    ['name' => (string)$c->name]
                );
            }
        }
        return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully');
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
    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Contact $contact)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required|unique:contacts,phone,'.$contact->id
    ]);

    $contact->update($request->all());
    return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
}

    public function destroy(Contact $contact)
   {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully');
    }

}
