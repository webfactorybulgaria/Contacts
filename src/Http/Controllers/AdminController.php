<?php

namespace TypiCMS\Modules\Contacts\Http\Controllers;

use TypiCMS\Modules\Contacts\Custom\Http\Requests\FormRequest;
use TypiCMS\Modules\Contacts\Custom\Models\Contact;
use TypiCMS\Modules\Contacts\Custom\Repositories\ContactInterface;
use TypiCMS\Modules\Core\Custom\Http\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{
    public function __construct(ContactInterface $contact)
    {
        parent::__construct($contact);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('contacts::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('contacts::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Contacts\Custom\Models\Contact $contact
     *
     * @return \Illuminate\View\View
     */
    public function edit(Contact $contact)
    {
        return view('contacts::admin.edit')
            ->with(['model' => $contact]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Contacts\Custom\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $contact = $this->repository->create($request->all());

        return $this->redirect($request, $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Contacts\Custom\Models\Contact            $contact
     * @param \TypiCMS\Modules\Contacts\Custom\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Contact $contact, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $contact);
    }
}
