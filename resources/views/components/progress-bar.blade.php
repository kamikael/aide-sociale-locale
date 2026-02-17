@php
    $percentage = 0;
    if($target > 0){
        $percentage = ($collected / $target) * 100;
    }
@endphp

<div class="progress">
    <div class="progress-bar bg-success"
         role="progressbar"
         style="width: {{ $percentage }}%">
        {{ number_format($percentage, 0) }}%
    </div>
</div>
