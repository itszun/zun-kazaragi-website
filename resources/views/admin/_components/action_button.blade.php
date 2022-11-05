<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm" dropdown-toggle dropdown-icon data-toggle="dropdown"
        aria-expanded="false">Action <i class="fa fa-caret-down" style="margin-left:5px;"></i></button>

    <div class="dropdown-menu" role="menu" style="">
        @if (isset($buttons))
            @foreach ($buttons as $key => $val)
                <a class="dropdown-item text-capitalize" href="{{ $val['url'] ?? '#' }}"
                    @if ($key == 'hapus') onclick="Cemes.deleteItem()" @endif>
                    <i class="{{ $val['icon'] ?? 'fa fa-circle' }}" style="margin-right:5px;"></i>
                    {{ $key }}
                </a>
            @endforeach
        @endif
    </div>
</div>
