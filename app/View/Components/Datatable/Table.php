<?php

namespace App\View\Components\Datatable;

use Illuminate\View\Component;

class Table extends Component
{
    public $date_filter = [];
    public $idx, $source_url, $headers, $columns, $noDateFilter;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sourceUrl = "", $tableHeaders, $noDateFilter = false)
    {
        $this->source_url = $sourceUrl;
        $headers = json_decode(html_entity_decode($tableHeaders), true);
        [$headers, $column] = $this->tableHeaders($headers);
        $this->headers = $headers;
        $this->columns = json_encode($column);
        $this->noDateFilter = $noDateFilter;
        $this->setDefault();
    }

    public function tableHeaders(array $headers) {
        $v = "";
        foreach ($headers as $key => $value) {
            $isString = gettype($value) == "string";
            $noSort = $isString ? "" : (in_array('no-sort', $value) ? " class='no-sort'" : "");
            $v = $isString ? $v."<th>$value</th>" : $v."<th$noSort>$key</th>";
        }
        $reducer = function($head, $column, $v, $k) {
            $noSort = str_contains($k, "#") ? " class='no-sort' " : "";
            $header = str_replace("#", "", $k);
            $head = $head."<th$noSort>$header</th>";
            array_push($column, $v);
            return [$head, $column];
        };
        return collect($headers)->reduceSpread($reducer, "", []);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable.table');
    }

    public function setDefault() {
        $min_date_string = "2020-01-01";
        $now_date_string = now()->toDateString();
        $past_date_string = now()->subDay(30)->toDateString();
        $max_date_string = $now_date_string;

        $this->date_filter  = [
            "active" => true,
            "start_date" => $past_date_string,
            "end_date" => $now_date_string,
            "min_date" => $min_date_string,
            "max_date" => $max_date_string,
        ];

    }
}
