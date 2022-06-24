
<?php
/**
 * Concrete Observers react to the updates issued by the Subject they had been
 * attached to.
 */
class NewRegistrationNotifier implements \SplObserver
{
    public function update(\SplSubject $subject)
    {
        if ($subject->state < 1) {
            //State less than 1 until registration is successful
        } else {
            //faris.sahovic@stu.ibu.edu.ba has been set as a test manager email
            Mail::send_new_registration_email($subject->additionalInfo, 'faris.sahovic@stu.ibu.edu.ba');
        }
    }
}
