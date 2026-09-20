<?php

namespace App\View\Components;

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
        public $data,
        public $data2,
    ) {
        logger($data);
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
