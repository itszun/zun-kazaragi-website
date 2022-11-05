@php
    $idx = random_int(100,999);
    $noDateFilter = true;
@endphp
<div>
    <form id="filter-{{ $idx }}" class="data-table-change row justify-content-start">
        <div class="col-12 row">
            {{ $slot }}
            @if (!$noDateFilter)

            <div class="form-group col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1" style="margin-bottom: 10px;">
                <label>Dari</label>
                <input class="form-control" type="date" id="start" name="date_from"
                    value="{{ $date_filter['start_date'] }}" min="{{ $date_filter['min_date'] }}"
                    max="{{ $date_filter['max_date'] }}">
            </div>
            <div class="form-group col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1" style="margin-bottom: 10px;">
                <label>Sampai</label>
                <input class="form-control" type="date" id="start" name="date_to"
                    value="{{ $date_filter['end_date'] }}" min="{{ $date_filter['min_date'] }}"
                    max="{{ $date_filter['max_date'] }}">
            </div>
            @endif

            <div class="form-group col-12 col-md-4 col-xl-3 col-xxl-1" style="margin-bottom: 10px;">
                <label>Pencarian</label>
                <div class="input-group">
                    <input type="text" name="keyword" id="keyword" class=" form-control"
                        placeholder="Cari berdasarkan kata kunci" value="{{ request()->get('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"
                                style="margin-right:5px"></i>Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row align-items-center d-none">
            <hr class="col d-none d-sm-block">
            <div class="col-12 col-sm-3 col-lg-2 col-xl-1 col-xxl-1 text-gray">
                <a class="collapsed btn btn-block btn-default btn-sm" data-toggle="collapse" href="#collapseFilter" aria-expanded="false">
                    <i class="fa fa-filter"></i> Filter
                </a>
            </div>
            <hr class="col d-block d-sm-none">
        </div>
        <div class="col-12 row mt-2 pb-2 collapse" id="collapseFilter">
        </div>

        <div class="col-12">
            <hr>
        </div>
    </form>

    <div class="scroll-x-table">
        <table class="table table-bordered table-striped table-condensed"
            cemes="datatable"
            cemes-columns="{{ $columns }}"
            cemes-source-url="{{ $source_url }}"
            cemes-filter-form="#filter-{{ $idx }}"
            id="datatable-table-{{ $idx }}"
            width="100%">
            <thead>
                <tr>
                    {!! $headers !!}
                </tr>
            </thead>
            <tbody id="datatable-body-{{$idx}}" class="datatable-body">
            </tbody>
        </table>
        <br>
    </div>
</div>
