<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage; 

class ApplicationFormSettings extends Component
{
    use WithFileUploads;

    public $subject;
    public $body;
    public $attachment; // uploaded file
    public $currentAttachmentPath;

    protected $rules = [
        'subject'    => 'required|string|max:255',
        'body'       => 'required|string',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:20480',
    ];

    public function mount()
    {
        $this->subject = Setting::get('lead_app_email_subject', 'Application Form');
        $this->body    = Setting::get('lead_app_email_body', "Dear {{lead.name}},\n\nPlease find attached the application form.\n\nBest regards,\nBEE4Business");
        $this->currentAttachmentPath = Setting::get('lead_app_form_path'); // e.g. application_forms/Application_Form.pdf
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->attachment) {
                // deterministic name; always overwrite
                $ext  = $this->attachment->getClientOriginalExtension();
                $dir  = 'application_forms';
                $name = 'Application_Form.' . $ext;

                // Write directly via the Livewire UploadedFile helper to the *public* disk
                $storedPath = $this->attachment->storeAs($dir, $name, 'public'); // -> e.g. application_forms/Application_Form.pdf

                // Double-check it actually exists on disk
                $absolute = storage_path('app/public/' . $storedPath);
                if (!is_file($absolute)) {
                    $this->dispatchBrowserEvent('notify-error', ['message' => 'File was not persisted to disk.']);
                    return;
                }

                // Persist the relative path in settings
                Setting::set('lead_app_form_path', $storedPath);
                $this->currentAttachmentPath = $storedPath;

                // Clear the temp upload
                $this->reset('attachment');
            }

            // Always persist subject/body
            Setting::set('lead_app_email_subject', $this->subject);
            Setting::set('lead_app_email_body', $this->body);

            $this->dispatchBrowserEvent('notify-success', ['message' => 'Application email settings saved.']);
        } catch (\Throwable $e) {
            $this->dispatchBrowserEvent('notify-error', ['message' => 'Error saving settings: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.settings.application-form-settings');
    }

    public function updatedAttachment()
    {
        // Optional: live preview of the selected file name
        if ($this->attachment) {
            $this->currentAttachmentPath = 'application_forms/' . 'Application_Form.' . $this->attachment->getClientOriginalExtension();
        }
    }
}
