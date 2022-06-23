<?php
class Subject implements \SplSubject
{
    public $state;

    public $additionalInfo;
    
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function someBusinessLogic($code, $text)
    {
        $this->state = $code;
        $this->additionalInfo = $text;
        $this->notify();
    }
}