@foreach($items as $item)
    <li {{ (URL::current() == $item->url() ? "class=active": '') }}> {{-- ete grvi css kstacvi active menu-i @ndgcum --}}
        <a href="{{ $item->url() }}">{{ $item->title }}</a>
    @if($item->hasChildren())
        <ul class="sub-menu">
            {{--ete uni child recursive include karvi verjum vercneluv menak child-er children() functiayov--}}
            @include(env('THEME').'.customMenuItems',['items'=>$item->children()])
        </ul>
        @endif
    </li>
    @endforeach