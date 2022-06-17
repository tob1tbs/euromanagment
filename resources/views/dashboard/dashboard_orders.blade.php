@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-fmg">
                    <div class="nk-fmg-body">
                        <div class="nk-fmg-body-content">
                            <div class="nk-fmg-listing nk-block-lg">
                                <div class="nk-block-head-xs">
                                    <div class="nk-block-between g-2">
                                        <div class="nk-block-head-content">
                                            <h6 class="nk-block-title title font-neue">შეკვეთების ისტორია</h6>
                                        </div>

                                    </div>
                                </div>
                                <form action="#">
                                    <div class="row g-4">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="order_year">წელი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_year" name="order_year">
                                                        @foreach($year_list as $year_item)
                                                        <option value="{{ $year_item }}" @if(empty(request()->order_year)) @if($current_date->format('Y') == $year_item) selected @endif @else @if(request()->order_year == $year_item) selected @endif @endif>{{ $year_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="order_month">თვე</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_month" name="order_month">
                                                        @foreach($month_list as $month_key => $month_item)
                                                        <option value="{{ $month_key }}" @if(empty(request()->order_month)) @if($current_date->format('m') == $month_key) selected @endif @else @if(request()->order_month == $month_key) selected @endif @endif>{{ $month_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="order_status">შეკვეთის სტატუსი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_status" name="order_status">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="order_search_query">სწრაფი ძებნა</label>
                                                <div class="form-control-wrap ">
                                                    <input type="text" class="form-control" id="order_search_query" name="order_search_query" value="{{ request()->order_search_query }}" placeholder="სახელი, გვარი, პირადი ნომერი, სხვა...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label" for="pay-amount-1">&nbsp;</label>
                                                <div class="form-control-wrap">
                                                    <button type="submit" class="btn btn-success font-neue">ძებნა</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="tab-content">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('js')

@endsection