@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title font-neue">ნაშთების განახლების ისტორია</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="timeline">
                                    <ul class="timeline-list">
                                        @foreach($product_count_log_list as $log_item)
                                        <li class="timeline-item">
                                            <div class="timeline-status bg-primary"></div>
                                            <div class="timeline-date">{{ $log_item->created_at->format('d-m-y') }} <em class="icon ni ni-alarm-alt"></em></div>
                                            <div class="timeline-data">
                                                <h6 class="timeline-title font-neue">
                                                    <a href="{{ route('actionProductsBalanceHistoryList', $log_item->id) }}">ნაშთების ცვლილება - {{ $log_item->method }} - {{ $log_item->id }}</a>
                                                </h6>
                                                <div class="timeline-des">
                                                    <p><em class="icon ni ni-user-alt"></em> </p>
                                                    <span class="time">{{ $log_item->created_at->format('H:i:s') }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-bordered h-100">
                            <div class="card-inner border-bottom">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title font-neue">ფილტრი</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <form method="get" action="{{ route('actionProductsBalanceHistory') }}">
                                    <div class="form-group">
                                        <label class="form-label" for="log_date_from">თარიღი (დან)</label>
                                        <input type="date" name="log_date_from" id="log_date_from" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="log_date_to">თარიღი (მდე)</label>
                                        <input type="date" name="log_date_to" id="log_date_to" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="log_method">განაახლა</label>
                                        <select class="form-control" name="log_user" id="log_user">
                                            <option value="0"></option>
                                            <option value="1">Excel</option>
                                            <option value="2">Api</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="log_method">მეთოდი</label>
                                        <select class="form-control" name="log_method" id="log_method">
                                            <option value="0"></option>
                                            <option value="1">Excell</option>
                                            <option value="2">Api</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success font-helvetica-regular">გაფილტვრა</button>
                                </form>
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
<script type="text/javascript" src="{{ url('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection