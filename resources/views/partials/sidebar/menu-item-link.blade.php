<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
    
    <a class="nav-link @isset($item['class']) {{ $item['class'] }} @endisset @isset($item['shift']) {{ $item['shift'] }} @endisset @if(checkRequestUrl($item['active']??[],request()->path())) bg-success @endif"
       href="@isset($item['href']) {{ $item['href'] }} @endisset" @isset($item['target']) target="{{ $item['target'] }}" @endisset
       {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}

            @isset($item['label'])
                <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">
                    {{ $item['label'] }}
                </span>
            @endisset
        </p>

    </a>

</li>
