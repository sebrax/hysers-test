<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    /**
     * Create a new contact.
     *
     * @param  array  $data
     * @return \App\Models\Contact
     */
    static public function createContact(array $data)
    {
        $contact = new Contact();
        $contact->name = $data['name'];
        $contact->email = $data['email'];
        $contact->phone = preg_replace('/\D/', '', $data['phone'] ?? '');
        return $contact->save() ? $contact : null;
    }

    /**
     * Update an existing contact.
     *
     * @param  \App\Models\Contact  $contact
     * @param  array  $data
     * @return \App\Models\Contact
     */
    static public function updateContact(Contact $contact, array $data)
    {
        $data['phone'] = preg_replace('/\D/', '', $data['phone'] ?? '');
        $contact->update($data);
        return $contact;
    }
}