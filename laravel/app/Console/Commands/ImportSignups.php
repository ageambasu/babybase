<?php

namespace App\Console\Commands;

use App\Baby;
use Illuminate\Console\Command;

class ImportSignups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:signups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import signups to the babybase from IMAP mail folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $host = config('signup.host');
        $username = config('signup.username');
        $password = config('signup.password');

        $this->mbox = imap_open($host, $username, $password);
        $this->process_new();
        $this->delete_old();
    }

    protected function process_new() {
        $search = 'UNFLAGGED SINCE "' . date("j F Y", strtotime("-14 days")) . '"';
        $emails = imap_search($this->mbox, $search, SE_UID);
        if(!empty($emails)){
            //Loop through the emails.
            foreach($emails as $email){
                //Fetch an overview of the email.
                $overview = imap_fetch_overview($this->mbox, $email, FT_UID);
                $overview = $overview[0];
                $subject =  implode(array_map(function($x) { return $x->text; }, imap_mime_header_decode($overview->subject)));

                if (strstr($subject, 'Ingevuld formulier') === false) {
                    continue;
                }

                try {
                    //Get the body of the email.
                    $message = imap_qprint(imap_fetchbody($this->mbox, $email, 1, FT_PEEK|FT_UID));
                    $fields = $this->parse_email($message, $subject);
                    $baby = Baby::create($this->validate($fields));

                    // flag email after processing, so that it isn't imported again
                    imap_setflag_full($this->mbox, $email, "\\Flagged", ST_UID);
                }
                catch (\Exception $e) {
                    print "Error processing email (UID $email): " . $e->getMessage() . "\n";
                }
            }
        }
    }

    protected function delete_old() {
        // for data privacy reasons, we don't want to keep signup emails for too long.
        // this will delete anything odler than 30 days
        $search = 'BEFORE "' . date("j F Y", strtotime("-30 days")) . '"';
        $emails = imap_search($this->mbox, $search, SE_UID);
        if(!empty($emails)){
            foreach($emails as $email){
                try {
                    imap_delete($this->mbox, $email, FT_UID);
                }
                catch (\Exception $e) {
                    print "Error processing email (UID $email): " . $e->getMessage() . "\n";
                }
            }
        }

        imap_expunge($this->mbox);
    }

    protected function validate($fields) {
        $validated = [
            'name' => $fields['baby_name'],
            'parent_firstname' => $fields['parent_first_name'],
            'parent_lastname' => $fields['parent_last_name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'monolingual_dutch' => $fields['multilingual'] != 'meertalig',
            'dob' => \Carbon\Carbon::createFromFormat($fields['dob_format'], $fields['dob']),
            'notes' => 'Languages: ' . $fields['languages'] . "\n\nNotes: " . $fields['notes'],
            'sex' => ['jongen' => 'Male', 'meisje' => 'Female', 'boy' => 'Male', 'girl' => 'Female'][$fields['gender']],
            'application_date' => \Carbon\Carbon::now(),
        ];
        return $validated;

    }

    protected function find_field($lines, $prompt, $optional=false) {
        $idx = array_search($prompt, $lines);
        if ($idx === false || $idx >= count($lines) - 1) {
            if ($optional) {
                return null;
            }
            throw new \Exception("Field '$prompt' not found");
        }
        return $lines[$idx+1];
    }

    protected function parse_email($message, $subject) {
        $lines = array_map('trim', explode("\r\n", $message));
        $nonempty = array_values(array_filter($lines));

        if (strstr($subject, 'babylab-leiden-en') !== false) {
            // English version
            $fields = [
                'parent_first_name' => $this->find_field($nonempty, 'Your first name'),
                'parent_last_name' => $this->find_field($nonempty, 'Your last name'),
                'baby_name' => $this->find_field($nonempty, 'Name of your child'),
                'dob' => $this->find_field($nonempty, 'Date of birth of your child'),
                'dob_format' => 'd/m/Y',
                'gender' => $this->find_field($nonempty, 'Gender of your child'),
                'phone' => $this->find_field($nonempty, 'Telephone number'),
                'email' => $this->find_field($nonempty, 'Email'),
                'multilingual' => $this->find_field($nonempty, 'Is your child raised:'),
                'languages' => $this->find_field($nonempty, 'With which languages is your child being raised?', true),
                'notes' => $this->find_field($nonempty, 'Questions and/or remarks', true),
                'recruitment_source' => $this->find_field($nonempty, 'Where did you first hear about the Babylab?')
            ];
        }
        else {
            // Dutch version
            $fields = [
                'parent_first_name' => $this->find_field($nonempty, 'Uw voornaam'),
                'parent_last_name' => $this->find_field($nonempty, 'Uw achternaam'),
                'baby_name' => $this->find_field($nonempty, 'Naam van uw baby'),
                'dob' => $this->find_field($nonempty, 'Geboortedatum van uw baby'),
                'dob_format' => 'd-m-Y',
                'gender' => $this->find_field($nonempty, 'Geslacht van uw baby'),
                'phone' => $this->find_field($nonempty, 'Telefoonnummer'),
                'email' => $this->find_field($nonempty, 'E-mailadres'),
                'multilingual' => $this->find_field($nonempty, 'Hoe wordt uw baby opgevoed?'),
                'languages' => $this->find_field($nonempty, 'Met welke talen wordt uw baby opgevoed?', true),
                'notes' => $this->find_field($nonempty, 'Vragen en/of opmerkingen', true),
                'recruitment_source' => $this->find_field($nonempty, 'Hoe bent u terecht gekomen bij Babylab?')
            ];
        }

        $fields['phone'] = preg_replace('/[^0-9]/', '', $fields['phone']);
        $fields['email'] = preg_replace('/<.*>/', '', $fields['email']);
        return $fields;
    }
}
