<?php

namespace App\View\Components;

use App\Services\Service1;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SampleComponent extends Component
{
    public $answer;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Service1 $service1,
        public $data,
        public $data2,
    ) {

        logger(get_class($service1));
        $this->answer = $this->data . $this->data2 . 'is answer';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sample-component', [
            'data' => $this->data,
            'data2' => $this->data2,
            'answer' => $this->answer,
        ]);
    }
}
